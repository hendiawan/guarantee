<?php

namespace App\Http\Controllers; 
use App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\penjaminans;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\rate;
use DateTime;
use Storage;
use App\pembayarans;
use App\kesehatans;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\terjamins;
use App\cetaks;
use Illuminate\Support\Facades\File;
use App\t_history_banks;

class laporanController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function tanggal($tgl) {
        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }
    public function simpanlogcetak(request $request) {
        
        $id = $request->id;
        $cetak = new cetaks();
        $cetak->idpenjaminan = $id;
        $cetak->tglcetak = date('Y-m-d H:i:s');
        $cetak->oleh = session::get('name') . '/' . session::get('nama');
        $cetak->keterangan = 'Sertifikat';
        $cetak->save();
        
    }
    public function tampillogcetak($id) {
        
              $pengajuan = penjaminans::where('nosertifikat',$id)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->rightJoin('cetaks', 'cetaks.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('sertifikats.id', 'desc')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->take(50)
                ->get(); 
              return view('user.detailcetak',['data'=>$pengajuan]);
        
    }
    
    public function cetaklaporan(Request $request) 
    { 
        $dari   = self::tanggal($request->dari);
        $sampai = date ('Y-m-d 23:59:59.000',strtotime(self::tanggal($request->sampai))); 
        
        if ($request->jenislaporan=='INTERNAL')
        { 
                $penjaminan = penjaminans::whereBetween(DB::raw('DATE(sertifikats.tglterbit)'), [$dari, $sampai]) 
                ->where
                ([
                    ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],                    
                    ($request->bank=='%') ? 
                    ['penjaminans.idbank','like',"%$request->bank%"]:
                    ['penjaminans.idbank',$request->bank],   
                 ])
                 ->wherein('penjaminans.app',['Lunas','Cetak'])   
                ->join('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->orderBy('banks.kodepusat') 
                ->groupBy('penjaminans.idbank')     
                ->select(
                 '*', 
                 'penjaminans.idbank', 
                 'banks.namabank', 
                 \DB::raw('count(*) as total'),
                 \DB::raw('sum(plafon) as total_plafon'),
                 \DB::raw('sum(premi) as total_premi'),
                 \DB::raw('sum(pot) as total_pot'),
                 \DB::raw('sum(nett) as total_nett'),
                 \DB::raw('count(nosertifikat) as total_terjamin'))
                ->get(); 
                return view('admin.laporan.laporan_internal', [
                    'data'          => $penjaminan,
                    'dari'           => $dari,
                    'sampai'    => $sampai,
                    'jenis'         => $request->jenisKredit,
                    'app'           => 'INTERNAL',
                    'bank'         => $request->bank,
                ]); 
        } 
        else IF ($request->jenislaporan=='CASE')
        {
//            dd($querybank);
                $penjaminan = penjaminans::whereBetween('sertifikats.tglterbit',[$dari, $sampai]) 
                ->where
                ([
                    ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],                    
                    ($request->bank=='%') ?
                    ['penjaminans.idbank','like',"%$request->bank%"]:
                    ['penjaminans.idbank',$request->bank],  
                 ])
                 ->wherein('penjaminans.app',['Lunas','Cetak'])  
                 ->where('penjaminans.case','Ya')  
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->groupBy('penjaminans.idbank')     
                ->orderBy('banks.kodepusat') 
                ->select(
                 '*', 
                 'penjaminans.idbank', 
                 'banks.namabank', 
                 \DB::raw('count(*) as total'),
                 \DB::raw('sum(plafon) as total_plafon'),
                 \DB::raw('sum(premi) as total_premi'),
                 \DB::raw('sum(pot) as total_pot'),
                 \DB::raw('sum(nett) as total_nett'),
                 \DB::raw('count(nosertifikat) as total_terjamin'))
                ->get();
//                dd($penjaminan);
                return view('admin.laporan.laporan_internal', [
                    'data'          => $penjaminan,
                    'dari'          => $dari,
                    'sampai'    => $sampai,
                    'jenis'         => $request->jenisKredit,
                    'app'           => 'CASE',
                    'bank'         => $request->bank,
                ]);
                
        }
        else
        { 
            
                $penjaminan = penjaminans::with(['terjamin','sertifikat','bank'])
                              ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                              ->where
                                    ([
                                        ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                                        ($request->bank=='%') ?
                                        ['penjaminans.idbank','like',"%$request->bank%"]:
                                        ['penjaminans.idbank',$request->bank],  
                                     ])
                             ->wherein('penjaminans.app',['Lunas','Cetak'])     
                             ->whereBetween('sertifikats.tglterbit', [$dari, $sampai])
                             ->orderBy('sertifikats.id','asc') 
                             ->get();    
                            return view('admin.laporan.laporan', [
                                'data' => $penjaminan,
                                'dari' => $dari,
                                'sampai' => $sampai,
                                'jenis' => $request->jenisKredit,
                                'app' => $request->jenislaporan,
                                'bank' => $request->bank,
                            ]);
        }
      
    }
    
    public function cetaklaporanexcel(request $request) 
    {
//         dd($request);
        $dari   = $request->dari;
         $sampai = date ('Y-m-d 23:59:59.000',strtotime($request->sampai));
        
        if($request->jenislaporan=='INTERNAL')
        { 
               $penjaminan = penjaminans::whereBetween('sertifikats.tglterbit',[$dari, $sampai]) 
                ->where
                ([
                    ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                    ($request->bank=='%')?
                        ['penjaminans.idbank', 'like',  '%' . $request->bank]:
                        ['penjaminans.idbank',$request->bank], 
                 ])
                ->wherein('penjaminans.app',['Lunas','Cetak'])   
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->groupBy('penjaminans.idbank')     
                ->orderBy('banks.kodepusat')   
                ->select(
                 '*', 
                 'penjaminans.idbank', 
                 'banks.namabank', 
                 \DB::raw('count(*) as total'),
                 \DB::raw('sum(plafon) as total_plafon'),
                 \DB::raw('sum(premi) as total_premi'),
                 \DB::raw('sum(pot) as total_pot'),
                 \DB::raw('sum(nett) as total_nett'),
                 \DB::raw('count(nosertifikat) as total_terjamin'))
                ->get()->toArray();
           
             //untuk melakukan pengulangan sheet
            return Excel::create('Rekap Kredit '.$request->jenisKredit, 
                    function($excel) use($penjaminan,$dari, $sampai,$request) {
               
             $this->create_sheet_laporan_internal($excel,$penjaminan,$request);
             $this->create_sheet_detail_laporan($excel,$penjaminan,$dari,$sampai,$request);
           
                    })->download('xls');
                
        }
        else if($request->jenislaporan=='CASE')
        { 
               $penjaminan = penjaminans::whereBetween('sertifikats.tglterbit',[$dari, $sampai]) 
                ->where
                ([
                    ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                    ($request->bank=='%')?['penjaminans.idbank', 'like',  '%' . $request->bank]:['penjaminans.idbank',$request->bank],
                 ])
                ->wherein('penjaminans.app',['Lunas','Cetak'])  
                ->where('penjaminans.case','Ya')  
//                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->groupBy('penjaminans.idbank')     
                ->orderBy('banks.kodepusat')   
                ->select(
                 '*', 
                 'penjaminans.idbank', 
                 'banks.namabank', 
                 \DB::raw('count(*) as total'),
                 \DB::raw('sum(plafon) as total_plafon'),
                 \DB::raw('sum(premi) as total_premi'),
                 \DB::raw('sum(pot) as total_pot'),
                 \DB::raw('sum(nett) as total_nett'),
                 \DB::raw('count(nosertifikat) as total_terjamin'))
                ->get()->toArray();
              
             //untuk melakukan pengulangan sheet
//               dd($request->jenisKredit);
            return Excel::create('Rekap Kredit '.$request->jenisKredit, function($excel) use($penjaminan,$dari, $sampai,$request) {
             $this->create_sheet_laporan_internal($excel,$penjaminan,$request);
             $this->create_sheet_detail_laporan($excel,$penjaminan,$dari,$sampai,$request); 
                    })->download('xls');
                
        }
        else
        {
             $sertifikat = penjaminans::
                        select(
                                'ktp', 
                                'kodekas',
                                'tglterbit',
                                'tglpk',
                                'banks.admin',
                                'banks.materai', 
                                'share', 
                                'kd_penerima', 
                                'kodesertifikat', 
                                'nama', 
                                'alamat', 
                                'tgllahir', 
                                'umur', 
                                'pekerjaan', 
                                'jeniskredit',
                                'tglrealisasi', 
                                'tgljatuhtempo',
                                'masakredit', 
                                'nopk', 
                                'plafon', 
                                'banks.dis', 
                                'banks.admin', 
                                'banks.materai', 
                                'users.kodeuser', 
                                'rate', 
                                'premi', 
                                'pot', 
                                'catatan', 
                                'tanggapandir', 
                                'case', 
                                'nett')
//                        ->whereBetween('tglpengajuan', array($dari, $sampai))
                        ->whereBetween('sertifikats.tglterbit',[$dari, $sampai])
                        ->where(
                                [
                                    [ 'jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                                    [ 'penjaminans.idbank', 'like', '%' . $request->bank . '%'],
                                ]
                               )
                         ->wherein('penjaminans.app',['Lunas','Cetak'])  
                        ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                        ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                        ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                        ->leftJoin('users', 'users.name', '=', 'sertifikats.diterbitkan')
                     
                        ->get()->toArray();
         
        return Excel::create('datapenjaminan', function($excel) use($sertifikat) {
                  $this->create_sheet_terjamin($excel,$sertifikat);
                  $this->create_sheet_penjaminan($excel,$sertifikat);
                  $this->create_sheet_verifikasi_kasi($excel,$sertifikat);
                  $this->create_sheet_verifikasi_keuangan($excel,$sertifikat);
                })->download('xls');
        }
       
    } 
    
    public function create_sheet_detail_laporan($excel,$penjaminan,$dari,$sampai,$request) 
    {
          
//        dd($request);
          $nomor=1;
          foreach ($penjaminan as $key => $value)
          {   
                        $penjaminan_sheet = penjaminans::with(['terjamin','sertifikat','bank'])
                              ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                                 ->where
                                              ([ 
                                                      ['penjaminans.jeniskredit', 'like', '%' . $request->jenisKredit . '%' ],
                                                      ['penjaminans.idbank', $value['idbank']],
                                                      ($request->jenislaporan=='CASE'?
                                                              ['penjaminans.case','Ya']:
                                                              ['penjaminans.case', 'like','%']) 
                                              ])
                             ->wherein('penjaminans.app',['Lunas','Cetak'])     
                             ->whereBetween('sertifikats.tglterbit', [$dari, $sampai])
                             ->orderBy('sertifikats.id','desc') 
                             ->get();  

                    
                            $namabank = strtoupper($value['namabank']);
                            $namasheet = substr($value['namabank'],0,31);
                            $namasheet =  ucwords(strtolower($namasheet)); 
                            $namasheet = str_replace(' ', '', $namasheet);
//                            $namasheet='BPR'.$nomor;
//                            $namasheet=$namabank;
//                          dd($namabank);
                            $excel->sheet($namasheet, function($sheet) use($penjaminan_sheet,$namabank,$dari,$sampai,$request) {
                        
                                 
                                $sheet->mergeCells('A1:D1')->cell('A1', function($cell) use($namabank,$request) {
                                    $cell->setValue(($request->jenisKredit=='%')?'LAPORAN PENJAMINAN KREDIT PRODUKTIF & KONSUMTIF '.' :'.$namabank:'LAPORAN PENJAMINAN KREDIT '.$request->jenisKredit.' :'.$namabank);
                                });
                             
                                $sheet->mergeCells('A2:D2')->cell('A2', function($cell) use ($dari,$sampai) {
                                    $cell->setValue('PERIODE : '.date('d-m-Y',strtotime($dari)).' (S/D) '.date('d-m-Y',strtotime($sampai)));
                                });
                                $sheet->cell('A4', function($cell) {
                                    $cell->setValue('NO');
                                });
                                $sheet->cell('B4', function($cell) {
                                    $cell->setValue('NOMOR SERTIFIKAT');
                                });
                                $sheet->cell('C4', function($cell) {
                                    $cell->setValue('NAMA TERJAMIN');
                                });
                                $sheet->cell('D4', function($cell) {
                                    $cell->setValue('TGL REALISASI');
                                });
                                $sheet->cell('E4', function($cell) {
                                    $cell->setValue('TGL JATUH TEMPO');
                                });
                                $sheet->cell('F4', function($cell) {
                                    $cell->setValue('PLAFON');
                                });
                                $sheet->cell('G4', function($cell) {
                                    $cell->setValue('RATE');
                                });
                                $sheet->cell('H4', function($cell) {
                                    $cell->setValue('GROSS IJP');
                                });
                                $sheet->cell('I4', function($cell) {
                                    $cell->setValue('POTONGAN');
                                });

                                $sheet->cell('J4', function($cell) {
                                    $cell->setValue('NETT IJP');
                                }); 
                                 $sheet->cell('K4', function($cell) {
                                     $cell->setValue('ANALISA');
                                 });
                                 $sheet->cell('L4', function($cell) {
                                     $cell->setValue('APPROVAL');
                                 });  
//                                dd($penjaminan_sheet[0]['case']);
//                                if($penjaminan_sheet[0]['case']=='Ya')
//                               {
//                               }
                                     
//                                 dd($penjaminan_sheet[0]['case']);
                                 
                             if (!empty($penjaminan_sheet)) {
                             
                                $totalpenjaminan   =0;
                                $totalgrossijp  = 0;
                                $totaldis       = 0;
                                $totalnetijp    = 0;
                                $a=0;
                                foreach ($penjaminan_sheet as $key => $value) {
//                                    dd($value['terjamin']['nama']);
                                    $i = $key + 5;
                                    $no = $key + 1;
                                    $sheet->cell('A' . $i, $no);
                                    $sheet->cell('B' . $i, $value['kodesertifikat']);
                                    $sheet->cell('C' . $i, $value['terjamin']['nama']);
                                    $sheet->cell('D' . $i, $value['tglrealisasi']);
                                    $sheet->cell('E' . $i, $value['tgljatuhtempo']);
                                    $sheet->cell('F' . $i, number_format($value['plafon'], 0, '.', ','));
                                    $sheet->cell('G' . $i, $value['rate']);
                                    $sheet->cell('H' . $i, number_format($value['premi'], 0, '.', ','));
                                    $sheet->cell('I' . $i, number_format($value['pot'], 0, '.', ','));
                                    $sheet->cell('J' . $i, number_format($value['nett'], 0, '.', ','));
                                    if($value['case']=='Ya')
                                    {
                                     $sheet->cell('K' . $i,  $value['catatan']);
                                     $sheet->cell('L' . $i,  $value['tanggapandir']);
                                    }

                                    $totalpenjaminan = $totalpenjaminan + $value['plafon'];
                                    $totalgrossijp = $totalgrossijp + $value['premi'];
                                    $totaldis = $totaldis + $value['pot'];
                                    $totalnetijp = $totalnetijp + $value['nett'];
                                    $a = $i + 1;
                                }
                                $sheet->cell('A' . $a, '');
                                $sheet->cell('B' . $a, 'TOTAL');
                                $sheet->cell('F' . $a, number_format($totalpenjaminan, 0, '.', ','));
                                $sheet->cell('H' . $a, number_format($totalgrossijp, 0, '.', ','));
                                $sheet->cell('I' . $a, number_format($totaldis, 0, '.', ','));
                                $sheet->cell('J' . $a, number_format($totalnetijp, 0, '.', ','));
                            }
                        });
                        $nomor++;
                        }
    }
    
    public function create_sheet_laporan_internal($excel,$penjaminan,$request) 
    {
  
    $excel->sheet(($request->jenisKredit=='%')?
            'LAPORAN PENJAMINAN ALL':
            'LAPORAN PENJAMINAN '.$request->jenisKredit, function($sheet) use($penjaminan,$request) 
             {   
                        $sheet->mergeCells('A1:D1')->cell('A1', function($cell) use($request) {
//                            dd($request->jenisKredit);
                                    $cell->setValue(($request->jenisKredit=='%')?
                                            'LAPORAN PENJAMINAN KREDIT PRODUKTIF DAN KONSUMTIF':
                                            'LAPORAN PENJAMINAN KREDIT '.$request->jenisKredit);
                                }); 
                        $sheet->mergeCells('A2:D2')->cell('A2', function($cell) use ($request) {
                                    $cell->setValue('PERIODE : '.date('d-m-Y',strtotime($request->dari)).' (S/D) '.date('d-m-Y',strtotime($request->sampai)));
                                });
                        $sheet->cell('A4', function($cell) {
                            $cell->setValue('NO');
                        });
                        $sheet->cell('B4', function($cell) {
                            $cell->setValue('NAMA PENERIMA');
                        });
                        $sheet->cell('C4', function($cell) {
                            $cell->setValue('TOTAL PLAFON');
                        });
                        $sheet->cell('D4', function($cell) {
                            $cell->setValue('TOTAL GROSS IJP');
                        });
                        $sheet->cell('E4', function($cell) {
                            $cell->setValue('TOTAL DISCOUNT');
                        });
                        $sheet->cell('F4', function($cell) {
                            $cell->setValue('TOTAL NETT');
                        });
                        $sheet->cell('G4', function($cell) {
                            $cell->setValue('JUMLAH TERJAMIN');
                        });

                        if (!empty($penjaminan)) { 
                            $totalpenjaminan     =0;
                            $totalgrossijp            =0;
                            $totaldis                     =0;
                            $totalnetijp               =0;
                            $totalterjamin          =0;
                            
                            foreach ($penjaminan as $key => $value) {
                                $i = $key + 5;
                                $no = $key + 1;
                                $sheet->cell('A' . $i, $no);
                                $sheet->cell('B' . $i, $value['namabank']);
                                $sheet->cell('C' . $i, number_format($value['total_plafon'], 0, '.', ','));
                                $sheet->cell('D' . $i, number_format($value['total_premi'], 0, '.', ','));
                                $sheet->cell('E' . $i, number_format($value['total_pot'], 0, '.', ','));
                                $sheet->cell('F' . $i, number_format($value['total_nett'], 0, '.', ','));
                                $sheet->cell('G' . $i, $value['total_terjamin']);
                                
                                $totalpenjaminan    =$totalpenjaminan   +$value['total_plafon'];
                                $totalgrossijp      =$totalgrossijp     +$value['total_premi'];
                                $totaldis           =$totaldis          +$value['total_pot'];
                                $totalnetijp        =$totalnetijp       +$value['total_nett'];
                                $totalterjamin      =$totalterjamin     +$value['total_terjamin'];
                                $a=$i+1;
                            
                            }
                                $sheet->cell('A' . $a, '');
                                $sheet->cell('B' . $a, 'TOTAL');
                                $sheet->cell('C' . $a,  number_format($totalpenjaminan, 0, '.', ','));
                                $sheet->cell('D' . $a,  number_format($totalgrossijp, 0, '.', ','));
                                $sheet->cell('E' . $a,  number_format($totaldis, 0, '.', ','));
                                $sheet->cell('F' . $a,  number_format($totalnetijp, 0, '.', ','));
                                $sheet->cell('G' . $a, $totalterjamin);
                           
                        }
                    });
        
    } 
    
    public function create_sheet_terjamin($excel,$a)  
    { 
          $excel->sheet('Terjamin', function($sheet) use($a) 
                      {
                        $sheet->cell('A1', function($cell) {
                            $cell->setValue('KODE TERJAMIN');
                        });
                        $sheet->cell('B1', function($cell) {
                            $cell->setValue('KODE KOTA');
                        });
                        $sheet->cell('C1', function($cell) {
                            $cell->setValue('NAMA');
                        });
                        $sheet->cell('D1', function($cell) {
                            $cell->setValue('KONTAK');
                        });
                        $sheet->cell('E1', function($cell) {
                            $cell->setValue('NPWP');
                        });
                        $sheet->cell('F1', function($cell) {
                            $cell->setValue('ALAMAT');
                        });
                        $sheet->cell('G1', function($cell) {
                            $cell->setValue('FAX');
                        });
                        $sheet->cell('H1', function($cell) {
                            $cell->setValue('TELEPON');
                        });
                        $sheet->cell('I1', function($cell) {
                            $cell->setValue('EMAIL');
                        });
                        $sheet->cell('J1', function($cell) {
                            $cell->setValue('LAHIR');
                        });
                        $sheet->cell('K1', function($cell) {
                            $cell->setValue('PERUSAHAAN');
                        });
                        $sheet->cell('L1', function($cell) {
                            $cell->setValue('JENIS USAHA');
                        });
                        $sheet->cell('M1', function($cell) {
                            $cell->setValue('NOMOR');
                        });
                        $sheet->cell('N1', function($cell) {
                            $cell->setValue('DIREKTUR');
                        });
                        $sheet->cell('O1', function($cell) {
                            $cell->setValue('STATUS');
                        });

                        $sheet->cell('P1', function($cell) {
                            $cell->setValue('KET');
                        });
                        $sheet->cell('Q1', function($cell) {
                            $cell->setValue('DAFTAR');
                        });
                        $sheet->cell('R1', function($cell) {
                            $cell->setValue('REF');
                        });
                   
                            $b=0;
                        if (!empty($a)) {
                            
                            foreach ($a as $key => $value) {
                                $i = $key + 2;
                                $no = $key + 1;
                          
                                
                                $alfabet='TCA';
                                $notrx=str_pad($no, 3, '0', STR_PAD_LEFT);
                                
                                if ($notrx<999)
                                {
                                   $kode_terjamin=$alfabet.$notrx; 
                                }
                                else
                                {
                                 
                                  $b = $b + 1;
                                  $notrx=str_pad($b, 3, '0', STR_PAD_LEFT);
                                  
                                  $kode_terjamin=++$alfabet.$notrx;   
                                }
                                  
                                $sheet->cell('A' . $i, $kode_terjamin);
                                $sheet->cell('B' . $i, 'KAA022');
                                $sheet->cell('C' . $i, $value['nama']);
                                $sheet->cell('D' . $i, '-');
                                $sheet->cell('E' . $i, '-');
                                $sheet->cell('F' . $i, $value['alamat']);
                                $sheet->cell('G' . $i, '-');
                                $sheet->cell('H' . $i, '-');
                                $sheet->cell('I' . $i, '-');
                                $sheet->cell('J' . $i, date('Y/m/d', strtotime($value['tgllahir'])));
                                $sheet->cell('K' . $i, '-');
                                $sheet->cell('L' . $i, $value['pekerjaan']);
                                $sheet->cell('M' . $i, '-');
                                $sheet->cell('N' . $i, '-');
                                $sheet->cell('O' . $i, '2');
                                $sheet->cell('P' . $i, '-');
                                $sheet->cell('Q' . $i, date('Y/m/d', strtotime($value['tglterbit'])));
                                $sheet->cell('R' . $i, 'TAC645');
                            }
                        }
                    });
        
    } 
    
    public function create_sheet_penjaminan($excel,$sertifikat) 
    {
        
                    $excel->sheet('penjaminan', function($sheet) use($sertifikat) 
                     {
                        $sheet->cell('A1', function($cell) {
                            $cell->setValue('NO TRX');
                        });
                        $sheet->cell('B1', function($cell) {
                            $cell->setValue('DEVISI');
                        });
                        $sheet->cell('C1', function($cell) {
                            $cell->setValue('PNRMA');
                        });
                        $sheet->cell('D1', function($cell) {
                            $cell->setValue('TRJAMIN');
                        });
                        $sheet->cell('E1', function($cell) {
                            $cell->setValue('KD PRDK');
                        });
                        $sheet->cell('F1', function($cell) {
                            $cell->setValue('NO SERTIFIKAT');
                        });
                        $sheet->cell('G1', function($cell) {
                            $cell->setValue('TGL SERTIFIKAT');
                        });
                        $sheet->cell('H1', function($cell) {
                            $cell->setValue('TANGGAL');
                        });
                        $sheet->cell('I1', function($cell) {
                            $cell->setValue('MULAI');
                        });
                        $sheet->cell('J1', function($cell) {
                            $cell->setValue('AKHIR');
                        });
                        $sheet->cell('K1', function($cell) {
                            $cell->setValue('RATE');
                        });
                        $sheet->cell('L1', function($cell) {
                            $cell->setValue('IJP GROS');
                        });
                        $sheet->cell('M1', function($cell) {
                            $cell->setValue('NET IJP');
                        });
                        $sheet->cell('N1', function($cell) {
                            $cell->setValue('NILAI PENJMN');
                        });
                        $sheet->cell('O1', function($cell) {
                            $cell->setValue('PENJAMINAN');
                        });
                        $sheet->cell('P1', function($cell) {
                            $cell->setValue('DISKON');
                        });
                        $sheet->cell('Q1', function($cell) {
                            $cell->setValue('BIAYA1');
                        });
                        $sheet->cell('R1', function($cell) {
                            $cell->setValue('BIAYA2');
                        });
                        $sheet->cell('S1', function($cell) {
                            $cell->setValue('BIAYA3');
                        });
                        $sheet->cell('T1', function($cell) {
                            $cell->setValue('KET');
                        });
                        $sheet->cell('U1', function($cell) {
                            $cell->setValue('KODE USER');
                        });
                        $sheet->cell('V1', function($cell) {
                            $cell->setValue('JENIS');
                        });
                        $sheet->cell('W1', function($cell) {
                            $cell->setValue('NO.PRMINTAAN');
                        });
                        $sheet->cell('X1', function($cell) {
                            $cell->setValue('TGLPRMINTAAN');
                        });
                        $sheet->cell('Y1', function($cell) {
                            $cell->setValue('NO. PERJANJIAN');
                        });
                        $sheet->cell('Z1', function($cell) {
                            $cell->setValue('TGL PERJANJIAN');
                        });
                        $sheet->cell('AA1', function($cell) {
                            $cell->setValue('JENIS KREDIT');
                        });
                        if($sertifikat[0]['case']=='Ya')
                        {
                            $sheet->cell('AB1', function($cell) {
                              $cell->setValue('ANALISA');
                          });
                          $sheet->cell('AC1', function($cell) {
                              $cell->setValue('APPROVAL');
                          });  
                        }
                        

                        if (!empty($sertifikat)) {
                            foreach ($sertifikat as $key => $value) {

                                if ($value['jeniskredit'] == 'PRODUKTIF') {
                                    $produk = 'BPR-PRO';
                                } else {
                                    $produk = 'KONSUMTIF';
                                }

                                $i = $key + 2;
                                $no = $key + 1;
                                
                                $notrx=date('ymd').str_pad($no, 4, '0', STR_PAD_LEFT);
                                
                                $sheet->cell('A' . $i, 'KU' . $notrx);
                                $sheet->cell('B' . $i, 'DAA001');
                                $sheet->cell('C' . $i, $value['kd_penerima']);
                                $sheet->cell('D' . $i, 'TAG');
                                $sheet->cell('E' . $i, $produk);
                                $sheet->cell('F' . $i, $value['kodesertifikat']);
                                $sheet->cell('G' . $i, '2001/01/01');
                                $sheet->cell('H' . $i,date('Y/m/d', strtotime($value['tglterbit'])));
                                $sheet->cell('I' . $i, date('Y/m/d', strtotime($value['tglrealisasi'])));
                                $sheet->cell('J' . $i, date('Y/m/d', strtotime($value['tgljatuhtempo'])));
                                $sheet->cell('K' . $i, $value['rate']);
                                $sheet->cell('L' . $i, $value['premi']);
                                $sheet->cell('M' . $i, $value['nett']);
                                $sheet->cell('N' . $i, $value['plafon']);
                                $sheet->cell('O' . $i, $value['share']);
                                $sheet->cell('P' . $i, $value['dis']);
                                $sheet->cell('Q' . $i, '-');
                                $sheet->cell('R' . $i,'-');
                                $sheet->cell('S' . $i, '-');
//                                $sheet->cell('Q' . $i, number_format($value['admin'], 0, '.', ','));
//                                $sheet->cell('R' . $i, number_format($value['materai'], 0, '.', ','));
//                                $sheet->cell('S' . $i, 0);
                                $sheet->cell('T' . $i, '-');
                                $sheet->cell('U' . $i, $value['kodeuser']);
                                $sheet->cell('V' . $i, '2');
                                $sheet->cell('W' . $i, '-');
                                $sheet->cell('X' . $i, date('Y/m/d'));
                                $sheet->cell('Y' . $i, $value['nopk']);
                                $sheet->cell('Z' . $i, date('Y/m/d', strtotime($value['tglpk'])));
                                $sheet->cell('AA' . $i, '-');
                                if($value['case']=='Ya')
                                {
                                 $sheet->cell('AB' . $i, $value['catatan']);
                                 $sheet->cell('AC' . $i, $value['tanggapandir']);   
                                }
                                
                            }
                        }
                    });
        
    } 
    public function create_sheet_verifikasi_kasi($excel,$sertifikat) 
    {
        
    $excel->sheet('Verifikasi Kasi', function($sheet) use($sertifikat) 
                     {
                        $sheet->cell('A1', function($cell) {
                            $cell->setValue('NO. TRX');
                        });
                        $sheet->cell('B1', function($cell) {
                            $cell->setValue('TANGGAL APPROV');
                        });
                        $sheet->cell('C1', function($cell) {
                            $cell->setValue('KODE USER');
                        });
                        $sheet->cell('D1', function($cell) {
                            $cell->setValue('KET');
                        });
                        $sheet->cell('E1', function($cell) {
                            $cell->setValue('TGL SERVER');
                        });
                        $sheet->cell('F1', function($cell) {
                            $cell->setValue('STATUS');
                        });


                        if (!empty($sertifikat)) {
                            foreach ($sertifikat as $key => $value) {
                                $i = $key + 2;
                                $no = $key + 1;
                                $notrx=date('ymd').str_pad($no, 4, '0', STR_PAD_LEFT);
                                
                                $sheet->cell('A' . $i, 'KU'.$notrx);
                                $sheet->cell('B' . $i, date('Y/m/d', strtotime($value['tglterbit'])));
                                $sheet->cell('C' . $i,$value['kodeuser']); 
                                $sheet->cell('D' . $i, '-');
                                $sheet->cell('E' . $i,date('Y/m/d', strtotime($value['tglterbit'])));
                                $sheet->cell('F' . $i, '1');
                            }
                        }
                    });
        
    } 
    public function create_sheet_verifikasi_keuangan($excel,$sertifikat) 
    {
        
                    $excel->sheet('Verifikasi Keuangan', function($sheet) use($sertifikat) 
                     {
                        $sheet->cell('A1', function($cell) {
                            $cell->setValue('NO. TRX');
                        });
                        $sheet->cell('B1', function($cell) {
                            $cell->setValue('TANGGAL APPROV');
                        });
                        $sheet->cell('C1', function($cell) {
                            $cell->setValue('KODE JENIS');
                        });
                        $sheet->cell('D1', function($cell) {
                            $cell->setValue('MASTER KAS');
                        });
                        $sheet->cell('E1', function($cell) {
                            $cell->setValue('NO BUKTI');
                        });
                        $sheet->cell('F1', function($cell) {
                            $cell->setValue('KET');
                        });

                        $sheet->cell('G1', function($cell) {
                            $cell->setValue('KODE USER');
                        });
                        $sheet->cell('H1', function($cell) {
                            $cell->setValue('TGL SERVER');
                        });


                        if (!empty($sertifikat)) {
                            foreach ($sertifikat as $key => $value) {
                                $i = $key + 2;
                                $no = $key + 1;
                                 
                                $notrx=date('ymd').str_pad($no, 4, '0', STR_PAD_LEFT);
                                
                                $sheet->cell('A' . $i, 'KU'.$notrx);
                                $sheet->cell('B' . $i, date('Y/m/d', strtotime($value['tglterbit'])));
                                $sheet->cell('C' . $i, 'JAA001');
                                $sheet->cell('D' . $i, $value['kodekas']);
                                $sheet->cell('E' . $i, '-');
                                $sheet->cell('F' . $i, '-');
                                $sheet->cell('G' . $i, $value['kodeuser']);
                                $sheet->cell('H' . $i, date('Y/m/d', strtotime($value['tglterbit'])));
                            }
                        }
                    });
        
    } 
    public function detail_laporan_internal(request $request) 
    {
//         idbank
//     dd($request);
         $dari   = self::tanggal($request->dari);
        $sampai = date ('Y-m-d 23:59:59.000',strtotime($request->sampai));
         
            $penjaminan = penjaminans::whereBetween('sertifikats.tglterbit',[$dari, $sampai])
                ->where
                ([
                    ['penjaminans.jeniskredit', 'like', '%' . $request->jenisKredit . '%' ],
                    ['penjaminans.idbank', $request->idbank],
                    ($request->jenislaporan=='CASE'?['penjaminans.case','Ya']:['penjaminans.case', 'like','%'])
                     
                 ])
                 ->wherein('penjaminans.app',['Lunas','Cetak'])     
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
             
                ->get();
//          dd($penjaminan);  
          return view('admin.laporan.laporan_internal_detail', [
                    'data'      => $penjaminan,
                    'dari'      => $dari,
                    'sampai'    => $sampai,
                    'jenis'     => $request->jenisKredit,
                    'bank'      => $request->idbank,
                    'jenislaporan'=> $request->jenislaporan,
                    'namabank'  => $penjaminan[0]['namabank'],
                ]);
    } 
    public function detail_laporan_internal_excel(request $request) 
   {
//         idbank
//          dd($request);
        
      
                     $dari           = self::tanggal($request->dari);
                     $sampai     = date ('Y-m-d 23:59:59.000',strtotime($request->sampai)); 
                     $penjaminan = penjaminans::whereBetween('sertifikats.tglterbit',[$dari, $sampai])
                                   ->where
                                    ([
                                            ['penjaminans.jeniskredit', 'like', '%' . $request->jenisKredit . '%' ],
                                            ['penjaminans.idbank', $request->idbank],
                                            ($request->jenislaporan=='CASE'?['penjaminans.case','Ya']:['penjaminans.case','Tidak'])

                                    ])
                                    ->wherein('penjaminans.app',['Lunas','Cetak']) 
                                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                                    ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                                    
                                    ->get();
                           
//         dd($penjaminan);
         return Excel::create('Rekap Kredit '.$request->jenisKredit, function($excel) use($penjaminan,$dari, $sampai,$request) {
            
                            $namabank = substr($request->namabank,15);
                           
                            $excel->sheet('Detail Laporan', function($sheet) use($penjaminan,$request,$namabank) {
                                
                                 $sheet->mergeCells('A1:D1')->cell('A1', function($cell) use($request,$namabank) {
//                            dd($request->jenisKredit);
                                    $cell->setValue(($request->jenisKredit=='%')?'LAPORAN PENJAMINAN KREDIT PRODUKTIF DAN KONSUMTIF '.$namabank:'LAPORAN PENJAMINAN KREDIT '.$request->jenisKredit.' : '.$namabank);
                                });
                             
                                 $sheet->mergeCells('A2:D2')->cell('A2', function($cell) use ($request) {
                                    $cell->setValue('PERIODE : '.date('d-m-Y',strtotime($request->dari)).' (S/D) '.$request->sampai);
                                });
                                
                                $sheet->cell('A4', function($cell) {
                                    $cell->setValue('NO');
                                });
                                $sheet->cell('B4', function($cell) {
                                    $cell->setValue('NOMOR SERTIFIKAT');
                                });
                                $sheet->cell('C4', function($cell) {
                                    $cell->setValue('NAMA TERJAMIN');
                                });
                                $sheet->cell('D4', function($cell) {
                                    $cell->setValue('TGL REALISASI');
                                });
                                $sheet->cell('E4', function($cell) {
                                    $cell->setValue('TGL JATUH TEMPO');
                                });
                                $sheet->cell('F4', function($cell) {
                                    $cell->setValue('PLAFON');
                                });
                                $sheet->cell('G4', function($cell) {
                                    $cell->setValue('RATE');
                                });
                                $sheet->cell('H4', function($cell) {
                                    $cell->setValue('GROSS IJP');
                                });
                                $sheet->cell('I4', function($cell) {
                                    $cell->setValue('POTONGAN');
                                });

                                $sheet->cell('J4', function($cell) {
                                    $cell->setValue('NETT IJP');
                                });

                             if (!empty($penjaminan)) {
                             
                                $totalpenjaminan   =0;
                                $totalgrossijp     =0;
                                $totaldis          =0;
                                $totalnetijp       =0;
                                
                                foreach ($penjaminan as $key => $value) {
                                    $i = $key + 5;
                                    $no = $key + 1;
                                    $sheet->cell('A' . $i, $no);
                                    $sheet->cell('B' . $i, $value['kodesertifikat']);
                                    $sheet->cell('C' . $i, $value['nama']);
                                    $sheet->cell('D' . $i, $value['tglrealisasi']);
                                    $sheet->cell('E' . $i, $value['tgljatuhtempo']);
                                    $sheet->cell('F' . $i, number_format($value['plafon'], 0, '.', ','));
                                    $sheet->cell('G' . $i, $value['rate']);
                                    $sheet->cell('H' . $i, number_format($value['premi'], 0, '.', ','));
                                    $sheet->cell('I' . $i, number_format($value['pot'], 0, '.', ','));
                                    $sheet->cell('J' . $i, number_format($value['nett'], 0, '.', ','));

                                    $totalpenjaminan = $totalpenjaminan + $value['plafon'];
                                    $totalgrossijp = $totalgrossijp + $value['premi'];
                                    $totaldis = $totaldis + $value['pot'];
                                    $totalnetijp = $totalnetijp + $value['nett'];
                                    $a = $i + 1;
                                }
                                $sheet->cell('A' . $a, '');
                                $sheet->cell('B' . $a, 'TOTAL');
                                $sheet->cell('F' . $a, number_format($totalpenjaminan, 0, '.', ','));
                                $sheet->cell('H' . $a, number_format($totalgrossijp, 0, '.', ','));
                                $sheet->cell('I' . $a, number_format($totaldis, 0, '.', ','));
                                $sheet->cell('J' . $a, number_format($totalnetijp, 0, '.', ','));
                            }
                        });
            
         })->download('xls');
    }
    
   public function cetakLaporanPdf(request $request) 
   {


        $dari = $request->dari;
         $sampai = date ('Y-m-d 23:59:59.000',strtotime($request->sampai));

        $sertifikat = penjaminans::whereBetween('tglpengajuan', array($dari, $sampai))
                ->where('jeniskredit', 'like', '%' . $request->jenisKredit . '%')
                ->where('penjaminans.idbank', 'like', '%' . $request->bank . '%')
                ->where('penjaminans.app', 'like', '%' . $request->jenislaporan . '%')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->orWhere('penjaminans.app', 'Lunas')
                ->get();

        $data = [
            'data' => $sertifikat,
            'dari' => $dari,
            'sampai' => $sampai,
            'jenislaporan' => $request->jenislaporan,
            'jeniskredit' => $request->jenisKredit,
            'bank' => $request->bank,
        ];

        $pdf = PDF::loadView('admin.laporan.laporanpdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');
        // $pdf = App::make('dompdf');

        return $pdf->stream('Rekap Pengajuan' . '.pdf');
    }
    
    public function cetakLaporanPdfUser(request $request) 
    { 
        $dari        = $request->dari;
        $sampai  = date ('Y-m-d 23:59:59.000',strtotime($request->sampai));
         
        $sertifikat = penjaminans::with(['terjamin','sertifikat','bank'])
                           ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')   
                           ->where([
                                  ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                                  ['penjaminans.idbank', session::get('idbank')],
                                  ['penjaminans.app', 'like', '%' . $request->jenislaporan . '%'], 
                              ]) 
                           ->wherein('penjaminans.app', ['Lunas', 'Cetak'])
                           ->whereBetween('sertifikats.tglterbit', [$dari, $sampai]) 
//                           ->orderBy('sertifikats.id','desc') 
                           ->get();  
        
        $data = [
            'data' => $sertifikat,
            'dari' => $dari,
            'sampai' => $sampai,
            'jeniskredit' => $request->jenisKredit,
            'jenis' => $request->jenislaporan,
        ];
        
        $pdf = PDF::loadView('user.laporan.laporan', compact('data'));
        $pdf->setPaper('A3', 'landscape');
        return $pdf->stream('rekap' . '/' . $sertifikat[0]['namabank'] . '/' . $sertifikat[0]['kodebayar'] . '/' . $sertifikat[0]['jeniskredit'] . '/' . $sertifikat[0]['jenispenjaminan'] . '.pdf');
    }
    
    public function cetakPdf($id) 
    {
        
        $sertifikat = penjaminans::where('nosertifikat', $id)
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('t_grace_periodes', 't_grace_periodes.id_penjaminan', '=', 'penjaminans.idpenjaminan')
                ->get(); 
     
         if($sertifikat[0]['level']=='koperasi')
         {
                if ($sertifikat[0]['digitalSign'] == "") {
                       $pdf = PDF::loadView('user.laporan.unsign.sertifikatKoperasi', compact('sertifikat'));
                  }else{
                        return redirect('/verifikasi-doc-sertifikat-penjaminan/'.$sertifikat[0]['verify']);
                  }
           
         }
         else
         {
            
               if ($sertifikat[0]['digitalSign'] == "") {
                        $pdf = PDF::loadView('user.laporan.unsign.sertifikat', compact('sertifikat'));
                  }else{
                        return redirect('/verifikasi-doc-sertifikat-penjaminan/'.$sertifikat[0]['verify']);

                  }
         }
         
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');
     
//        $cetak = new cetaks();
//        $cetak->idpenjaminan = $sertifikat[0]['idpenjaminan'];
//        $cetak->tglcetak =  date('Y-m-d H:i:s');;
//        $cetak->oleh = session::get('name').'/'.session::get('nama');
//        $cetak->keterangan = 'Sertifikat';
//        $cetak->save();

        return $pdf->stream($sertifikat[0]['nama']  . '/' . $sertifikat[0]['namabank'] . '/' . $sertifikat[0]['jeniskredit'] . '/' . $sertifikat[0]['jenispenjaminan'] . '.pdf');
        
    }
    
    public function cetaksertifikat($id) 
    {
        
        $sertifikat = penjaminans::where('nosertifikat', $id) 
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('t_history_banks', 'banks.idbank', '=', 't_history_banks.bank_id')
                ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('t_grace_periodes', 't_grace_periodes.id_penjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        
//        if ($sertifikat[0]['nama_perubahan']){
//            echo "ada";
//        }else{
//            echo "tidak ada";
//            echo $sertifikat[0]['namabank'];
//        }
//           dd($sertifikat[0]['nama_perubahan']);
//           
//           
//         if($sertifikat[0]['level']=='koperasi')
//         {
//            $pdf = PDF::loadView('user.laporan.sertifikatKoperasi', compact('sertifikat'));
//         }
//         else
//         {
//            $pdf = PDF::loadView('user.laporan.sertifikat', compact('sertifikat')); 
//         }
           if($sertifikat[0]['level']=='koperasi')
         {
                if ($sertifikat[0]['digitalSign'] == "") {
//                       $pdf = PDF::loadView('user.laporan.unsign.sertifikatKoperasi', compact('sertifikat')); // apabila sudah diterapkan ttd digital
                       $pdf = PDF::loadView('user.laporan.sertifikatKoperasi', compact('sertifikat'));
                  }else{
                        return redirect('/verifikasi-doc-sertifikat-penjaminan/'.$sertifikat[0]['verify']);
                  }
         }
         else
         {
               if ($sertifikat[0]['digitalSign'] == "") {
//                        $pdf = PDF::loadView('user.laporan.unsign.sertifikat', compact('sertifikat')); // apabila sudah diterapkan ttd digital
                        $pdf = PDF::loadView('user.laporan.sertifikat', compact('sertifikat'));
                  }else{
                        return redirect('/verifikasi-doc-sertifikat-penjaminan/'.$sertifikat[0]['verify']);
                  }
         }
         
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');
        return $pdf->stream($sertifikat[0]['nama']. '/' . $sertifikat[0]['namabank'] .  '/' . $sertifikat[0]['jeniskredit'] . '/' . $sertifikat[0]['jenispenjaminan'] . '.pdf');
    }
    
    
     public function cetakSP3($id) 
     {
        $sp3 = penjaminans::leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->leftJoin('t_history_banks', 'banks.idbank', '=', 't_history_banks.bank_id')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.nosertifikat', $id)
                ->leftJoin('sp3s', 'sp3s.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->get();
   
   
        $pdf = PDF::loadView('user.laporan.sp3', compact('sp3'));
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');

        return $pdf->stream('Surat Persetujuan Perinsip Penjaminan' . '/' . $sp3[0]['namabank'] . '/' . $sp3[0]['kodebayar'] . '/' . $sp3[0]['jeniskredit'] . '/' . $sp3[0]['jenispenjaminan'] . '.pdf');
    }
    
     public function cetakRekomendasi($id) 
     {
        $history= penjaminans::leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.nosertifikat', $id)
                ->leftJoin('sp3s', 'sp3s.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
   
        if($history[0]['detail_skim']=='MACET'){
            IF($history[0]['jeniskredit']=='PRODUKTIF'){
                   $pdf = PDF::loadView('user.laporan.rekomendasi-macet', compact('history'));
            }ELSE{
                  $pdf = PDF::loadView('user.laporan.rekomendasi-phk', compact('history'));
            }
        }ELSE{
               $pdf = PDF::loadView('user.laporan.rekomendasicase', compact('history'));
        }
        
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');

        return $pdf->stream('Surat Rekomendasi : ' . '/' . $history[0]['namabank'] . '/' . $history[0]['kodebayar'] . '/' . $history[0]['jeniskredit'] . '/' . $history[0]['jenispenjaminan'] . '.pdf');
    }
    
}
