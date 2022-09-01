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
use App\User;
use Illuminate\Support\Facades\Mail;
use App\banks;
use App\t_grace_periodes;

date_default_timezone_set("Asia/Jakarta");
use App\persyaratans;
use Carbon\Carbon;
use App\history_apps;
use App\t_history_banks;
class userController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //     dd(Session::get('level'));

        if (Session::get('level') != 'User') {

            $kodePenjaminan = penjaminans::where('idbank', session::get('idbank'))->count();
            $penjaminan = penjaminans::
                select(
                'banks.namabank', 'terjamins.ktp', 'terjamins.nama', 'terjamins.umur', 'penjaminans.idpenjaminan', 'penjaminans.jeniskredit', 'penjaminans.jenispenjaminan', 'penjaminans.plafon', 'penjaminans.premi', 'penjaminans.case', 'penjaminans.nosertifikat', 'penjaminans.tglpengajuan', 'penjaminans.nett', 'penjaminans.url_penjaminan', 'kesehatan.files', 'kesehatan.files2', 'kesehatan.files3'
            )
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('penjaminans.user', session::get('user'))
                ->where('statusbayar', 0)
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->get();


            $totalbaru = penjaminans::where('penjaminans.idbank', session::get('idbank'))
                ->where('penjaminans.user', session::get('user'))
                ->where('statusbayar', 0)
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->where('cek', '0')                //                    ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();

            //                 DD(session::get('idbank'));

            $casebycase = penjaminans::select(
                'banks.namabank',
                'terjamins.ktp',
                'terjamins.nama',
                'terjamins.tgllahir',
                'terjamins.umur',
                'penjaminans.idpenjaminan',
                'penjaminans.jeniskredit',
                'penjaminans.jenispenjaminan',
                'penjaminans.plafon',
                'penjaminans.case',
                'penjaminans.nosertifikat',
                'penjaminans.tglpengajuan',
                'penjaminans.pemohon',
                'penjaminans.url_penjaminan',
                'penjaminans.nett',
                'kesehatan.files',
                'kesehatan.files2',
                'kesehatan.getaran_jantung',
                'kesehatan.foto_usaha',
                'kesehatan.foto_ktp',
                'kesehatan.hasil_slik',
                'kesehatan.analisis_kelayakan',
                'kesehatan.taksasi_agunan',
                'kesehatan.surat_persetujuan_kredit',
                'kesehatan.surat_riwayat_kredit',
                'kesehatan.sk_pengangkatan',
                'persyaratans.doc_surat_pernyataan_sehat',
                'persyaratans.doc_surat_keterangan_sehat',
                'persyaratans.doc_cek_lab',
                'persyaratans.doc_getaran_jantung',
                'persyaratans.doc_ktp',
                'persyaratans.doc_foto_usaha',
                'persyaratans.doc_slik',
                'persyaratans.doc_analisa_kelayakan',
                'persyaratans.doc_taksasi',
                'persyaratans.doc_persetujuan_kredit',
                'persyaratans.doc_riwayat_kredit',
                'persyaratans.doc_sk',
                'persyaratans.case_ket',
                'persyaratans.jns_kredit',
                'kesehatan.files3'
            )
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('persyaratans', 'persyaratans.id', '=', 'penjaminans.persyaratan_id')
                ->where('case', 'Ya')
                ->where('app', 'Pengecekan')
                ->where('penjaminans.user', session::get('user'))
                ->where('penjaminans.statusbayar', 0)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.app', '!=', 'Tolak')
                ->where('penjaminans.app', '!=', 'Setuju')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->take(10)
                ->get();

            
//            dd($casebycase); 

            $totalcasebycase = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', '!=', 'Tolak')
                ->where('app', 'Pengecekan')
                ->where('penjaminans.user', session::get('user'))
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                    ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();

            $totalcasedapatbayar = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', 'Pembayaran')
                ->where('penjaminans.user', session::get('user'))                //                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                    ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();

            $bayar = penjaminans::where('statusbayar', 1)
                ->where('penjaminans.idbank', session::get('idbank'))
                ->where('app', 'Pengecekan')
                ->where('penjaminans.user', session::get('user'))                //                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
//                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->get();

            $disetujui = penjaminans::where('app', 'Setuju')
                ->where('statusbayar', 1)
                ->where('penjaminans.user', session::get('user'))                //                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
//                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();

            $totaldisetujui = penjaminans::where('app', 'Setuju')
                ->where('statusbayar', 1)
                ->where('cek', '0')                //                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->count();


            $ditolak = penjaminans::select(
                'banks.namabank', 'terjamins.ktp', 'terjamins.nama', 'penjaminans.idpenjaminan', 'penjaminans.jeniskredit', 'penjaminans.jenispenjaminan', 'penjaminans.plafon', 'penjaminans.case', 'penjaminans.nosertifikat', 'penjaminans.tglpengajuan', 'penjaminans.nett', 'penjaminans.tglrealisasi', 'penjaminans.tgljatuhtempo', 'penjaminans.pemohon', 'penjaminans.app', 'penjaminans.url_penjaminan', 'approvals.tglanalisa', 'kesehatan.files', 'kesehatan.files2', 'kesehatan.files3'
            )
                ->where('app', 'Tolak')
                ->where('penjaminans.user', session::get('user'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->take(5)
                ->get();

            $cetak = penjaminans::
                select(
                'banks.namabank', 'terjamins.ktp', 'terjamins.nama', 'penjaminans.idpenjaminan', 'penjaminans.jeniskredit', 'penjaminans.jenispenjaminan', 'penjaminans.plafon', 'penjaminans.case', 'penjaminans.nosertifikat', 'penjaminans.tglpengajuan', 'penjaminans.nett', 'penjaminans.tglrealisasi', 'penjaminans.tgljatuhtempo', 'penjaminans.pemohon', 'penjaminans.url_penjaminan', 'penjaminans.masakredit', 'sertifikats.kodesertifikat', 'sertifikats.tglterbit'
            )
                ->wherein('penjaminans.app', ['Lunas', 'Cetak'])
                ->where('penjaminans.user', session::get('user'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')                //                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
                ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->orderBy('sertifikats.id', 'desc')
                ->take(150)
                ->get();
            //               dd($cetak);
            //totalcetak
            $totalcetak = penjaminans::where('app', 'Cetak')
                ->where('cek', '0')
                ->where('penjaminans.user', session::get('user'))
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
//                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
//                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();
            //      Total Di Tolak;
            $totalditolak = penjaminans::where('app', 'Tolak')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->where('penjaminans.user', session::get('user'))                //                    ->where('history_tolakans.cek','T')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')                //                ->where('cek', '0')
//                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
//                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                    ->leftJoin('history_tolakans', 'history_tolakans.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();            //dd($totalditolak);

            $totalSudahbayar = penjaminans::where('statusbayar', 1)
                ->where('penjaminans.idbank', session::get('idbank'))
                ->where('penjaminans.user', session::get('user'))
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('app', 'Pengecekan')                //                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->count();
            $revisi = penjaminans::
                select(
                'banks.namabank', 'terjamins.ktp', 'terjamins.nama', 'terjamins.tgllahir', 'terjamins.umur', 'penjaminans.idpenjaminan', 'penjaminans.jeniskredit', 'penjaminans.jenispenjaminan', 'penjaminans.plafon', 'penjaminans.case', 'penjaminans.nosertifikat', 'penjaminans.tglpengajuan', 'penjaminans.pemohon', 'penjaminans.url_penjaminan', 'penjaminans.nett', 'kesehatan.files', 'kesehatan.files2', 'kesehatan.files3'
            )
                ->where('app', 'Revisi')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->take(15)
                ->get();
            $totalrevisi = penjaminans::where('app', 'Revisi')
                ->where('penjaminans.idbank', session::get('idbank'))                //                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
//                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('cek', '0')                //                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
//                    ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();
        }
        else {
            $kodePenjaminan = penjaminans::where('idbank', session::get('idbank'))->count();
            $penjaminan = penjaminans::where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('statusbayar', 0)
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->limit(50)
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->get();

            $totalbaru = penjaminans::where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('statusbayar', 0)
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->where('cek', '0')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();

            $casebycase = penjaminans::where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')                //                ->leftjoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('case', 'Ya')
                ->where('penjaminans.statusbayar', 0)
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.app', '!=', 'Tolak')
                ->where('penjaminans.app', '!=', 'Setuju')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->get();            //        dd($casebycase);
//dd($casebycase);
            $totalcasebycase = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', '!=', 'Tolak')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();
            $totalcasedapatbayar = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', 'Pembayaran')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->count();
            $bayar = penjaminans::where('statusbayar', 1)
                ->where('app', 'Pengecekan')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->get();

            $disetujui = penjaminans::where('app', 'Setuju')
                ->where('statusbayar', 1)
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();            //        dd($disetujui);
            $totaldisetujui = penjaminans::where('app', 'Setuju')
                ->where('statusbayar', 1)
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('cek', '0')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('penjaminans.idbank', session::get('idbank'))
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->count();
            $ditolak = penjaminans::select('*', 'penjaminans.idpenjaminan')
                ->where('app', 'Tolak')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->take(15)
                ->get();
            $revisi = penjaminans::select('*', 'penjaminans.idpenjaminan')
                ->where('app', 'Revisi')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->take(15)
                ->get();
            $totalrevisi = penjaminans::where('app', 'Revisi')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('cek', '0')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();
            $cetak = penjaminans::
                wherein('penjaminans.app', ['Lunas', 'Cetak'])
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
                ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->orderBy('sertifikats.id', 'desc')
                ->take(150)
                ->get();

            //totalcetak
            $totalcetak = penjaminans::where('app', 'Cetak')
                ->where('cek', '0')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();
            //      Total Di Tolak;
            $totalditolak = penjaminans::where('app', 'Tolak')
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->where('history_tolakans.cek', 'T')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('cek', '0')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('history_tolakans', 'history_tolakans.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->count();



            $totalSudahbayar = penjaminans::where('statusbayar', 1)
                ->where('banks.kodepusat', session::get('kodepusat'))
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where('app', 'Pengecekan')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->count();
        }



        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();

        //    dd($penjaminan);

        return view('user.dashboard1', [
            'data' => $penjaminan,
            'case1' => $casebycase,
            'setuju' => $disetujui,
            'kode' => $kodePenjaminan,
            'bayar' => $bayar,
            'totalcasebycase' => $totalcasebycase,
            'totalcasedapatbayar' => $totalcasedapatbayar,
            'totalbaru' => $totalbaru,
            'totalsudahbayar' => $totalSudahbayar,
            'totaldisetujui' => $totaldisetujui,
            'totalbaru' => $totalbaru,
            'ditolak' => $ditolak,
            'rate' => $rate,
            'totalditolak' => $totalditolak,
            'cetak' => $cetak,
            'totalcetak' => $totalcetak,
            'revisi' => $revisi,
            'totalrevisi' => $totalrevisi,
        ]);
    }

    public function nilai($nilai)
    {
        $pecah = explode(",", $nilai);
        return implode("", $pecah);
    }

    public function tanggal($tgl)
    {

        $data = explode("/", $tgl);

        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }

    function AmbilTanggal($tgl)
    {

        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        $tgl = date('Y-m-d', strtotime($isi));

        $tanggal = $tgl . '00:00:00';
        return $ArrayDataTanggal = new DateTime($tanggal);
    }

    public function AddPenjaminan()
    {
        $kodePenjaminan = penjaminans::count();
        return view('user.inputpenjaminan', [
            'kode' => $kodePenjaminan,
        ]);
    }

    public function AddPenjaminanGrace()
    {
        $kodePenjaminan = penjaminans::count();
        return view('user.inputpenjaminanGracePeriod', [
            'kode' => $kodePenjaminan,
        ]);
    }

    public function AddCase()
    {
        $kodePenjaminan = penjaminans::count();
        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();
        return view('user.inputpenjaminan_case', [
            'rate' => $rate,
            'kode' => $kodePenjaminan,
        ]);
    }

    public function inputpenjaminanperpanjangan()
    {
        $kodePenjaminan = penjaminans::count();
        $rate = DB::table('rate')
            ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
            ->get();
        return view('user.inputpenjaminanperpanjangan', [
            'rate' => $rate,
            'kode' => $kodePenjaminan]);
    }

    protected function CekPK($request)
    {
        if ($request->pklama and $request->nosertifikatlama) {
            $nopklama = $request->pklama;
            $nosertifikatlama = $request->nosertifikatlama;
        }
        else {
            $nopklama = '';
            $nosertifikatlama = '';
        }

        return $data = ['NoPK' => $nopklama, 'NoSertifikatLama' => $nosertifikatlama];
    }

    protected function CekSiup($request)
    {
        if ($request->siup and $request->npwp) {
            $siup = $request->siup;
            $npwp = $request->npwp;
        }
        else {
            $siup = '-';
            $npwp = '-';
        }

        return $data = ['siup' => $siup, 'npwp' => $npwp];
    }

    protected function CekPenulisanAlamat($request)
    {

        if ($request->jenispengajuan == 'kompensasi' || $request->jenispengajuan == 'Double') {
            $alamat = $request->alamat;
        }
        else {
            $alamat = $request->alamat .
                ', Desa/Kelurahan ' . $request->desa .
                ', Kecamatan ' . $request->kecamatan .
                ', Kabupaten/Kota ' . $request->kabupaten;
        }
        return $alamat;
    }

    protected function CekRate($request)
    {

        if ($request->kredit == 'PRODUKTIF') {
            $produk = '5';
        }
        else {
            $produk = '1';
        }

        $data = explode('|', $request->jenisPenjaminan);

        $jenisPenjaminan = $data[0];
        $rate_detail = rate::leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
            ->where('banks.idbank', Session::get('idbank'))
            ->where('rate.dari', '<=', $request->masakredit)
            ->where('rate.sampai', '>=', $request->masakredit)
            ->where('rate.namarate', $jenisPenjaminan)
            ->where('rate.idproduk', $produk)
            ->first();
        return $rate_detail;
    }

    function formatUang($uang)
    {

        return number_format($uang, 0, '.', ',');
    }

    protected function GabungNilai($nilai)
    {

        $pecah = explode(",", $nilai);
        return implode("", $pecah);
    }

    protected function PilihJenisPejaminan(request $request)
    {
        //        dd($request);
        $rate_detail = rate::
            leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
            ->leftJoin('produks', 'produks.idproduk', '=', 'rate.idproduk')
            ->where('banks.idbank', $request->idbank)
            ->where('rate.dari', '<=', $request->bulan)
            ->where('rate.sampai', '>=', $request->bulan)
            ->where('produks.jeniskategori', $request->jeniskredit)
            ->get();        //        dd($rate_detail);

        echo "<select  required id='jenisPenjaminan' name='jenisPenjaminan' class='form-control'>";
        echo "<option value=''>Pilih Jenis Penjaminan</option>";

        foreach ($rate_detail as $key => $rate) {
            $rates = $rate->rate;
            $bulan = $request->bulan;
            $namarate = $rate->namarate;
            $plafon = $this->GabungNilai($request->plafon);
            $dis = $rate->dis;
            $premi = $plafon * ($rate->rate / 100);

            if ($premi < $rate->minijp) {
                $premi = $rate->minijp;
            }
            $potongan = ($rate->dis / 100) * $premi;
            $nett = $premi - $potongan;

            if ($namarate == 'KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)') {
                $namarate = 'MACET KARENA MENINGGAL DUNIA(Musiman)';
                $ValNamaRate = $rate->namarate;
            }
            else {
                $namarate = $rate->namarate;
                $ValNamaRate = $rate->namarate;
            }
            echo "<option value='" . $ValNamaRate . "'>" . $namarate . "|" . $bulan . " Bln | Rp. " . $request->plafon . "| RATE :" . $rates . "%| IJP : " . $this->formatUang($premi) . " | DIS : " . $dis . " % | POT. : " . $this->formatUang($potongan) . "| NETT: " . $this->formatUang($nett) . " </option>";
        }
        echo "</select>";
    }

    protected function CekMinIJP($rate, $plafon)
    {
        $ijp = ($rate->rate / 100) * $plafon;
        if ($ijp < $rate->minijp) {
            $ijp = $rate->minijp;
        }

        return $ijp;
    }

    protected function cek_file($namafile, $request)
    {
        if ($request->hasFile("$namafile")) {
            $File = 'Ada';
        }
        else {
            $File = 'Tidak';
        }

        return $File;
    }

    protected function upload_file($namafile, $direktory, $request)
    {

        $destinationPath = $this->url_penjaminan($request);

        // upload_file('filePembayaran','files/buktibayar/',$request);
        //Tahun/Bulan/Hari/NamaBank/namaTerjamin
//        // Check to see if the "destinationPath" exists if it doesn't create it.
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $fileName = $request->file("$namafile")->getClientOriginalName();
        // mendapatkan ektensi berkas
        $ekstensi = $request->file("$namafile")->getClientOriginalExtension();
        // mendapatkan ukuran berkas
        $request->file("$namafile")->getClientSize();

        $Namafile = $namafile . '-' . md5(str_random(8) . date('ymdhis')) . '.' . $ekstensi;        //            dd($Namafile);
//            $uploadedFile = $request->file("$namafile");
        $upload = $request->file("$namafile")->move($destinationPath, "$Namafile");

        return $Namafile;
    }
    protected function update_file($namafile, $destinationPath, $request)
    {

        
//        // Check to see if the "destinationPath" exists if it doesn't create it.
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $fileName = $request->file("$namafile")->getClientOriginalName();
        // mendapatkan ektensi berkas
        $ekstensi = $request->file("$namafile")->getClientOriginalExtension();
        // mendapatkan ukuran berkas
        $request->file("$namafile")->getClientSize();

        $Namafile = $namafile . '-' . md5(str_random(8) . date('ymdhis')) . '.' . $ekstensi;        //            dd($Namafile);
//            $uploadedFile = $request->file("$namafile");
        $upload = $request->file("$namafile")->move($destinationPath, "$Namafile");

        return $Namafile;
    }

    public function SaveTerjamin($request, $tahun, $alamat)
    {        //           dd( $request->namaPerusahaan); 
        $terjamin = terjamins::create([
            'ktp' => $request->ktp,
            'phone' => $request->phone,
            'nama' => $request->name,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => self::tanggal($request->tglLhr),
            'umur' => $tahun,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $alamat,
            'register' => $request->kodepenjaminan,
            'masa_kerja' => ($request->masaKerja) ? $request->masaKerja : '',
            'nama_perusahaan' => ($request->namaPerusahaan) ? $request->namaPerusahaan : '',
            'jabatan' => ($request->jabatan) ? $request->jabatan : '',
        ]);
        return $terjamin;
    }

    public function SaveKesehatan(
        $penjaminan,
        $request,
        $hasilUploadfileSuratSehat,
        $hasilUploadfileSuratSehatRs,
        $hasilUploadfileCekLab
        )
    {
        $kesehatan = kesehatans::create([
            'idpenjaminan' => $penjaminan->id,
            'nosertifikat' => $request->kodepenjaminan,
            'files' => $hasilUploadfileSuratSehat,
            'files2' => ($hasilUploadfileCekLab) ? $hasilUploadfileCekLab : '',
            'files3' => ($hasilUploadfileSuratSehatRs) ? $hasilUploadfileSuratSehatRs : '',
        ]);
    }
    public function SaveKesehatanMacet(
        $penjaminan,
        $request,
        $hasilUploadfileSuratSehat,
        $hasilUploadfileSuratSehatRs,
        $hasilUploadfileCekLab,
        $hasilUploadfileCekGetaranJantung,
        $hasilUploadfileCekKTP,
        $hasilUploadfilecekUsaha,
        $hasilUploadfileCekSlik,
        $hasilUploadfilecekAnalisis,
        $hasilUploadfileCekTaksasi,
        $hasilUploadfilecekSuratPersetujuanKredit,
        $hasilUploadRiwayatKredit,
        $hasilUploadSK
        )
    {
        $kesehatan = kesehatans::create([
            'idpenjaminan' => $penjaminan->id,
            'nosertifikat' => $request->kodepenjaminan,
            'files' => $hasilUploadfileSuratSehat,
            'files2' => ($hasilUploadfileCekLab) ? $hasilUploadfileCekLab : '',
            'files3' => ($hasilUploadfileSuratSehatRs) ? $hasilUploadfileSuratSehatRs : '',
            'getaran_jantung' => ($hasilUploadfileCekGetaranJantung) ? $hasilUploadfileCekGetaranJantung : '',
            'foto_ktp' => ($hasilUploadfileCekKTP) ? $hasilUploadfileCekKTP : '',
            'foto_usaha' => ($hasilUploadfilecekUsaha) ? $hasilUploadfilecekUsaha : '',
            'hasil_slik' => ($hasilUploadfileCekSlik) ? $hasilUploadfileCekSlik : '',
            'analisis_kelayakan' => ($hasilUploadfilecekAnalisis) ? $hasilUploadfilecekAnalisis : '',
            'taksasi_agunan' => ($hasilUploadfileCekTaksasi) ? $hasilUploadfileCekTaksasi : '',
            'surat_persetujuan_kredit' => ($hasilUploadfilecekSuratPersetujuanKredit) ? $hasilUploadfilecekSuratPersetujuanKredit : '',
            'surat_riwayat_kredit' => ($hasilUploadRiwayatKredit) ? $hasilUploadRiwayatKredit : '',
            'sk_pengangkatan' => ($hasilUploadSK) ? $hasilUploadSK : '',
        ]);
    }

    public function SaveTransaksiPenjaminan(
        $terjamin,
        $nopklama,
        $nosertifikatlama,
        $siup,
        $npwp,
        $request,
        $jatuhtempo,
        $rate,
        $premi,
        $dis,
        $potongan,
        $nett,
        $jenisPenjaminan,
        $urlPenjaminan,
        $persentase_jaminan,
        $detail_skim
        )
    {        //        dd($request);

        date_default_timezone_set("Asia/Jakarta");

        $penjaminan = penjaminans::create([
            'idterjamin' => $terjamin->id,
            'pklama' => $nopklama,
            'sertifikatlama' => $nosertifikatlama,
            'case' => $request->caseket,
            'siup' => $siup,
            'npwp' => $npwp,
            'masakredit' => $request->masakredit,
            'jeniskredit' => $request->kredit,
            'penggunaan' => $request->penggunaan,
            'lama_usaha' => ($request->lama_usaha) ? $request->lama_usaha : '',
            'detail_skim' => $detail_skim,
            'nilai_taksasi' => ($request->nilai_taksasi) ?self::nilai($request->nilai_taksasi) : '',
            'tglrealisasi' => ($request->tglrealisasi) ?self::tanggal($request->tglrealisasi) : '',
            'tgljatuhtempo' => $jatuhtempo,
            'umurjatuhtempo' => $request->umurjatuhtempo,
            'nopk' => ($request->nopk) ? $request->nopk : '',
            'persyaratan_id' => ($request->persyaratan_id) ? $request->persyaratan_id : '',
            'idbank' => $request->idbank,
            'tglpk' => ($request->tglrealisasi) ?self::tanggal($request->tglrealisasi) : '',            //                    'tglpk' => ($request->tglpk) ? self::tanggal($request->tglpk) : '',
            'plafon' => self::nilai($request->plafon),
            'rate' => $rate,
            'premi' => $premi,
            'statusbayar' => '0',
            'dis' => $dis,
            'cek' => '0',
            'pot' => $potongan,
            'nosertifikat' => $request->kodepenjaminan,
            'nett' => $nett,
            'app' => 'Pengecekan',
            'jenispengajuan' => $request->jenispengajuan,
            'pemohon' => $request->pemohon,
            'user' => Session::get('user'),
            'jenispenjaminan' => $jenisPenjaminan,
            'url_penjaminan' => $urlPenjaminan,
            'persentase_penjaminan' => $persentase_jaminan,
            'tglpengajuan' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ]);
        return $penjaminan;
    }

    public function SimpanPenjaminan(Request $request)
    {        //        dd($request); 
        $urlPenjaminan = $this->url_penjaminan($request);        //        dd($urlPenjaminan);
        $validation = [
        ];
        $this->validate($request, [
            'phone' => 'required|max:15',
            'alamat' => 'required|max:255',
            'desa' => ($request->desa) ? 'required|max:255' : '',
            'kecamatan' => ($request->kecamatan) ? 'required|max:255' : '',
            'kabupaten' => ($request->kabupaten) ? 'required|max:255' : '',
            'tempatlahir' => 'required|max:255',
            'tglLhr' => 'required|max:255',
            'kredit' => 'required|max:15',
            'ktp' => 'required|max:20',
            'pekerjaan' => 'required|max:255',
            'nopk' => 'required|max:255',
            'tglpk' => 'required|max:255',
            'tglrealisasi' => 'required|max:255',
            'masakredit' => 'required|max:255',
            'plafon' => 'required|max:255|min:5',
            'fileSuratSehat' => 'required|file|mimes:jpg,JPG,jpeg,PDF,pdf,PNG,png',
            'fileSuratSehatRs' => (self::nilai($request->plafon) > 100000000) ? 'required|file|mimes:jpg,JPG,jpeg,PDF,pdf,PNG,png' : "",
            'fileCekLab' => (self::nilai($request->plafon) > 200000000) ? 'required|file|mimes:jpg,JPG,jpeg,PDF,pdf,PNG,png' : "",
        ]);

        $alamat = $this->CekPenulisanAlamat($request);
        $masakredit = $request->masakredit;
        $cekpk = $this->CekPK($request);
        $nopklama = $cekpk['NoPK'];
        $nosertifikatlama = $cekpk['NoSertifikatLama'];
        $CekSiup = $this->CekSiup($request);
        $siup = $CekSiup['siup'];
        $npwp = $CekSiup['npwp'];
        $dataumur = explode(':', $request->umur);
        $tahun = $dataumur[0];
        $plafon = self::nilai($request->plafon);
        $realisasi = self::tanggal($request->tglrealisasi);
        $jatuhtempo = date('Y/m/d', strtotime("+$masakredit month", strtotime($realisasi)));
        $tarif = $this->CekRate($request);
        $ijp = $this->CekMinIJP($tarif, $plafon);
        $rate = $tarif->rate;
        $dis = $tarif->dis;
        $persentase_jaminan = $tarif->persentase_jaminan;
        $detail_skim = $tarif->jnspnj;
        $potongan = $ijp * ($dis / 100);
        $nett = $ijp - $potongan;
        $premi = $ijp;
        $data = explode('|', $request->jenisPenjaminan);
        $jenisPenjaminan = $data[0];


        if ($request->hasFile('fileSuratSehat')) {
            $hasilUploadfileSuratSehat = $this->upload_file('fileSuratSehat', 'files/suratsehat/', $request);
        }
        else {
            $hasilUploadfileSuratSehat = "";
        }

        if ($request->hasFile('fileSuratSehatRs')) {
            $hasilUploadfileSuratSehatRs = $this->upload_file('fileSuratSehatRs', 'files/suratsehatrs/', $request);
        }
        else {
            $hasilUploadfileSuratSehatRs = "";
        }

        if ($request->hasFile('fileCekLab')) {
            $hasilUploadfileCekLab = $this->upload_file('fileCekLab', 'files/scanlab/', $request);
        }
        else {
            $hasilUploadfileCekLab = "";
        }

        $cek_penjaminan = penjaminans::where([
            ['jeniskredit', $request->kredit],
            ['tglrealisasi', ($request->tglrealisasi) ?self::tanggal($request->tglrealisasi) : ''],
            ['tgljatuhtempo', $jatuhtempo],
            ['nopk', ($request->nopk) ? $request->nopk : ''],
            ['idbank', $request->idbank],
            ['plafon', self::nilai($request->plafon)],
        ])->count();        //         echo  $request->kredit. " <br>";
//         echo self::tanggal($request->tglrealisasi). " <br>";
//         echo  $jatuhtempo. " <br>";
//         echo   $request->nopk. " <br>";
//         echo  $request->idbank. " <br>";
//         echo  self::nilai($request->plafon). " <br>"; 
//         dd($cek_penjaminan);

        if ($cek_penjaminan > 0) {
            Session::flash('pesan', 'Penjaminan gagal diinput, data yang dimasukkan sudah terdaftar !!!');
            return redirect('bpr');
        }
        else {
            $terjamin = $this->SaveTerjamin($request, $tahun, $alamat);
            $penjaminan = $this->SaveTransaksiPenjaminan(
                $terjamin,
                $nopklama,
                $nosertifikatlama,
                $siup,
                $npwp,
                $request,
                $jatuhtempo,
                $rate,
                $premi,
                $dis,
                $potongan,
                $nett,
                $jenisPenjaminan,
                $urlPenjaminan,
                $persentase_jaminan,
                $detail_skim
            );
            $kesehatan = $this->SaveKesehatan($penjaminan, $request, $hasilUploadfileSuratSehat, $hasilUploadfileSuratSehatRs, $hasilUploadfileCekLab);
            if ($request->jnsGracePeriode == 'ya') {
                $simpanDataGrace = t_grace_periodes::create([
                    'id_penjaminan' => $penjaminan->id,
                    'tgl_mulai' => self::tanggal($request->tglGrace),
                    'periode' => $request->masaGrace,
                ]);
            }
            return redirect('bpr');
        }
    }

    public function url_penjaminan($request)
    {
        $namaBank = banks::select('namabank')->where('idbank', $request->idbank)->first();
        //menghilangkan spasi pada nama bank
        $namaBank = str_replace(" ", "-", $namaBank->namabank);
        $namaTerjamin = strtoupper(str_replace(" ", "-", $request->name));
        $destinationPath = 'files/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $namaBank . '/' . $namaTerjamin . '-' . $request->kodepenjaminan . '/';
        return $destinationPath;
    }

    public function SimpanPenjaminanCase(Request $request)
    {
        $alamat = $this->CekPenulisanAlamat($request);
        $masakredit = $request->masakredit;
        $cekpk = $this->CekPK($request);
        $nopklama = $cekpk['NoPK'];
        $nosertifikatlama = $cekpk['NoSertifikatLama'];
        $CekSiup = $this->CekSiup($request);
        $siup = $CekSiup['siup'];
        $npwp = $CekSiup['npwp'];
        $dataumur = explode(':', $request->umur);
        $tahun = $dataumur[0];
        $plafon = self::nilai($request->plafon);        //        $realisasi          = self::tanggal($request->tglrealisasi);
//        $jatuhtempo         = date('Y/m/d', strtotime("+$masakredit month", strtotime($realisasi)));
        $tarif = $this->CekRate($request);
        $ijp = $this->CekMinIJP($tarif, $plafon);
        $rate = $tarif->rate;
        $dis = $tarif->dis;
        $persentase_jaminan = $tarif->persentase_jaminan;
        $detail_skim = $tarif->jnspnj;
        $potongan = $ijp * ($dis / 100);
        $nett = $ijp - $potongan;
        $premi = $ijp;
        $jenisPenjaminan = $request->jenisPenjaminan;
        $urlPenjaminan = $this->url_penjaminan($request);
        $fileSuratSehatRs = $this->cek_file('fileSuratSehatRs', $request);
        $FileSuratSehat = $this->cek_file('fileSuratSehat', $request);
        $FileCekLab = $this->cek_file('fileCekLab', $request);
        //           echo "<pre>";
//        
//        $data = $request->file();
//        $data = $request->file('fileSuratSehatRs');
//        $data = $request->file('*');
//        print_r($data);
//        echo "</pre>";
        // $ekstensi = $request->file("$namafile")->getClientOriginalExtension();
        // Untuk melakukan upload sekaligus 
//        foreach( $request->file() as $key=>$n) {
//            $namaFile[] = [
//                            $key , 
//                        ];
//        } 
//          $data =count($namaFile); 
//          $i=0; 
//            
//           while ($i<=$data-1){ 
////            $dataku[] = $namaFile[$i][0]; 
//            if ($request->hasFile("$namafile")) 
//            {
//                $this->upload_file($namaFile[$i][0],'files/suratsehat/',$request); 
//            } 
//            $i++;
//        }
//        
//          dd($dataku);


        if (
        $fileSuratSehatRs == 'Ada' &&
        $FileSuratSehat == 'Ada' &&
        $FileCekLab == 'Ada'
        ) {
            $hasilUploadfileSuratSehat = $this->upload_file('fileSuratSehat', 'files/suratsehat/', $request);
            $hasilUploadfileSuratSehatRs = $this->upload_file('fileSuratSehatRs', 'files/suratsehatrs/', $request);
            $hasilUploadfileCekLab = $this->upload_file('fileCekLab', 'files/scanlab/', $request);
            if (
            $hasilUploadfileSuratSehat &&
            $hasilUploadfileSuratSehatRs &&
            $hasilUploadfileCekLab
            ) {
                $terjamin = $this->SaveTerjamin($request, $tahun, $alamat);
                $penjaminan = $this->SaveTransaksiPenjaminan(
                    $terjamin,
                    $nopklama,
                    $nosertifikatlama,
                    $siup,
                    $npwp,
                    $request,
                    "",
                    $rate,
                    $premi,
                    $dis,
                    $potongan,
                    $nett,
                    $jenisPenjaminan,
                    $urlPenjaminan,
                    $persentase_jaminan,
                    $detail_skim
                );
                $kesehatan = $this->SaveKesehatan(
                    $penjaminan, $request, $hasilUploadfileSuratSehat, $hasilUploadfileSuratSehatRs, $hasilUploadfileCekLab);
            }
        }
        return redirect('bpr');
    }

    public function UpdatePenjaminan(Request $request)
    {        //        dd($request);
        date_default_timezone_set("Asia/Jakarta");

        if ($request->approval == 'ulang') {
            $app = 'ulang';
        }
        else {
            $app = 'Pengecekan';
        }

        if ($request->statusbayar == '0' && $request->caseket == 'Ya') {
            $realisasi = '';
            $tglPK = '';            //             $NoPK='';
            $jatuhtempo = '';
            $umurJatuhTempo = $request->umurjatuhtempo;
        }
        else {

            $tglPK = self::tanggal($request->tglpk);            //             $NoPK              =$request->nopk;  
            $umurJatuhTempo = $request->umurjatuhtempo;
            $realisasi = self::tanggal($request->tglrealisasi);
            $jatuhtempo = date('Y/m/d', strtotime("+$request->masakredit month", strtotime($realisasi)));
        }        //      


        if (isset($request->tglGrace)) {
            t_grace_periodes::where('id_penjaminan', $request->idpenjaminan)
                ->update([
                'tgl_mulai' => date('Y-m-d', strtotime($request->tglGrace)),
                'periode' => $request->masaGrace,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
        }


        $masakredit = $request->masakredit;
        $dataumur = explode(':', $request->umur);
        $tahun = $dataumur[0];
        $CekSiup = $this->CekSiup($request);
        $siup = $CekSiup['siup'];
        $npwp = $CekSiup['npwp'];
        $plafon = self::nilai($request->plafon);
        $tarif = $this->CekRate($request);
        $ijp = $this->CekMinIJP($tarif, $plafon);
        $rate = $tarif->rate;
        $dis = $tarif->dis;
        $potongan = $ijp * ($dis / 100);
        $nett = $ijp - $potongan;
        $premi = $ijp;
        $jenisPenjaminan = $request->jenisPenjaminan;

        $update = penjaminans::where('idpenjaminan', $request->idpenjaminan)
            ->update([
            'case' => $request->caseket,
            'siup' => $siup,
            'npwp' => $npwp,
            'masakredit' => $request->masakredit,
            'jeniskredit' => $request->kredit,
            'penggunaan' => $request->penggunaan,
            'tglrealisasi' => $realisasi,
            'tgljatuhtempo' => $jatuhtempo,
            'umurjatuhtempo' => $umurJatuhTempo,
            'nopk' => $request->nopk,
            'idbank' => $request->idbank,
            'tglpk' => $tglPK,
            'plafon' => self::nilai($request->plafon),
            'rate' => $rate,
            'premi' => $premi,
            'dis' => $dis,
            'pot' => $potongan,
            'nett' => $nett,
            'app' => $app,
            'jenispenjaminan' => $jenisPenjaminan,
        ]);

        $dataterjamin = penjaminans::where('idpenjaminan', $request->idpenjaminan)->first();

        $updateTerjamin = terjamins::where('id', $dataterjamin->idterjamin)
            ->update([
            'ktp' => $request->ktp,
            'phone' => $request->phone,
            'nama' => $request->name,
            'tgllahir' => self::tanggal($request->tglLhr),
            'tempatlahir' => $request->tempatlahir,
            'umur' => $tahun,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
        ]);

        //kirim data penjaminan ulang dengan email
        if ($request->approval == 'ulang') {
            $pesan = "'Pengajuan ulang Penjaminan No Registrasi : '";
            $this->SendMailNotification($request, $pesan);
            //jika proses update pengajuan ulang
            Session::flash('pesan', 'Penjaminan berhasil di ajukan kembali');
            return redirect('bpr');
        }
        else {
            //jika proses update biasa
            Session::flash('pesan', 'Data pengajuan berhasil di update');
            return redirect('bpr');
        }
    }


    public function importExport()
    {
        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();
        $bank = banks::where('idbank', Session::get('idbank'))->first();        //        dd($bank);
        return view('user.export', [
            'rate' => $rate,
            'bank' => $bank,
        ]);
    }

    public function jeniskredit(request $request)
    {

        $jns = $request->jeniskredit;
        $rate = rate::where('rate.idbank', Session::get('idbank'))
            ->leftJoin('produks', 'produks.idproduk', '=', 'rate.idproduk')
            ->where('produks.jeniskategori', $jns)
            ->groupBy('rate.namarate')->get();
        echo "<select name='namejenisPenjaminan'>";
        echo "<option value=''>Pilih Jenis Penjaminan</option>";
        foreach ($rate as $key => $rate) {
            echo "<option>" . $rate->namarate . "</option>";
        }
        echo '</select>';
    }

    public function exportExcel()
    {

        $penjaminan = penjaminans::select('ktp', 'nama', 'tgllahir', 'umur', 'pekerjaan', 'jeniskredit', 'tglrealisasi', 'tgljatuhtempo', 'masakredit', 'nopk', 'plafon', 'rate', 'premi', 'dis', 'pot', 'nett')
            ->get();
        return Excel::create('datapenjaminan', function ($excel) use ($penjaminan) {
            $excel->sheet('mysheet', function ($sheet) use ($penjaminan) {
                    $sheet->fromArray($penjaminan);
                }
                );
            })->download('xls');
    }

    public function importExcel(Request $request)
    {

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function ($reader) { })->get();
            if (!empty($data) && $data->count()) {

                $kode = penjaminans::count();
                $kode = $kode + 1;
                $i = 0;
                foreach ($data[0] as $key => $val) { //mengambil nilai berdasarkan sheet 1
                    //  dd(isset($val->ktp));
                    if ($val->ktp != null) {
                        //    echo  $i.'.' .$val->ktp.'status ktp :'.isset($val->ktp)."<br>";
                        $nosertifikat = 'RGJNBEXC.' . session::get('idbank') . date('Ymdhis') . $kode;
                        $namaBank = banks::select('namabank')->where('idbank', Session::get('idbank'))->first();                        //menghilangkan spasi pada nama bank
                        $namaBank = str_replace(" ", "-", $namaBank->namabank);
                        $namaTerjamin = strtoupper(str_replace(" ", "-", $val->nama));
                        $destinationPath = 'files/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $namaBank . '/' . $namaTerjamin . '-' . $nosertifikat . '/';


                        if (!is_dir($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }

                        date_default_timezone_set("Asia/Jakarta");
                        $hariini = new DateTime("now");
                        $realisasi = new DateTime($val->tglrealisasi);
                        //mengambil nilai berdasarkan sheet 1

                        //cek umur
                        $taggallahir = date('Y/m/d', strtotime($val->tgllahir));
                        $lahir = new DateTime($taggallahir);
                        $sekarang = new DateTime();
                        $DataUmur = $lahir->diff($sekarang);
                        $umur = $DataUmur->y;
                        $realisasi = new DateTime($val->tglrealisasi);
                        $tgljatuhtempo = date('Y-m-d', strtotime("+$val->lamabulan month", strtotime($val->tglrealisasi)));
                        $jatuhtempo = new DateTime($val->tgljatuhtempo);                        //                    dd($jatuhtempo);
                        $Datamasakredit = $realisasi->diff($jatuhtempo);
                        $lahir = new DateTime($val->tgllahir);
                        $DataUmur = $lahir->diff($jatuhtempo);
                        $umurJatuhTempo = $DataUmur->y . ' Tahun, ' . $DataUmur->m . ' Bulan, ' . $DataUmur->d . ' Hari';                        //                    dd($umurJatuhTempo);
                        $cekumurJatuhTempo = $DataUmur->y;
                        if (session::get('level') == 'Bntb') {
                            if ($umurJatuhTempo > 70) {
                                $app_jatuhtempo = 'Tolak';
                                $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin saat jatuh tempo yaitu 70 Tahun';
                            }
                            else {
                                $app_jatuhtempo = 'Pengecekan';
                                $catatan_jatuhtempo = '';
                            }
                            if ($val->plafon > 200000000) {
                                $case = 'Ya';
                            }
                            else {
                                $case = 'Tidak';
                            }
                        }
                        else if (session::get('level') == 'BPR') {
                            if ($cekumurJatuhTempo > 65) {
                                $app_jatuhtempo = 'Tolak';
                                $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin  saat jatuh tempo  yaitu 65 Tahun';
                            }
                            else {
                                $app_jatuhtempo = 'Pengecekan';
                                $catatan_jatuhtempo = '';
                            }
                            if ($val->plafon > 200000000) {
                                $case = 'Ya';
                            }
                            else {
                                $case = 'Tidak';
                            }
                        }
                        else if (session::get('level') == 'koperasi') {
                            if ($cekumurJatuhTempo > 65) {
                                $app_jatuhtempo = 'Tolak';
                                $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin  saat jatuh tempo  yaitu 65 Tahun';
                            }
                            else {
                                $app_jatuhtempo = 'Pengecekan';
                                $catatan_jatuhtempo = '';
                            }

                            if ($val->plafon > 200000000) {
                                $case = 'Ya';
                            }
                            else {
                                $case = 'Tidak';
                            }
                        }

                        $jenisKredit = strtoupper($val->jenis_kredit);
                        $jenisSkema = $val->jenis_skema;
                        $GracePeriod = $val->grace_periode;
                        $masakredit = $val->lamabulan;

                        ($jenisKredit == "PRODUKTIF") ? $kodeProduk = '5' : $kodeProduk = '1';

                        if (session::get('level') == 'koperasi') {
                            //   dd($val);
                            if ($jenisSkema == 'Musiman') {
                                $jenisSkema = 'KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)';
                            }
                            else if ($jenisSkema == 'PHK ASN') {
                                $jenisSkema = 'MACET KARENA MENINGGAL DUNIA & MACET PHK ASN';
                            }
                            else if ($jenisSkema == 'Meninggal Dunia') {
                                $jenisSkema = 'MACET KARENA MENINGGAL DUNIA';
                            }
                        }
                        else {
                            if ($jenisSkema == 'Musiman') {
                                $jenisSkema = 'KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)';
                            }
                            else if ($jenisSkema == 'PHK ASN') {
                                $jenisSkema = 'MACET KARENA MENINGGAL DUNIA & MACET PHK ASN';
                            }
                            else if ($jenisSkema == 'Meninggal Dunia') {
                                $jenisSkema = 'MACET KARENA MENINGGAL DUNIA';
                            }
                        }

                        $rate = rate::leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                            ->where('banks.idbank', Session::get('idbank'))
                            ->where('rate.dari', '<=', $masakredit)
                            ->where('rate.sampai', '>=', $masakredit)
                            ->where('rate.namarate', $jenisSkema)
                            ->where('rate.idproduk', $kodeProduk)
                            ->first();

                        $id = $val->ktp;
                        $kodepusat = $request->kodepusat;
                        $penjaminan = penjaminans::where('terjamins.ktp', $id)
                            ->where('banks.kodepusat', $kodepusat)
                            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                            ->first();                        //                  dd($penjaminan);

                        $hariini = date('Y-m-d');
                        if ($penjaminan) {
                            $jatuhtempo = $penjaminan->tgljatuhtempo;
                            if ($jatuhtempo < $hariini) {
                                $app_ktp = 'Pengecekan';
                                $catatan_ktp = '';
                            }
                            else {
                                $app_ktp = 'Tolak';
                                if ($penjaminan->kodesertifikat) {
                                    $catatan_ktp = 'Mohon maaf nomor KTP yang di dimasukkan sudah terdaftar dengan nomor sertifikat : ' . $penjaminan->kodesertifikat . 'di bank:' . $penjaminan->namabank . ' masa berlaku sertifikat sampai: ' . $penjaminan->tgljatuhtempo;
                                }
                                else {
                                    $catatan_ktp = 'Mohon maaf nomor KTP yang di masukkan sudah di gunakan pada Nasabah atas nama : ' . $penjaminan->nama;
                                }
                            }
                        }
                        else {
                            $app_ktp = 'Pengecekan';
                            $catatan_ktp = '';
                        }

                        //validasi umur
                        if ($umur < 15) {
                            $app_umur = 'Tolak';
                            $catatan_umur = 'Mohon Periksa penulisan Umur, Minimal umur Terjamin adalah 15 Tahun, mohon cek penulisan tanggal lahir di file excel, format yang di dukung yaitu: Tahun/Bulan/Tanggal contoh penulisan : 1993/04/10 !!  ';
                        }
                        else {
                            if ($val->tgllahir == null) {
                                $app_umur = 'Tolak';
                                $catatan_umur = 'Minimal umur Terjamin adalah 15 Tahun, mohon cek penulisan tanggal lahir di file excel, format yang di dukung  yaitu: Tahun/Bulan/Tanggal contoh penulisan : 1993/04/10 !! ';
                            }
                            else {
                                $app_umur = 'Pengecekan';
                                $catatan_umur = '';
                            }
                        }
                        // Validasi Nomor PK 
                        $kodepusat = $request->kodepusat;
                        $penjaminan = penjaminans::where('nopk', $val->nopk)
                            ->where('banks.kodepusat', $kodepusat)
                            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                            ->first();
                        //                  dd($id);
                        if ($penjaminan) {
                            $app_pk = 'Tolak';
                            if ($penjaminan->kodesertifikat) {
                                $catatan_pk = 'Mohon maaf Nomor Perjanjian Kredit yang di dimasukkan sudah terdaftar dengan nomor sertifikat : ' . $penjaminan->kodesertifikat . 'di bank:' . $penjaminan->namabank . ' masa berlaku sertifikat sampai: ' . $penjaminan->tgljatuhtempo;
                            }
                            else {
                                $catatan_pk = 'Mohon maaf nomor Perjanjian Kredit yang di gunakan sebelumnya pada Nasabah atas nama : ' . $penjaminan->nama . ' Bank : ' . $penjaminan->namabank;
                            }
                        }
                        else {
                            $app_pk = 'Pengecekan';
                            $catatan_pk = '';
                        }

                        //hasil pengecekan akhir
                        if ($app_ktp == 'Pengecekan' and
                        $app_jatuhtempo == 'Pengecekan' and
                        $app_umur == 'Pengecekan' and
                        $app_pk == 'Pengecekan') {
                            $app = 'Pengecekan';
                        }
                        else {
                            $app = 'Tolak';
                        }


                        $catatan = $catatan_jatuhtempo . ','
                            . $catatan_ktp . ','
                            . $catatan_pk . ','
                            . $catatan_umur;                        //                    dd($rate->rate);
                        $ijp = ($rate->rate / 100) * $val->plafon;

                        if ($ijp < $rate->minijp) {
                            $ijp = $rate->minijp;
                        }

                        $discount = $rate->dis;
                        $potongan = $ijp * $discount / 100;
                        $nett = $ijp - $potongan;

                        $cek_penjaminan = penjaminans::where([
                            ['jeniskredit', $jenisKredit],
                            ['tglrealisasi', $val->tglrealisasi],
                            ['tgljatuhtempo', $val->tgljatuhtempo],
                            ['nopk', $val->nopk],
                            ['idbank', Session::get('idbank')],
                            ['plafon', $val->plafon],
                        ])->count();

                        if ($cek_penjaminan < 1) {
                            $terjamin = terjamins::create([
                                'ktp' => $val->ktp,
                                'nama' => $val->nama,
                                'phone' => $val->phone,
                                'tempatlahir' => $val->tempatlahir,
                                'tgllahir' => $val->tgllahir,
                                'umur' => $umur . 'Tahun',
                                'pekerjaan' => $val->pekerjaan,
                                'alamat' => $val->alamat,
                                'register' => $nosertifikat,
                            ]);
                            //                        dd($val);

                            if (isset($val->fee)) {
                                //perubahan
                                $dataterjamin = terjamins::where('register', $nosertifikat)->first();
                                $penjaminan = new penjaminans;
                                $penjaminan->user = Session::get('user');
                                $penjaminan->tglpengajuan = $sekarang;
                                $penjaminan->idbank = Session::get('idbank');
                                $penjaminan->idterjamin = $dataterjamin->id;
                                $penjaminan->tglrealisasi = $val->tglrealisasi;
                                $penjaminan->tgljatuhtempo = $val->tgljatuhtempo;
                                $penjaminan->umurjatuhtempo = $umurJatuhTempo;
                                $penjaminan->masakredit = $masakredit;
                                $penjaminan->nopk = $val->nopk;
                                $penjaminan->tglpk = $val->tglpk;
                                $penjaminan->plafon = $val->plafon;
                                $penjaminan->penggunaan = $val->penggunaankredit;
                                $penjaminan->persentase_penjaminan = 100;
                                //                        $penjaminan->detail_skim=  $rate->jnspnj; 
                                $penjaminan->detail_skim = "JIWA";
                                $penjaminan->jenispenjaminan = $val->jenis_skema;
                                $penjaminan->jeniskredit = $jenisKredit;
                                $penjaminan->rate = $val->rate;
                                $penjaminan->premi = $val->grossijp;
                                $penjaminan->dis = ($val->fee / $val->grossijp) * 100;
                                $penjaminan->statusbayar = 0;
                                $penjaminan->app = $app;
                                $penjaminan->nosertifikat = $nosertifikat;
                                $penjaminan->pot = $val->fee;
                                $penjaminan->nett = $val->netijp;
                                $penjaminan->catatan = $catatan;
                                $penjaminan->pemohon = $request->pemohon;
                                $penjaminan->case = $case;
                                $penjaminan->cek = '0';
                                $penjaminan->jenispengajuan = 'baru';
                                $penjaminan->export = 'Ya';
                                $penjaminan->url_penjaminan = $destinationPath;
                                $penjaminan->save();
                            }
                            else {
                                // dd($rate);
                                $dataterjamin = terjamins::where('register', $nosertifikat)->first();
                                $penjaminan = new penjaminans;
                                $penjaminan->user = Session::get('user');
                                $penjaminan->tglpengajuan = $sekarang;
                                $penjaminan->idbank = Session::get('idbank');
                                $penjaminan->idterjamin = $dataterjamin->id;
                                $penjaminan->tglrealisasi = $val->tglrealisasi;
                                $penjaminan->tgljatuhtempo = $val->tgljatuhtempo;
                                $penjaminan->umurjatuhtempo = $umurJatuhTempo;
                                $penjaminan->masakredit = $masakredit;
                                $penjaminan->nopk = $val->nopk;
                                $penjaminan->tglpk = $val->tglpk;
                                $penjaminan->plafon = $val->plafon;
                                $penjaminan->penggunaan = $val->penggunaankredit;
                                $penjaminan->persentase_penjaminan = $rate->persentase_jaminan;
                                $penjaminan->detail_skim = $rate->jnspnj;
                                $penjaminan->jenispenjaminan = $jenisSkema;
                                $penjaminan->jeniskredit = $jenisKredit;
                                $penjaminan->rate = $rate->rate;
                                $penjaminan->premi = $ijp;
                                $penjaminan->dis = $discount;
                                $penjaminan->statusbayar = 0;
                                $penjaminan->app = $app;
                                $penjaminan->nosertifikat = $nosertifikat;
                                $penjaminan->pot = $potongan;
                                $penjaminan->nett = $nett;
                                $penjaminan->catatan = $catatan;
                                $penjaminan->pemohon = $request->pemohon;
                                $penjaminan->case = $case;
                                $penjaminan->cek = '0';
                                $penjaminan->jenispengajuan = 'baru';
                                $penjaminan->export = 'Ya';
                                $penjaminan->url_penjaminan = $destinationPath;
                                $penjaminan->save();
                            }

                            $datapenjaminan = penjaminans::where('nosertifikat', $nosertifikat)->first();
                            $kesehatan = kesehatans::create([
                                'idpenjaminan' => $datapenjaminan->idpenjaminan,
                                'nosertifikat' => $datapenjaminan->nosertifikat,
                            ]);

                            if ($val->grace_periode == 'Ya') {
                                $simpanDataGrace = t_grace_periodes::create([
                                    'id_penjaminan' => $datapenjaminan->idpenjaminan,
                                    'tgl_mulai' => $val->tglrealisasi,
                                    'periode' => $val->masa_grace,
                                ]);
                            }
                        }
                        $i++;
                        $kode = $kode + 1;
                    }
                }
            }
            return redirect('/bpr');
        }
    }



    public function filterPenjaminanBpr(Request $request)
    {

        $dari = self::tanggal($request->dari);
        $sampai = date('Y-m-d 23:59:59.000', strtotime(self::tanggal($request->sampai)));

        if (Session::get('level') != 'User') {
            $penjaminan = penjaminans::with(['terjamin', 'sertifikat', 'bank'])
                ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->whereBetween('sertifikats.tglterbit', [$dari, $sampai])
                ->where([
                ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                ['penjaminans.idbank', session::get('idbank')],
                ['penjaminans.app', 'like', '%' . $request->jenislaporan . '%'],
            ])
                ->wherein('penjaminans.app', ['Lunas', 'Cetak'])                //                             ->orderBy('sertifikats.id','desc') 
                ->get();
        }
        else {
            $penjaminan = penjaminans::with(['terjamin', 'sertifikat', 'bank'])
                ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->whereBetween('sertifikats.tglterbit', [$dari, $sampai])
                ->where([
                ['jeniskredit', 'like', '%' . $request->jenisKredit . '%'],
                ['banks.kodepusat', session::get('kodepusat')],
                ['penjaminans.app', 'like', '%' . $request->jenislaporan . '%'],
            ])
                ->wherein('penjaminans.app', ['Lunas', 'Cetak'])                //                             ->orderBy('sertifikats.id','desc') 
                ->get();
        }

        return view('user.filter', [
            'data' => $penjaminan,
            'dari' => $dari,
            'sampai' => $sampai,
            'jenis' => $request->jenisKredit,
            'app' => $request->jenislaporan,
        ]);
    }

    public function prosesBayar()
    {

        $kodebayar = pembayarans::where('idbank', session::get('idbank'))->count();
        $penjaminan = penjaminans::where('penjaminans.idbank', session::get('idbank'))
            ->where('penjaminans.case', 'Tidak')
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->where('penjaminans.statusbayar', 0)
            ->where('penjaminans.user', session::get('user'))
            ->where('app', '!=', 'Tolak')
            ->get();

        return view('user.pembayaranAll', ['data' => $penjaminan, 'kode' => $kodebayar]);
    }

    protected function SavePembayaran($request, $NamaFile, $url)
    {
        $pembayaran = new pembayarans();
        $pembayaran->idpenjaminan = $request->idpenjaminan;
        $pembayaran->kodebayar = $request->kodepembayaran;
        $pembayaran->tglbayar = $request->tglbayar;
        $pembayaran->jumlah = self::nilai($request->totalbayar);
        $pembayaran->idbank = session::get('idbank');
        $pembayaran->file = $NamaFile;
        $pembayaran->url_file_bayar = $url;
        $pembayaran->save();
    }

    public function prosesBayarCase($id)
    {
        $nosertifikat = base64_decode($id);
        $kodebayar = pembayarans::where('idbank', session::get('idbank'))->count();
        $penjaminan = penjaminans::where('penjaminans.idbank', session::get('idbank'))
            ->where('statusbayar', 0)
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->where('nosertifikat', $nosertifikat)
            ->get();
        Session::flash('pesan', 'File pembayaran telah di upload !');
        return view('user.pembayaranCase', ['data' => $penjaminan, 'kode' => $kodebayar]);
    }

    public function prosesBayarAuto($id)
    {

        $nosertifikat = Crypt::decrypt($id);


        $kodebayar = pembayarans::where('idbank', session::get('idbank'))->count();
        $penjaminan = penjaminans::where('penjaminans.idbank', session::get('idbank'))
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->where('penjaminans.statusbayar', 0)
            ->where('penjaminans.nosertifikat', $nosertifikat)
            ->get();

        return view('user.pembayaran', ['data' => $penjaminan, 'kode' => $kodebayar]);
    }

    protected function UpdateStatusPembayaran($request)
    {
        penjaminans::where('idbank', '=', session::get('idbank'))
            ->where('statusbayar', 0)
            ->where('nosertifikat', $request->nosertifikat)
            ->update([
            'statusbayar' => '1',
            'kodebayar' => $request->kodepembayaran,
            'app' => 'Pengecekan',
            'tglrealisasi' => ($request->tglrealisasi) ? $this->tanggal($request->tglrealisasi) : "",
            'tgljatuhtempo' => ($request->TglJatuhTempo) ? $this->tanggal($request->TglJatuhTempo) : "",
            'tglpk' => ($request->tglrealisasi) ? $this->tanggal($request->tglrealisasi) : "",
            'nopk' => ($request->NoPK) ? $request->NoPK : "",
        ]);
    }

    protected function SendMailNotification($request, $pesan)
    {
        //       dd($request);
        $cek = $request->jenisPembayaran == 'pembayaranAll';        //                dd($cek);
        $datapenjaminan = penjaminans::
            where([
            ($request->idpenjaminan) ? 
            ['penjaminans.idpenjaminan', $request->idpenjaminan] :
            ($cek) ? 
            ['penjaminans.idbank', '=', session::get('idbank')] :
            ['nosertifikat', $request->nosertifikat],
            ['penjaminans.user', session::get('user')],
            ['penjaminans.statusbayar', 0]
        ])
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->get();

        if ($request->approval == 'ulang') {
            $datapenjaminan = penjaminans::
                where(
                'penjaminans.idpenjaminan', $request->idpenjaminan
            )
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->get();
        }



        ($request->approval != 'ulang') ? 
            $pesan = "Pengajuan penjaminan : " . $datapenjaminan[0]['namabank'] . " Tanggal : " . date('d-m-Y') :
            $pesan = "Pengajuan ulang penjaminan : " . $datapenjaminan[0]['namabank'] . " Tanggal : " . date('d-m-Y');
        $users = User::where('level', 'admin')->get();

        foreach ($users as $data) {
            Mail::send('emails.bank-bayar', ['data' => $datapenjaminan], function ($message) use ($data, $request, $pesan) {
                $message->to($data->email)
                    ->cc('it.dev@jamkridantb.com')
                    ->subject($pesan);
            });
        }
    }

    public function AddPembayaran(Request $request)
    {
        // mendapatkan nama berkas asli
        $fileName = $request->file('filePembayaran')->getClientOriginalName();
        // mendapatkan ektensi berkas
        $ekstensi = $request->file('filePembayaran')->getClientOriginalExtension();
        // mendapatkan ukuran berkas
        $request->file('filePembayaran')->getClientSize();
        $NamaFile = "BuktiBayar-" . md5($fileName) . '-' . $request->kodepembayaran . '-' . date('ymdhis') . '.' . $ekstensi;
        $uploadedFile = $request->file('filePembayaran');
        $dataPenjaminan = penjaminans::select('url_penjaminan', 'kodebayar')->where('idpenjaminan', $request->idpenjaminan)->first(); //-->mengambil URL Pengajuan
        $dataPembayaran = pembayarans::select('url_file_bayar')->where('kodebayar', $dataPenjaminan->kodebayar)->first(); //-->mengambil URL File bayar
//        dd($dataPenjaminan);

        if ($request->action == 'update') { //--> Digunakan jika update Bukti Pembayaran
            $pembayaran = pembayarans::where('kodebayar', '=', $request->kodepembayaran)->get();            //            @unlink('files/buktibayar/' . $pembayaran[0]['file']);//-->Kode Lama Hapus Bukti Bayar
//            dd($dataPembayaran);
            if ($dataPembayaran->url_file_bayar != null) {
                @unlink($dataPembayaran->url_file_bayar . $pembayaran[0]['file']);
                $url = $dataPembayaran->url_file_bayar;
                $upload = $request->file('filePembayaran')->move($url, $NamaFile);
            }
            else {
                @unlink($dataPenjaminan->url_penjaminan . $pembayaran[0]['file']);
                $url = $dataPenjaminan->url_penjaminan;
                $upload = $request->file('filePembayaran')->move("files/buktibayar/", $NamaFile); //--> Kode Lama 
            }            //         

            if ($upload) {
                pembayarans::where('kodebayar', '=', $request->kodepembayaran)
                    ->update([
                    'jumlah' => self::nilai($request->totalbayar),
                    'file' => $NamaFile,
                ]);
                Session::flash('pesan', 'File pembayaran telah di upload !');
            }
        }
        else {
            //  DD($request);
            if ($dataPenjaminan->url_penjaminan != null) {
                $urlbayar = $dataPenjaminan->url_penjaminan;
                $upload = $request->file('filePembayaran')->move($urlbayar, $NamaFile);

            }
            else {
                $urlbayar = "files/buktibayar/";
                $upload = $request->file('filePembayaran')->move($urlbayar, $NamaFile); //--> Kode Lama 
            }

            if ($upload) {
                //fungsi untuk melakukan penyimpanan pembayaran
                $SimpanPembayaran = $this->SavePembayaran($request, $NamaFile, $urlbayar);

                if ($request->jenisPembayaran == 'pembayaranSingle') {                    //                   $pesan = "";
                    $this->SendMailNotification($request, $pesan);
                    penjaminans::where('idbank', '=', session::get('idbank'))
                        ->where('statusbayar', 0)
                        ->where('nosertifikat', $request->nosertifikat)
                        ->update([
                        'statusbayar' => '1',
                        'kodebayar' => $request->kodepembayaran,
                        'app' => 'Pengecekan',
                    ]);
                }
                else {                    //                 DD($request);
                    $pesan = "";
                    $this->SendMailNotification($request, $pesan);
                    penjaminans::
                        where([
                        ['idbank', '=', session::get('idbank')],
                        ['user', session::get('user')],
                        ['statusbayar', 0],
                        ['case', 'Tidak'],
                    ])
                        ->update([
                        'statusbayar' => '1',
                        'kodebayar' => $request->kodepembayaran,
                    ]);                //                  dd($update);
                }
                Session::flash('pesan', 'File pembayaran telah di upload !');
            }
        }        //        dd(Session::get('level'));
        if (Session::get('level') == 'BPR') {
            return redirect('/bpr');
        }
        else {
            return Redirect::back();
        }    //        
//      
    }

    public function AddPembayaranCase(Request $request)
    {
        $fileName = $request->file('filePembayaran')->getClientOriginalName();
        // mendapatkan ektensi berkas
        $ekstensi = $request->file('filePembayaran')->getClientOriginalExtension();
        // mendapatkan ukuran berkas
        $request->file('filePembayaran')->getClientSize();

        $NamaFile = "BuktiBayar-" . md5($fileName) . '-' . $request->kodepembayaran . '-' . date('ymdhis') . '.' . $ekstensi;
        $FilePembayaran = $this->cek_file('filePembayaran', $request);
        $dataPenjaminan = penjaminans::select('url_penjaminan')->where('idpenjaminan', $request->idpenjaminan)->first(); //-->mengambil URL Pengajuan
//            dd($request)
        if ($FilePembayaran == 'Ada') {
            if ($dataPenjaminan->url_penjaminan != null) {
                $urlbayar = $dataPenjaminan->url_penjaminan;
                $upload = $request->file('filePembayaran')->move($urlbayar, $NamaFile);

            }
            else {
                $urlbayar = "files/buktibayar/";
                $upload = $request->file('filePembayaran')->move($urlbayar, $NamaFile); //--> Kode Lama 
            }            //                $hasilUploadfilePembayaran  = $this->upload_file('filePembayaran','files/buktibayar/',$request);
            $SimpanPembayaran = $this->SavePembayaran($request, $NamaFile, $urlbayar);
            if (isset($request->nosertifikat)) {
                $pesan = "'Aplikasi Penjaminan Kredit - Pengajuan Penjaminan No Registrasi : '";                //                $this->SendMailNotification($request, $pesan);
                $this->UpdateStatusPembayaran($request);
            }
        }
        Session::flash('pesan', 'File pembayaran telah di upload !');
        return redirect('bpr');
    }

    public function cetaksuratpengajuan($id)
    {

        $suratpengajuan = penjaminans::where('nosertifikat', $id)
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('t_history_banks', 'banks.idbank', '=', 't_history_banks.bank_id')
            ->get();        //        dd($suratpengajuan);
        $pdf = PDF::loadView('user.laporan.suratpengajuan', compact('suratpengajuan'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'calibri']);
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');

        return $pdf->stream('SuratPengajuan' . '/' . $suratpengajuan[0]['namabank'] . '/' . $suratpengajuan[0]['kodebayar'] . '/' . $suratpengajuan[0]['jeniskredit'] . '/' . $suratpengajuan[0]['jenispenjaminan'] . '.pdf');
    }

    public function simpanlogcetak(request $request)
    {

        $id = $request->id;
        $cetak = new cetaks();
        $cetak->idpenjaminan = $id;
        $cetak->tglcetak = date('Y-m-d H:i:s');
        $cetak->oleh = session::get('name') . '/' . session::get('nama');
        $cetak->keterangan = 'Sertifikat';
        $cetak->save();
    }

    public function cetakLaporanPenjaminanPdf($id)
    {

        $sertifikat = penjaminans::where('nosertifikat', $id)
            ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->get();
        //dd($bayar);

        $pdf = PDF::loadView('user.laporan.laporanpenjaminan', compact('sertifikat'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Sertifikat' . '/' . $sertifikat[0]['namabank'] . '/' . $sertifikat[0]['kodebayar'] . '/' . $sertifikat[0]['jeniskredit'] . '/' . $sertifikat[0]['jenispenjaminan'] . '.pdf');
    }

    public function PostChangePass(request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255',
            'passwordlama' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);


        $credentials = [
            'username' => $request->get('username'),
            'password' => $request->get('passwordlama'),
        ];

        if (\Auth::validate($credentials)) {
            $user = \App\User::where('username', $request->username)
                ->update([
                'password' => bcrypt($request->password)
            ]);
            Session::flash('ubahpass', '');
            return redirect('bpr');
        }
        else {
            Session::flash('pesan', 'Password lama yang dimasukkan tidak sesuai');
            return redirect('bpr');
        }
    //        if (Auth::attempt(['username' => $request->username, 'password' => $request->passwordlama])) {
//            $user = users::where('username', $request->username)
//                                ->update([
//                            'password' => bcrypt($request->password)
//                        ]);
//              return redirect('/bpr');
//    
//        }
    }

    public function getUserList()
    {

        $user = User::where('role', '!=', '0A')->orderBy('id', 'desc')->get();

        return Datatables::of($user)
            ->addColumn('action', function ($user) {
            return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="edit-pengguna/' . $user->id . '" class="icon-button icon-color-blue">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="detail-pengguna/' . $user->id . '" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
        })
            ->make(true);
    }

    public function datatable(Request $request)
    {

        $penjaminan = penjaminans::query();
        return Datatables::of($penjaminan)
            ->filter(function ($query) use ($request) {
            if (request()->has('nama')) {
                $query->where('nama', 'like', '%' . $request->nama . '%');
            }
            else {
                $query;
            }
        })
            ->addColumn('action', function ($penjaminan) {
            return '<a href="#" class="btn btn-xs btn-primary edit" id="' . $penjaminan->idpenjaminan . '"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })
            ->make(true);
    }

    function fetchdata(Request $request)
    {

        $id = $request->id;

        $penjaminan = penjaminans::select('*', 'penjaminans.idpenjaminan')
            ->where('penjaminans.idpenjaminan', $id)
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('t_grace_periodes', 't_grace_periodes.id_penjaminan', '=', 'penjaminans.idpenjaminan')
            ->first();        //dd($penjaminan);
        $totalbayar = $penjaminan->nett + $penjaminan->admin + $penjaminan->materai;
        $output = [
            'tglGrace' => date('d/m/Y', strtotime($penjaminan->tgl_mulai)),
            'phone' => $penjaminan->phone,
            'masaGrace' => $penjaminan->periode,
            'totalbayar' => number_format($totalbayar, 2, '.', ','),
            'admin' => number_format($penjaminan->admin, 2, '.', ','),
            'materai' => number_format($penjaminan->materai, 2, '.', ','),
            'siup' => $penjaminan->siup,
            'npwp' => $penjaminan->npwp,
            'idpenjaminan' => $penjaminan->idpenjaminan,
            'idbank' => $penjaminan->idbank,
            'nosertifikat' => $penjaminan->nosertifikat,
            'ktp' => $penjaminan->ktp,
            'nama' => $penjaminan->nama,
            'tempatlahir' => $penjaminan->tempatlahir,
            'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
            'umur' => $penjaminan->umur,
            'pekerjaan' => $penjaminan->pekerjaan,
            'jenis_pekerjaan' => $penjaminan->jenis_pekerjaan,
            'jeniskredit' => $penjaminan->jeniskredit,
            'penggunaan' => $penjaminan->penggunaan,
            'alamat' => $penjaminan->alamat,
            'tglrealisasi' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
            'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'umurjatuhtempo' => $penjaminan->umurjatuhtempo,
            'nopk' => $penjaminan->nopk,
            'tglpk' => date('d/m/Y', strtotime($penjaminan->tglpk)),            //            'jenispenjaminan' => $penjaminan->jenispenjaminan,
            'tglpengajuan' => $penjaminan->tglpengajuan,
            'statusbayar' => $penjaminan->statusbayar,
            'kodebayar' => $penjaminan->kodebayar,
            'masakredit' => $penjaminan->masakredit,
            'plafon' => $penjaminan->plafon,
            'rate' => $penjaminan->rate,
            'premi' => $penjaminan->premi,
            'dis' => $penjaminan->dis,
            'pot' => $penjaminan->pot,
            'nett' => number_format($penjaminan->nett, 2, '.', ','),
            'app' => $penjaminan->app,
            'case' => $penjaminan->case,
            'kodepusat' => $penjaminan->kodepusat,
            'jenispenjaminan1' => $penjaminan->jenispenjaminan,
            'jenispenjaminan' => $penjaminan->jenispenjaminan,
        ];
        echo json_encode($output);
    }

    //edit dan tambah
    function postdata(Request $request)
    {        //        dd($request->sertifikat);
        $url = penjaminans::select('url_penjaminan')->where('nosertifikat', $request->sertifikat)->first();
        $url = $url->url_penjaminan; //dd($url); 
//        dd($url);
        $validation = Validator::make($request->all(), [
            'fileUploadSuratSehat' => 'required',
        ]);

        $dokumen = kesehatans::where('nosertifikat', $request->sertifikat)->first();
        if ($request->hasFile('fileUploadSuratSehat')) {
            if (isset($dokumen)) { //-> kondisi jika update surat sehat  
                @unlink($url . $dokumen->files); //--> Menghapus surat sehat yang ada sebelumnya  
                $NamaFile = $this->update_file('fileUploadSuratSehat', $url, $request);
                if ($NamaFile) { //-> jika upload berhasil maka akan update informasi kesehatan
                    $update = kesehatans::where('nosertifikat', $request->sertifikat)
                        ->update([
                        'files' => $NamaFile
                    ]);
                    Session::flash('pesan', 'Surat sehat berhasil diupload');
                }
                else {
                    Session::flash('pesan', 'Gagal Simpan data');
                }
            }
            else {
                $NamaFile = $this->upload_file('fileUploadSuratSehat', '', $request); //Proses upload dokumen kesehatan baru
                if ($NamaFile) {
                    $kesehatan = new kesehatans([
                        'files' => $NamaFile
                    ]);
                    $kesehatan->save();
                    Session::flash('pesan', 'Surat sehat berhasil diupload');
                }
                else {
                    Session::flash('pesan', 'Gagal Simpan data');
                }
            }
        }
        else if ($request->hasFile('fileUploadScanLab')) {
            @unlink($url . $dokumen->files2); //hapus file lama
            $NamaFile = $this->update_file('fileUploadScanLab', $url, $request);
            if ($NamaFile) {
                $scanlab = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['files2' => $NamaFile, ]);
                Session::flash('pesan', 'Scan Lab berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadGetaranJantung')) {
            @unlink($url . $dokumen->getaran_jantung); //hapus file lama
            $NamaFile = $this->update_file('fileUploadGetaranJantung', $url, $request);
            if ($NamaFile) {
                $scanlab = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['getaran_jantung' => $NamaFile, ]);
                Session::flash('pesan', 'File Getaran Jantung berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadRs')) {
            @unlink($url . $dokumen->files3); //hapus file lama
            $NamaFile = $this->update_file('fileUploadRs', $url, $request);
            if ($NamaFile) {
                $scanlab = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['files3' => $NamaFile, ]);
                Session::flash('pesan', 'Surat Sehat Dari Rumah Sakit berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadktp')) {
            @unlink($url . $dokumen->foto_ktp); //hapus file lama
            $NamaFile = $this->update_file('fileUploadktp', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['foto_ktp' => $NamaFile, ]);
                Session::flash('pesan', 'Foto KTP Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadFotoUsaha')) {
            @unlink($url . $dokumen->foto_usaha); //hapus file lama
            $NamaFile = $this->update_file('fileUploadFotoUsaha', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['foto_usaha' => $NamaFile, ]);
                Session::flash('pesan', 'Foto Usaha Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadSlik')) {
            @unlink($url . $dokumen->hasil_slik); //hapus file lama
            $NamaFile = $this->update_file('fileUploadSlik', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['hasil_slik' => $NamaFile, ]);
                Session::flash('pesan', 'Foto SLIK Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadAnalisis')) {
            @unlink($url . $dokumen->analisis_kelayakan); //hapus file lama
            $NamaFile = $this->update_file('fileUploadAnalisis', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['analisis_kelayakan' => $NamaFile, ]);
                Session::flash('pesan', 'Foto Analisis Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadTaksasi')) {
            @unlink($url . $dokumen->taksasi_agunan); //hapus file lama
            $NamaFile = $this->update_file('fileUploadTaksasi', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['taksasi_agunan' => $NamaFile, ]);
                Session::flash('pesan', 'File Taksasi Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadPersetujuanKredit')) {
            @unlink($url . $dokumen->surat_persetujuan_kredit); //hapus file lama
            $NamaFile = $this->update_file('fileUploadPersetujuanKredit', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['surat_persetujuan_kredit' => $NamaFile, ]);
                Session::flash('pesan', 'File Persetujuan Kredit  Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadRiwayatKredit')) {
            @unlink($url . $dokumen->surat_riwayat_kredit); //hapus file lama
            $NamaFile = $this->update_file('fileUploadRiwayatKredit', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['surat_riwayat_kredit' => $NamaFile, ]);
                Session::flash('pesan', 'File Riwayat Kredit Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadSk')) {
            @unlink($url . $dokumen->sk_pengangkatan); //hapus file lama
            $NamaFile = $this->update_file('fileUploadSk', $url, $request);
            if ($NamaFile) {
                $update = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['sk_pengangkatan' => $NamaFile, ]);
                Session::flash('pesan', 'File SK Berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else {
            Session::flash('pesan', 'Gagal simpan data, tidak ada file yang di pilih');
        }
        return Redirect::back();
    }


    function postdataOri(Request $request)
    {        //        dd($request);
        $url = penjaminans::select('url_penjaminan')->where('nosertifikat', $request->sertifikat)->first();
        $url = $url->url_penjaminan;

        $validation = Validator::make($request->all(), [
            'fileUpload' => 'required',
        ]);
        if ($request->hasFile('fileUpload')) {
            $fileName = $request->file('fileUpload')->getClientOriginalName();
            // mendapatkan ektensi berkas
            $ekstensi = $request->file('fileUpload')->getClientOriginalExtension();
            // mendapatkan ukuran berkas
            $request->file('fileUpload')->getClientSize();
            $NamaFile = 'Surat-Sehat-' . md5($fileName) . $request->sertifikat . '.' . $ekstensi;

            if ($request->button_action == 'UploadSuratSehat') { //->
                $jumlahsuratsehat = kesehatans::where('nosertifikat', $request->sertifikat)->count();
                $suratsehat = kesehatans::where('nosertifikat', $request->sertifikat)->get();

                if ($jumlahsuratsehat > 0) { //-> kondisi jika update surat sehat
                    $suratsehat = kesehatans::where('nosertifikat', $request->sertifikat)->get();
                    @unlink($url . $suratsehat[0]['files']); //--> Menghapus surat sehat yang ada sebelumnya
                    //  unlink("scanlab/$suratsehat->files");
                    $upload = $request->file('fileUpload')->move($url, $NamaFile); //-->Upload surat sehat baru

                    if ($upload) { //-> jika upload berhasil maka akan update informasi kesehatan
                        $update = kesehatans::where('nosertifikat', $request->sertifikat)
                            ->update([
                            'files' => $NamaFile
                        ]);
                        Session::flash('pesan', 'Surat sehat berhasil diupload');
                    }
                    else {
                        Session::flash('pesan', 'Gagal Simpan data');
                    }
                }
                else {
                    $upload = $request->file('fileUpload')->move($url, $NamaFile); //Proses upload dokumen kesehatan baru

                    if ($upload) {
                        $kesehatan = new kesehatans([
                            'nosertifikat' => $request->sertifikat,
                            'files' => $NamaFile
                        ]);
                        $kesehatan->save();
                        Session::flash('pesan', 'Surat sehat berhasil diupload');
                    }
                    else {
                        Session::flash('pesan', 'Gagal Simpan data');
                    }
                }
            }
        }
        else if ($request->hasFile('fileUploadScanLab')) {

            $suratsehat = kesehatans::where('nosertifikat', $request->sertifikat)->get();            //            @unlink("files/scanlab/". $suratsehat[0]['files2']);
            @unlink($url . $suratsehat[0]['files2']);
            $fileName = $request->file('fileUploadScanLab')->getClientOriginalName();
            // mendapatkan ektensi berkas
            $ekstensi = $request->file('fileUploadScanLab')->getClientOriginalExtension();
            // mendapatkan ukuran berkas
            $request->file('fileUploadScanLab')->getClientSize();
            $NamaFile = 'Cek-Lab-' . md5($fileName) . $request->sertifikat . '.' . $ekstensi;            //            $upload = $request->file('fileUploadScanLab')->move("files/scanlab/", $NamaFile);
            $upload = $request->file('fileUploadScanLab')->move($url, $NamaFile);
            if ($upload) {
                $scanlab = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update(['files2' => $NamaFile, ]);
                Session::flash('pesan', 'Scan Lab berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else if ($request->hasFile('fileUploadRs')) {

            $suratsehat = kesehatans::where('nosertifikat', $request->sertifikat)->get();            //            @unlink('files/suratsehatrs/' . $suratsehat[0]['files3']);
            @unlink($url . $suratsehat[0]['files3']);
            $fileName = $request->file('fileUploadRs')->getClientOriginalName();
            // mendapatkan ektensi berkas
            $ekstensi = $request->file('fileUploadRs')->getClientOriginalExtension();
            // mendapatkan ukuran berkas
            $request->file('fileUploadRs')->getClientSize();
            $NamaFile = 'Surat-Keterangan-RS-' . md5($fileName) . $request->sertifikat . '.' . $ekstensi;
            $upload = $request->file('fileUploadRs')->move($url, $NamaFile);

            if ($upload) {

                $scanlab = kesehatans::where('nosertifikat', $request->sertifikat)
                    ->update([
                    'files3' => $NamaFile,
                ]);

                Session::flash('pesan', 'Surat Sehat Dari Rumah Sakit berhasil diupload');
            }
            else {
                Session::flash('pesan', 'Upload gagal, silahkan ulangi kembali');
            }
        }
        else {
            Session::flash('pesan', 'Gagal simpan data, tidak ada file yang di pilih');
        }

        return Redirect::back();
    }

    public function BelumBayar()
    {
        $penjaminan = penjaminans::where('penjaminans.idbank', session::get('idbank'))
            ->where('statusbayar', 0)
            ->where('case', 'Tidak')
            ->where('app', 'Pengecekan')
            // ->orwhere('app','Pembayaran')
            ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->get();
        return view('user.autocoverbelumbayar', [
            'data' => $penjaminan,
        ]);
    }

    public function datarate()
    {

        $rate = DB::table('rate')
            ->where('rate.idbank', session::get('idbank'))
            ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
            ->get();
        ;
        return view('user.rate', [
            'rate' => $rate]);
    }

    public function CaseDapatBayar()
    {

        $totalcasedapatbayar = penjaminans::where('case', 'Ya')
            ->where('statusbayar', 0)
            ->where('app', 'Pembayaran')
            ->where('idbank', session::get('idbank'))
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
            ->get();

        return view('user.casedapatbayar', [
            'data' => $totalcasedapatbayar,
        ]);
    }

    public function disetujui()
    {

        $disetujui = penjaminans::where('app', 'Setuju')
            ->where('statusbayar', 1)
            ->where('cek', '0')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->get();

        return view('user.sudahdisetujui', [
            'data' => $disetujui,
        ]);
    }

    public function ditolak()
    {

        $ditolak = penjaminans::select('*', 'penjaminans.idpenjaminan')
            ->where('app', 'Tolak')            //                ->where('history_tolakans.cek', 'T')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('history_tolakans', 'history_tolakans.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->take(100)
            ->get();
        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();        //DD( session::get('user'));

        foreach ($ditolak as $key => $data) {

            $update = penjaminans::
                where([
                ['history_tolakans.cek', 'T'],
                ['penjaminans.idbank', Session::get('idbank')]
            ])
                ->leftJoin('history_tolakans', 'history_tolakans.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->update([
                'history_tolakans.cek' => 'Y',
            ]);        //            dd($update);
        }
        return view('user.ditolak', [
            'ditolak' => $ditolak,
            'rate' => $rate,
        ]);
    }

    public function Revisi()
    {

        $ditolak = penjaminans::select('*', 'penjaminans.idpenjaminan')
            ->where('app', 'Revisi')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('kesehatan', 'penjaminans.idpenjaminan', '=', 'kesehatan.idpenjaminan')
            ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->take(10)
            ->get();        //        dd($ditolak);
        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();

        return view('user.revisi', [
            'ditolak' => $ditolak,
            'rate' => $rate,
        ]);
    }

    public function sertifikatcetak()
    {
        $sertifikat = penjaminans::where('statusbayar', 1)
            ->where('penjaminans.idbank', session::get('idbank'))
            ->where('app', 'Cetak')
            ->where('cek', '0')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->get();

        return view('user.sertifikatcetak', [
            'sertifikat' => $sertifikat
        ]);
    }

    function cekjatuhtempo(Request $request)
    {

        $jatuhtempo = self::tanggal($request->jatuhtempo);
        $realisasi = self::tanggal($request->realisasi);
        if ($jatuhtempo < $realisasi || $jatuhtempo == $realisasi) {
            $status = 1;
        }
        else {
            $status = 0;
        }

        $output = [
            'hasil' => $status];

        echo json_encode($output);
    }

    function cekpklama(Request $request)
    {
        $nopk = $request->nopk;
        $idbank = $request->idbank;
        $penjaminan = penjaminans::where('nopk', $nopk)
            ->where('idbank', $idbank)
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->first();        //        dd($penjaminan->alamat);
        if ($penjaminan) {
            //           $isi = "$kecamatan-$data[1]-$data[0]";

            $hariini = date('Y-m-d');
            $jatuhtempo = $penjaminan->tgljatuhtempo;


            // if ($jatuhtempo < $hariini) {
            //     $status = 'Expired';
            // } else {
            //     $status = 'Aktif';
            // }

            ($jatuhtempo < $hariini) ? $status = 'Expired' : $status = 'Aktif';

            $output = [
                'status' => $status,
                'kodesertifikat' => $penjaminan->kodesertifikat,
                'ktp' => $penjaminan->ktp,
                'tempatlahir' => $penjaminan->tempatlahir,
                'namaterjamin' => $penjaminan->nama,
                'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
                'alamat' => $penjaminan->alamat,
                'desa' => '-',
                'kecamatan' => '-',
                'kabupaten' => '-',
                'pekerjaan' => $penjaminan->pekerjaan,
                'admin' => number_format($penjaminan->admin, 0, '.', ','),
                'materai' => number_format($penjaminan->materai, 0, '.', ','),
                'siup' => $penjaminan->siup,
                'npwp' => $penjaminan->npwp,
                'idpenjaminan' => $penjaminan->idpenjaminan,
                'idbank' => $penjaminan->idbank,
                'nosertifikat' => $penjaminan->nosertifikat,
                'ktp' => $penjaminan->ktp,
                'nama' => $penjaminan->nama,
                'tempatlahir' => $penjaminan->tempatlahir,
                'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
                'umur' => $penjaminan->umur,
                'pekerjaan' => $penjaminan->pekerjaan,
                'jeniskredit' => $penjaminan->jeniskredit,
                'tglrealisasi' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
                'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
                'umurjatuhtempo' => $penjaminan->umurjatuhtempo,
                'nopk' => $penjaminan->nopk,
                'tglpk' => date('d/m/Y', strtotime($penjaminan->tglpk)),                //            'jenispenjaminan' => $penjaminan->jenispenjaminan,
                'tglpengajuan' => $penjaminan->tglpengajuan,
                'statusbayar' => $penjaminan->statusbayar,
                'kodebayar' => $penjaminan->kodebayar,
                'masakredit' => $penjaminan->masakredit,
                'plafon' => number_format($penjaminan->plafon, 0, '.', ','),
                'rate' => $penjaminan->rate,
                'premi' => $penjaminan->premi,
                'dis' => $penjaminan->dis,
                'pot' => $penjaminan->pot,
                'nett' => number_format($penjaminan->nett, 2, '.', ','),
                'app' => $penjaminan->app,
                'case' => $penjaminan->case,
                'jenispenjaminan' => $penjaminan->jenispenjaminan . '|' . $penjaminan->rate . '|' . $penjaminan->dis . '|' . $penjaminan->pot . '|' . $penjaminan->nett . '|' . $penjaminan->premi,
            ];
        }
        else {
            $output = [
                'ktp' => '',
                'namaterjamin' => '',
                'tgllahir' => '',
                'alamat' => '',
                'pekerjaan' => '',
                'admin' => '',
                'materai' => '',
                'siup' => '',
                'npwp' => '',
                'idpenjaminan' => '',
                'idbank' => '',
                'nosertifikat' => '',
                'ktp' => '',
                'nama' => '',
                'tgllahir' => '',
                'umur' => '',
                'pekerjaan' => '',
                'jeniskredit' => '',
                'alamat' => '',
                'tglrealisasi' => '',
                'tgljatuhtempo' => '',
                'umurjatuhtempo' => '',
                'nopk' => '',
                'tglpk' => '',                //            'jenispenjaminan' => $penjaminan->jenispenjaminan,
                'tglpengajuan' => '',
                'statusbayar' => '',
                'kodebayar' => '',
                'masakredit' => '',
                'plafon' => '',
                'rate' => '',
                'premi' => '',
                'dis' => '',
                'pot' => '',
                'nett' => '',
                'app' => '',
                'case' => '',
                'jenispenjaminan' => '',
            ];
        }
        echo json_encode($output);
    }

    function cekktp(Request $request)
    {

        $id = $request->noktp;
        $kodepusat = $request->kodepusat;
        $idbank = $request->idbank;


        if ($kodepusat == '6') {

            //untuk mengecek kode pusat sumbawa, karena ketentuan di PD.BPR Sumbawa
            //Satu nasabah dapat dapat diberikan satu pinjaman dicabang yang berbeda
            $penjaminan = penjaminans::where(
            [($request->nosertifikat) ? 
                ['sertifikats.kodesertifikat', $request->nosertifikat] :
                ['terjamins.ktp', $id]
            ]
            )
                ->where('banks.idbank', $idbank)                //                    ->where('banks.kodepusat', $kodepusat)
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        //            dd($penjaminan);
        }
        else {

            $penjaminan = penjaminans::where(
            [($request->nosertifikat) ? 
                ['sertifikats.kodesertifikat', $request->nosertifikat] :
                ['terjamins.ktp', $id],
                ['banks.kodepusat', $kodepusat]
            ]
            )                //                    ->wherein('penjaminans.app', ['Lunas', 'Cetak'])
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        }



        if ($penjaminan->isEmpty()) {
            $output = [                //                'status' => $status,
                'ktp' => '',
                'namaterjamin' => '',
                'tgllahir' => '',
                'alamat' => '',
                'pekerjaan' => '',
                'admin' => '',
                'materai' => '',
                'siup' => '',
                'npwp' => '',
                'idpenjaminan' => '',
                'idbank' => '',
                'nosertifikat' => '',
                'ktp' => '',
                'nama' => '',
                'tgllahir' => '',
                'umur' => '',
                'pekerjaan' => '',
                'jeniskredit' => '',
                'alamat' => '',
                'tglrealisasi' => '',
                'tgljatuhtempo' => '',
                'umurjatuhtempo' => '',
                'nopk' => '',
                'tglpk' => '',                //            'jenispenjaminan' => $penjaminan->jenispenjaminan,
                'tglpengajuan' => '',
                'statusbayar' => '',
                'kodebayar' => '',
                'masakredit' => '',
                'plafon' => '',
                'rate' => '',
                'premi' => '',
                'dis' => '',
                'pot' => '',
                'nett' => '',
                'app' => '',
                'case' => '',
                'jenispenjaminan' => ''];
        }
        else {
            //           $data = explode(", ", $penjaminan->alamat);
//           $isi = "$data[2]-$data[1]-$data[0]";
//           
            $hariini = date('Y-m-d');
            $jatuhtempo = $penjaminan[0]['tgljatuhtempo'];

            if ($jatuhtempo < $hariini) {
                $status = 'Expired';
            }
            else {
                $status = 'Aktif';
            }

            $output = [
                'kodepusat' => $kodepusat,
                'phone' => $penjaminan[0]['phone'],
                'statusbayar' => $penjaminan[0]['statusbayar'],
                'namabank' => $penjaminan[0]['namabank'],
                'status' => $status,
                'kodesertifikat' => $penjaminan[0]['kodesertifikat'],
                'ktp' => $penjaminan[0]['ktp'],
                'tempatlahir' => $penjaminan[0]['tempatlahir'],
                'namaterjamin' => $penjaminan[0]['nama'],
                'tgllahir' => date('d/m/Y', strtotime($penjaminan[0]['tgllahir'])),
                'alamat' => $penjaminan[0]['alamat'],                //            'desa' => substr($data[1],15),
//            'kecamatan' => substr($data[2],10),
//            'kabupaten' => substr($data[3],15),
                'pekerjaan' => $penjaminan[0]['pekerjaan'],
                'admin' => number_format($penjaminan[0]['admin'], 0, '.', ','),
                'materai' => number_format($penjaminan[0]['materai'], 0, '.', ','),
                'siup' => $penjaminan[0]['siup'],
                'npwp' => $penjaminan[0]['npwp'],
                'idpenjaminan' => $penjaminan[0]['idpenjaminan'],
                'idbank' => $penjaminan[0]['idbank'],
                'nosertifikat' => $penjaminan[0]['nosertifikat'],
                'ktp' => $penjaminan[0]['ktp'],
                'nama' => $penjaminan[0]['nama'],
                'tempatlahir' => $penjaminan[0]['tempatlahir'],
                'tgllahir' => date('d/m/Y', strtotime($penjaminan[0]['tgllahir'])),
                'umur' => $this->HitungUmurAll($penjaminan[0]['tgllahir']),
                'pekerjaan' => $penjaminan[0]['pekerjaan'],
                'jeniskredit' => $penjaminan[0]['jeniskredit'],
                'tglrealisasi' => date('d/m/Y', strtotime($penjaminan[0]['tglrealisasi'])),
                'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan[0]['tgljatuhtempo'])),
                'umurjatuhtempo' => $penjaminan[0]['umurjatuhtempo'],
                'nopk' => $penjaminan[0]['nopk'],
                'tglpk' => date('d/m/Y', strtotime($penjaminan[0]['tglpk'])),                //           'jenispenjaminan' => $penjaminan[0]['jenispenjaminan,
                'tglpengajuan' => $penjaminan[0]['tglpengajuan'],
                'statusbayar' => $penjaminan[0]['statusbayar'],
                'kodebayar' => $penjaminan[0]['kodebayar'],
                'masakredit' => $penjaminan[0]['masakredit'],
                'plafon' => $penjaminan[0]['plafon'],
                'rate' => $penjaminan[0]['rate'],
                'premi' => $penjaminan[0]['premi'],
                'dis' => $penjaminan[0]['dis'],
                'pot' => $penjaminan[0]['pot'],
                'nett' => number_format($penjaminan[0]['nett'], 2, '.', ','),
                'app' => $penjaminan[0]['app'],
                'case' => $penjaminan[0]['case'],
                'tanggapandir' => $penjaminan[0]['tanggapandir'],
                'jenispenjaminan' => $penjaminan[0]['jenispenjaminan'] . '|' . $penjaminan[0]['rate'] . '|' . $penjaminan[0]['dis'] . '|' . $penjaminan[0]['pot'] . '|' . $penjaminan[0]['nett'] . '|' . $penjaminan[0]['premi'],
                'fasilitas' => $penjaminan[0]['fasilitas'],
                'penjaminan' => $penjaminan,
            ];
        }
        echo json_encode($output);
    }

    function cekinputpenjaminan(Request $request)
    {

        $id = $request->idbank;
        $data = penjaminans::where('idbank', $id)
            ->where('user', session::get('user'))
            //->where('plafon', '<=', 200000000)
            ->where('case', '!=', 'Ya')
            ->where('statusbayar', '0')
            ->where('app', '!=', 'Tolak')
            ->where('tglpengajuan', '<', date('Y-m-d'))
            ->count();
        if ($data) {
            $output = [
                'jumlah' => $data,
            ];
        }
        else {
            $output = [
                'jumlah' => '',
            ];
        }
        echo json_encode($output);
    }

    function tanggaljatuhtempo(Request $request)
    {

        $masakredit = $request->masakredit;
        $realisasi = self::tanggal($request->realisasi);

        $jatuhtempo = date('d/m/Y', strtotime("+$masakredit month", strtotime($realisasi)));
        $output = [
            'jatuhtempo' => $jatuhtempo,
        ];
        echo json_encode($output);
    }

    function hitungumur(Request $request)
    {

        $hariini = new DateTime("now");
        $lahir = date('Y-m-d', strtotime(self::tanggal($request->tglLahir)));
        $tgllahir = new DateTime($lahir);
        $umur = $tgllahir->diff($hariini);


        $output = [
            'umur' => $umur->y,
        ];
        echo json_encode($output);
    }

    protected function HitungUmurAll($TanggalLahir)
    {
        $hariini = new DateTime("now");
        $lahir = date('Y-m-d', strtotime($TanggalLahir));
        $tgllahir = new DateTime($lahir);
        $umur = $tgllahir->diff($hariini);

        return $umur->y;
    }

    function hitungumurCase(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $hariini = new DateTime("now");
        $lahir = date('Y-m-d', strtotime($this->tanggal($request->tglLahir)));
        $tgllahir = new DateTime($lahir);
        $masakredit = $request->masakredit;
        if ($request->caseket == 'Ya') {
            $tgl = "now";
        }
        else if ($request->caseket == 'Tidak') {
            $tgl = $this->tanggal($request->realisasi);
        }
        else {
            $tgl = "now";
        }
        $jatuhtempo = date('Y-m-d', strtotime("+$masakredit month", strtotime($tgl)));        //dd($jatuhtempo);
        $tgljatuhtempo = new DateTime($jatuhtempo);

        $umur = $tgllahir->diff($tgljatuhtempo);
        $output = [
            'Tahun' => $umur->y,
            'Bulan' => $umur->m,
            'Hari' => $umur->d,
        ];
        echo json_encode($output);
    }

    function cekdokkesehatan(Request $request)
    {

        $id = $request->idbank;

        $jumlahSuratSehatKosong = penjaminans::where('idbank', $id)
            ->leftJoin('kesehatan', 'penjaminans.idpenjaminan', '=', 'kesehatan.idpenjaminan')
            ->where('plafon', '<=', 100000000)
            ->where('kesehatan.files', '')
            ->where('app', '!=', 'Tolak')
            ->count();
        $jumlahScanLabKosong = penjaminans::where('kesehatan.files2', '')
            ->where('idbank', $id)
            ->leftJoin('kesehatan', 'penjaminans.idpenjaminan', '=', 'kesehatan.idpenjaminan')
            ->where('plafon', '>', 300000000)
            ->where('kesehatan.files2', '')
            ->where('app', '!=', 'Tolak')
            ->count();        //        dd();

        $jumlahSuratSehatRs = penjaminans::where('idbank', $id)
            ->leftJoin('kesehatan', 'penjaminans.idpenjaminan', '=', 'kesehatan.idpenjaminan')
            ->whereBetween('plafon', array(100000001, 300000000))
            ->where('kesehatan.files3', '')
            ->where('app', '!=', 'Tolak')
            ->count();

        if ($jumlahSuratSehatKosong || $jumlahSuratSehatRs || $jumlahScanLabKosong) {
            $output = [
                'jumlahsuratsehat' => $jumlahSuratSehatKosong,
                'jumlahsuratsehatRs' => $jumlahSuratSehatRs,
                'jumlahScanLab' => $jumlahScanLabKosong,
            ];
        }
        else {
            $output = [
                'jumlahsuratsehat' => '',
                'jumlahsuratsehatRs' => '',
                'jumlahScanLab' => '',
            ];
        }
        echo json_encode($output);
    }

    function ceknopk(Request $request)
    {

        $id = $request->nopk;
        $idbank = $request->idbank;
        $data = penjaminans::where('nopk', $id)
            ->where('idbank', $idbank)
            ->count();
        if ($data) {
            $output = [
                'nopk' => $data,
            ];
        }
        else {
            $output = [
                'nopk' => '',
            ];
        }
        echo json_encode($output);
    }

    public function hapuspenjaminan(request $request)
    {

        $id = $request->id;
        //  DB::delete('delete from penjaminans where idpenjaminan = ?',[$id]);
        //Hapus data terjamin
        $dataterjamin = penjaminans::where('idpenjaminan', $id)->first();

        $hapusterjamin = terjamins::where('id', $dataterjamin->idterjamin)->delete();
        //Hapus data Penjaminan
        $penjaminan = penjaminans::where('idpenjaminan', $id)->delete();

        $kesehatan = kesehatans::
            where('idpenjaminan', '=', $id)
            ->first();

        @unlink('files/suratsehat/' . $kesehatan->files);
        @unlink('files/scanlab/' . $kesehatan->files2);

        $kesehatan = kesehatans::
            where('idpenjaminan', '=', $id)
            ->delete();

        echo json_encode('Pengajuan berhasil di hapus!!! ');
    //            $pembayaran = pembayarans::where('kodebayar', '=', $request->kodepembayaran)->get();
//            @unlink('files/buktibayar/' . $pembayaran[0]['file']);
    }

    public function sertifikatTerbitAll()
    {
        $idbank = session::get('idbank');        //           $pengajuan = sertifikats::with('penjaminan')->orderby('id','desc')->limit(10)->get();
        $pengajuan = penjaminans::with(['terjamin', 'kesehatan', 'bank', 'pembayaran'])
            ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->where('app', 'Cetak')
            ->where('penjaminans.idbank', $idbank)
            ->orderBy('sertifikats.id', 'desc')            //                    ->limit(100)
//                    ->get(); 
            ->paginate(300);        //           dd($pengajuan);
        return view('user.sertifikatuser1', ['pengajuan' => $pengajuan]);
    }

    public function sertifikatTerbitAllBackup()
    {
        $pengajuan = penjaminans::
            wherein('penjaminans.app', ['Lunas', 'Cetak'])
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->orderBy('sertifikats.id', 'desc')
            ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
            ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
            ->orderBy('sertifikats.id', 'desc')
            ->take(150)
            ->get();
        // dd($pengajuan);
        return view('user.sertifikatuser1', ['pengajuan' => $pengajuan]);
    }

    public function carisertifikat(request $request)
    {
        $pengajuan = penjaminans::wherein('penjaminans.app', ['Lunas', 'Cetak'])
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->when($request->jenis == 'kodesertifikat', function ($q) use ($request) {
            return $q->where('kodesertifikat', 'like', '%' . $request->data . '%');
        })
            ->when($request->jenis == 'nama', function ($q) use ($request) {
            return $q->where('terjamins.nama', 'like', '%' . $request->data . '%');
        })
            ->paginate(500);
        // dd($pengajuan);
        return view('user.sertifikatuser1', ['pengajuan' => $pengajuan]);
    }

    public function cekrealisasi(request $request)
    {        //        dd($request);
        $hari_ini = date('Y-m-d');
        $tanggal_realisai = $this->tanggal($request->tgl_realisasi);
        $tanggal1 = new DateTime($hari_ini);
        $tanggal2 = new DateTime($tanggal_realisai);
        $selisih = $tanggal2->diff($tanggal1)->format("%a");

        if ($tanggal2 > $tanggal1) {
            $lebih = true;
        }
        else {
            $lebih = false;
        }

        $data = [
            'selisih' => $selisih,
            'lebih' => $lebih,
        ];
        //        DD($data);

        return json_encode($data);
    }

    public function CekJatuhTempoCase(request $request)
    {        //        dd($request);

        $masakredit = $request->masakredit;
        $realisasi = self::tanggal($request->tgl_realisasi);
        $jatuhtempo = date('d/m/Y', strtotime("+$masakredit month", strtotime($realisasi)));

        $dataCase = [
            'jatuhtempo' => $jatuhtempo,
        ];


        return json_encode($dataCase);
    }

    public function CekPlafon(request $request)
    {
        $data = [
            'plafon' => self::nilai($request->plafon),
            'level' => session::get('level'),
            'test' => 'hediawan',
        ];
        return json_encode($data);
    }

    public function kirimdata(request $request)
    {

        $kodePenjaminan = penjaminans::count();
        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();

        $data = [
            'plafon' => self::nilai($request->plafon),
            'level' => session::get('level'),
            'test' => 'hediawan',
        ];
        return json_encode($data);    //         return view('user.inputpenjaminan_case', [
//            'data' => $data,
//            'kode' => $kodePenjaminan,
//            'rate' => $rate,
//           
//        ]);
    }

    public function KirimCase(Request $request)
    {

        $update = penjaminans::where('idpenjaminan', $request->idpenjaminan)
            ->update([
            'app' => 'AnalisPenjaminan',
        ]);

        $pesan = "'Pengajuan Case By Case Penjaminan No Registrasi : '";        //        $this->SendMailNotification($request, $pesan);

        //jika proses update biasa
        Session::flash('pesan', 'Data Pengajuan Case By Case Berhasil Terkirim Ke PT. Jamkrida NTB');
        return redirect('bpr');
    }

    public function filterSertifikatByDate(Request $request)
    {

        $dari = self::tanggal($request->dari);
        $sampai = date('Y-m-d 23:59:59.000', strtotime(self::tanggal($request->sampai)));

        $pengajuan = penjaminans::whereBetween('tglpengajuan', array($dari, $sampai))
            ->where('jeniskredit', 'like', '%' . $request->jenisKredit . '%')
            ->where('penjaminans.idbank', session::get('idbank'))
            ->where('penjaminans.app', 'like', '%' . $request->jenislaporan . '%')
            ->wherein('penjaminans.app', ['Lunas', 'Cetak'])
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->paginate(1500);

        return view('user.sertifikatuser1', ['pengajuan' => $pengajuan]);
    }

    public function formProduktif()
    {
        $kodePenjaminan = penjaminans::where('jeniskredit', 'PRODUKTIF')->count();
        return view('user.inputpenjaminanProduktif', [
            'kode' => $kodePenjaminan,
        ]);
    }
    public function formKonsumtif()
    {
        $kodePenjaminan = penjaminans::where('jeniskredit', 'KONSUMTIF')->count();
        return view('user.inputpenjaminanKonsumtif', [
            'kode' => $kodePenjaminan,
        ]);
    }

    public function SimpanPenjaminanProduktif(Request $request)
    {        //        dd($request); 
        $urlPenjaminan = $this->url_penjaminan($request);        //        dd($urlPenjaminan);
        $validation = [
        ];
        $this->validate($request, [
            'phone' => 'required|max:15',
            'alamat' => 'required|max:255',
            'desa' => ($request->desa) ? 'required|max:255' : '',
            'kecamatan' => ($request->kecamatan) ? 'required|max:255' : '',
            'kabupaten' => ($request->kabupaten) ? 'required|max:255' : '',
            'tempatlahir' => 'required|max:255',
            'tglLhr' => 'required|max:255',
            'kredit' => 'required|max:15',
            'ktp' => 'required|max:20',
            'pekerjaan' => 'required|max:255',
            'nopk' => 'required|max:255',
            'tglrealisasi' => 'required|max:255',
            'masakredit' => 'required|max:255',
            'plafon' => 'required|max:255|min:5',
//            'fileSuratSehat' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf|max:1024', 
            'fileSuratSehat' => ($request->fileSuratSehat) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'fileSuratSehatRs' => ($request->fileSuratSehatRs) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'fileCekLab' => ($request->fileCekLab) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekGetaranJantung' => ($request->cekGetaranJantung) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekKTP' => ($request->cekKTP) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekUsaha' => ($request->cekUsaha) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekSlik' => ($request->cekSlik) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekAnalisis' => ($request->cekAnalisis) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekTaksasi' => ($request->cekTaksasi) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekSuratPersetujuanKredit' => ($request->cekSuratPersetujuanKredit) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekRiwayatKredit' => ($request->cekRiwayatKredit) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
            'cekDocSk' => ($request->cekDocSk) ? 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1024' : '',
        ]);

        $alamat = $this->CekPenulisanAlamat($request);
        $masakredit = $request->masakredit;
        $cekpk = $this->CekPK($request);
        $nopklama = $cekpk['NoPK'];
        $nosertifikatlama = $cekpk['NoSertifikatLama'];
        $CekSiup = $this->CekSiup($request);
        $siup = $CekSiup['siup'];
        $npwp = $CekSiup['npwp'];
        $dataumur = explode(':', $request->umur);
        $tahun = $dataumur[0];
        $plafon = self::nilai($request->plafon);
        $realisasi = self::tanggal($request->tglrealisasi);
        $jatuhtempo = date('Y/m/d', strtotime("+$masakredit month", strtotime($realisasi)));
        $tarif = $this->CekRate($request);
        $ijp = $this->CekMinIJP($tarif, $plafon);
        $rate = $tarif->rate;
        $dis = $tarif->dis;
        $persentase_jaminan = $tarif->persentase_jaminan;
        $detail_skim = $tarif->jnspnj;
        $potongan = $ijp * ($dis / 100);
        $nett = $ijp - $potongan;
        $premi = $ijp;
        $data = explode('|', $request->jenisPenjaminan);
        $jenisPenjaminan = $data[0];


        if ($request->hasFile('fileSuratSehat')) {
            $hasilUploadfileSuratSehat = $this->upload_file('fileSuratSehat', 'files/suratsehat/', $request);
        }
        else {
            $hasilUploadfileSuratSehat = "";
        }

        if ($request->hasFile('fileSuratSehatRs')) {
            $hasilUploadfileSuratSehatRs = $this->upload_file('fileSuratSehatRs', 'files/suratsehatrs/', $request);
        }
        else {
            $hasilUploadfileSuratSehatRs = "";
        }

        if ($request->hasFile('fileCekLab')) {
            $hasilUploadfileCekLab = $this->upload_file('fileCekLab', 'files/scanlab/', $request);
        }
        else {
            $hasilUploadfileCekLab = "";
        }
        if ($request->hasFile('cekGetaranJantung')) {
            $hasilUploadfileCekGetaranJantung = $this->upload_file('cekGetaranJantung', 'files/scanlab/', $request);
        }
        else {
            $hasilUploadfileCekGetaranJantung = "";
        }

        if ($request->hasFile('cekKTP')) {
            $hasilUploadfileCekKTP = $this->upload_file('cekKTP', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekKTP = "";
        }
        if ($request->hasFile('cekUsaha')) {
            $hasilUploadfilecekUsaha = $this->upload_file('cekUsaha', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekUsaha = "";
        }
        if ($request->hasFile('cekSlik')) {
            $hasilUploadfileCekSlik = $this->upload_file('cekSlik', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekSlik = "";
        }
        if ($request->hasFile('cekAnalisis')) {
            $hasilUploadfilecekAnalisis = $this->upload_file('cekAnalisis', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekAnalisis = "";
        }
        if ($request->hasFile('cekTaksasi')) {
            $hasilUploadfileCekTaksasi = $this->upload_file('cekTaksasi', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekTaksasi = "";
        }
        if ($request->hasFile('cekSuratPersetujuanKredit')) {
            $hasilUploadfilecekSuratPersetujuanKredit = $this->upload_file('cekSuratPersetujuanKredit', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekSuratPersetujuanKredit = "";
        }
        if ($request->hasFile('cekRiwayatKredit')) {
            $hasilUploadRiwayatKredit = $this->upload_file('cekRiwayatKredit', '/directory/', $request);
        }
        else {
            $hasilUploadRiwayatKredit = "";
        }

        $cek_penjaminan = penjaminans::where([
            ['jeniskredit', $request->kredit],
            ['tglrealisasi', ($request->tglrealisasi) ?self::tanggal($request->tglrealisasi) : ''],
            ['tgljatuhtempo', $jatuhtempo],
            ['nopk', ($request->nopk) ? $request->nopk : ''],
            ['idbank', $request->idbank],
            ['plafon', self::nilai($request->plafon)],
        ])->count();        //         echo  $request->kredit. " <br>";
//         echo self::tanggal($request->tglrealisasi). " <br>";
//         echo  $jatuhtempo. " <br>";
//         echo   $request->nopk. " <br>";
//         echo  $request->idbank. " <br>";
//         echo  self::nilai($request->plafon). " <br>"; 
//         dd($cek_penjaminan);

        if ($cek_penjaminan > 0) {
            Session::flash('pesan', 'Penjaminan gagal diinput, data yang dimasukkan sudah terdaftar !!!');
            return redirect('bpr');
        }
        else {
            $terjamin = $this->SaveTerjamin($request, $tahun, $alamat);
            $penjaminan = $this->SaveTransaksiPenjaminan(
                $terjamin,
                $nopklama,
                $nosertifikatlama,
                $siup, $npwp,
                $request,
                $jatuhtempo,
                $rate,
                $premi,
                $dis,
                $potongan,
                $nett,
                $jenisPenjaminan,
                $urlPenjaminan,
                $persentase_jaminan,
                $detail_skim
            );
            $kesehatan = $this->SaveKesehatanMacet(
                $penjaminan,
                $request,
                $hasilUploadfileSuratSehat,
                $hasilUploadfileSuratSehatRs,
                $hasilUploadfileCekLab,
                $hasilUploadfileCekGetaranJantung,
                $hasilUploadfileCekKTP,
                $hasilUploadfilecekUsaha,
                $hasilUploadfileCekSlik,
                $hasilUploadfilecekAnalisis,
                $hasilUploadfileCekTaksasi,
                $hasilUploadfilecekSuratPersetujuanKredit,
                $hasilUploadRiwayatKredit,
                ''
            );
            if ($request->jnsGracePeriode == 'ya') {
                $simpanDataGrace = t_grace_periodes::create([
                    'id_penjaminan' => $penjaminan->id,
                    'tgl_mulai' => self::tanggal($request->tglGrace),
                    'periode' => $request->masaGrace,
                ]);
            }
            return redirect('bpr');
        }
    }

    public function SimpanPenjaminanKonsumtif(Request $request)
    {

        $urlPenjaminan = $this->url_penjaminan($request);

        $validation = [
        ];
        $this->validate($request, [
            'phone' => 'required|max:15',
            'alamat' => 'required|max:255',
            'desa' => ($request->desa) ? 'required|max:255' : '',
            'kecamatan' => ($request->kecamatan) ? 'required|max:255' : '',
            'kabupaten' => ($request->kabupaten) ? 'required|max:255' : '',
            'tempatlahir' => 'required|max:255',
            'tglLhr' => 'required|max:255',
            'kredit' => 'required|max:15',
            'ktp' => 'required|max:20',
            'pekerjaan' => 'required|max:255',
            'jabatan' => 'required|max:255',
            'nopk' => 'required|max:255',
            'tglrealisasi' => 'required|max:255',
            'masakredit' => 'required|max:255',
            'plafon' => 'required|max:255',
        ]);

        $alamat = $this->CekPenulisanAlamat($request);
        $masakredit = $request->masakredit;
        $cekpk = $this->CekPK($request);
        $nopklama = $cekpk['NoPK'];
        $nosertifikatlama = $cekpk['NoSertifikatLama'];
        $CekSiup = $this->CekSiup($request);
        $siup = $CekSiup['siup'];
        $npwp = $CekSiup['npwp'];
        $dataumur = explode(':', $request->umur);
        $tahun = $dataumur[0];
        $plafon = self::nilai($request->plafon);
        $realisasi = self::tanggal($request->tglrealisasi);
        $jatuhtempo = date('Y/m/d', strtotime("+$masakredit month", strtotime($realisasi)));
        $tarif = $this->CekRate($request);
        $ijp = $this->CekMinIJP($tarif, $plafon);
        $rate = $tarif->rate;
        $dis = $tarif->dis;
        $persentase_jaminan = $tarif->persentase_jaminan;
        $detail_skim = $tarif->jnspnj;
        $potongan = $ijp * ($dis / 100);
        $nett = $ijp - $potongan;
        $premi = $ijp;
        $data = explode('|', $request->jenisPenjaminan);
        $jenisPenjaminan = $data[0];


        if ($request->hasFile('fileSuratSehat')) {
            $hasilUploadfileSuratSehat = $this->upload_file('fileSuratSehat', 'files/suratsehat/', $request);
        }
        else {
            $hasilUploadfileSuratSehat = "";
        }

        if ($request->hasFile('fileSuratSehatRs')) {
            $hasilUploadfileSuratSehatRs = $this->upload_file('fileSuratSehatRs', 'files/suratsehatrs/', $request);
        }
        else {
            $hasilUploadfileSuratSehatRs = "";
        }

        if ($request->hasFile('fileCekLab')) {
            $hasilUploadfileCekLab = $this->upload_file('fileCekLab', 'files/scanlab/', $request);
        }
        else {
            $hasilUploadfileCekLab = "";
        }
        if ($request->hasFile('cekGetaranJantung')) {
            $hasilUploadfileCekGetaranJantung = $this->upload_file('cekGetaranJantung', 'files/scanlab/', $request);
        }
        else {
            $hasilUploadfileCekGetaranJantung = "";
        }


        if ($request->hasFile('cekKTP')) {
            $hasilUploadfileCekKTP = $this->upload_file('cekKTP', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekKTP = "";
        }
        if ($request->hasFile('cekUsaha')) {
            $hasilUploadfilecekUsaha = $this->upload_file('cekUsaha', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekUsaha = "";
        }
        if ($request->hasFile('cekSlik')) {
            $hasilUploadfileCekSlik = $this->upload_file('cekSlik', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekSlik = "";
        }
        if ($request->hasFile('cekAnalisis')) {
            $hasilUploadfilecekAnalisis = $this->upload_file('cekAnalisis', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekAnalisis = "";
        }
        if ($request->hasFile('cekTaksasi')) {
            $hasilUploadfileCekTaksasi = $this->upload_file('cekTaksasi', '/directory/', $request);
        }
        else {
            $hasilUploadfileCekTaksasi = "";
        }
        if ($request->hasFile('cekSuratPersetujuanKredit')) {
            $hasilUploadfilecekSuratPersetujuanKredit = $this->upload_file('cekSuratPersetujuanKredit', '/directory/', $request);
        }
        else {
            $hasilUploadfilecekSuratPersetujuanKredit = "";
        }

        if ($request->hasFile('cekRiwayatKredit')) {
            $hasilUploadRiwayatKredit = $this->upload_file('cekRiwayatKredit', '/directory/', $request);
        }
        else {
            $hasilUploadRiwayatKredit = "";
        }

        if ($request->hasFile('cekDocSk')) {
            $hasilUploadSK = $this->upload_file('cekDocSk', '/directory/', $request);
        }
        else {
            $hasilUploadSK = "";
        }

        $cek_penjaminan = penjaminans::where([
            ['jeniskredit', $request->kredit],
            ['tglrealisasi', ($request->tglrealisasi) ?self::tanggal($request->tglrealisasi) : ''],
            ['tgljatuhtempo', $jatuhtempo],
            ['nopk', ($request->nopk) ? $request->nopk : ''],
            ['idbank', $request->idbank],
            ['plafon', self::nilai($request->plafon)],
        ])->count();        //         echo  $request->kredit. " <br>";
//         echo self::tanggal($request->tglrealisasi). " <br>";
//         echo  $jatuhtempo. " <br>";
//         echo   $request->nopk. " <br>";
//         echo  $request->idbank. " <br>";
//         echo  self::nilai($request->plafon). " <br>"; 
//         dd($cek_penjaminan);

        if ($cek_penjaminan > 0) {
            Session::flash('pesan', 'Penjaminan gagal diinput, data yang dimasukkan sudah terdaftar !!!');
            return redirect('bpr');
        }
        else {
            $terjamin = $this->SaveTerjamin($request, $tahun, $alamat);
            $penjaminan = $this->SaveTransaksiPenjaminan(
                $terjamin,
                $nopklama,
                $nosertifikatlama,
                $siup,
                $npwp,
                $request,
                $jatuhtempo,
                $rate,
                $premi,
                $dis,
                $potongan,
                $nett,
                $jenisPenjaminan,
                $urlPenjaminan,
                $persentase_jaminan,
                $detail_skim
            );
            $kesehatan = $this->SaveKesehatanMacet(
                $penjaminan,
                $request,
                $hasilUploadfileSuratSehat,
                $hasilUploadfileSuratSehatRs,
                $hasilUploadfileCekLab,
                $hasilUploadfileCekGetaranJantung,
                $hasilUploadfileCekKTP,
                $hasilUploadfilecekUsaha,
                $hasilUploadfileCekSlik,
                $hasilUploadfilecekAnalisis,
                $hasilUploadfileCekTaksasi,
                $hasilUploadfilecekSuratPersetujuanKredit,
                $hasilUploadRiwayatKredit,
                $hasilUploadSK
            );
            if ($request->jnsGracePeriode == 'ya') {
                $simpanDataGrace = t_grace_periodes::create([
                    'id_penjaminan' => $penjaminan->id,
                    'tgl_mulai' => self::tanggal($request->tglGrace),
                    'periode' => $request->masaGrace,
                ]);
            }
            return redirect('bpr');
        }
    }


    protected function ShowDetailPejaminan(request $request)
    {
        //        dd($request);
        $rate_detail = rate::
            leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
            ->leftJoin('produks', 'produks.idproduk', '=', 'rate.idproduk')
            ->where('banks.idbank', $request->idbank)
            ->where('rate.dari', '<=', $request->bulan)
            ->where('rate.sampai', '>=', $request->bulan)
            ->where('rate.jnspnj', $request->detailSkim)
            ->where('produks.jeniskategori', $request->jeniskredit)
            ->get();        //        dd($rate_detail);

        echo "<select  required id='jenisPenjaminan' name='jenisPenjaminan' class='form-control'>";        //        echo "<option value=''>Pilih Detail Penjaminan</option>";

        foreach ($rate_detail as $key => $rate) {


            $rates = $rate->rate;
            $bulan = $request->bulan;
            $namarate = $rate->namarate;
            $plafon = $this->GabungNilai($request->plafon);
            $dis = $rate->dis;
            $premi = $plafon * ($rate->rate / 100);

            if ($premi < $rate->minijp) {
                $premi = $rate->minijp;
            }
            $potongan = ($rate->dis / 100) * $premi;
            $nett = $premi - $potongan;

            if ($namarate == 'KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)') {
                $namarate = 'MACET KARENA MENINGGAL DUNIA(Musiman)';
                $ValNamaRate = $rate->namarate;
            }
            else {
                $namarate = $rate->namarate;
                $ValNamaRate = $rate->namarate;
            }
            echo "<option value='" . $ValNamaRate . "'>" . $namarate . "|" . $bulan . " Bln | Rp. " . $request->plafon . "| RATE :" . $rates . "%| IJP : " . $this->formatUang($premi) . " | DIS : " . $dis . " % | POT. : " . $this->formatUang($potongan) . "| NETT: " . $this->formatUang($nett) . " </option>";
        }
        echo "</select>";
    }

    protected function showPersyaratan(request $request)
    {
        $plafon = $this->GabungNilai($request->plafon);

        $rate_detail = persyaratans::where([
            ['bank_id', $request->idbank],
            ['jns_kredit', $request->jeniskredit],
            ['jns_penjaminan', $request->detailSkim],
            ['min_plafon', '<=', $plafon],
            ['max_plafon', '>=', $plafon]
        ])
            ->first();        //                dd($rate_detail);
//              return      $rate_detail;
//              
//      "halo";
//        dd($rate_detail);

        return json_encode($rate_detail);
    }

    function detailPenjaminan($id)
    {
        $penjaminan = penjaminans::select('*', 'penjaminans.idpenjaminan')->where('penjaminans.idpenjaminan', $id)
            ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
            ->leftJoin('persyaratans', 'persyaratans.id', '=', 'penjaminans.persyaratan_id')
            ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
            ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
            ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            ->first();
        
//        $history_cases = penjaminans::where('penjaminans.idpenjaminan', $id)
//                     ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                     ->first(); 
        $user = Auth::user()->jabatan;
        $historyApproval = history_apps::
            select(
            'history_apps.id',
            'history_apps.analisa',
            'history_apps.approval',
            'history_apps.tgl_analisa',
            'users.name',
            'history_apps.komputer'
        )
            ->where('idpenjaminan', $id)
            ->leftjoin('users', 'users.id', '=', 'history_apps.user')
            ->orderBy('history_apps.id', 'desc')
            ->get();
        $detailSkim = $penjaminan->detail_skim;        //       dd($penjaminan);
//        echo json_encode($output);

        return view('user.detailPenjaminan', compact('penjaminan', 'historyApproval', 'user'));

    }


    public function pengajuanUlang(Request $request)
    {        //        dd( Auth::user()->id); 

        $update = penjaminans::where('idpenjaminan', $request->idpenjaminan)
            ->update([
            'app' => 'ulang',
        ]);
        $this->CreateHistoryApp($request, $request->tanggapan);


        Session::flash('pesan', 'Data pengajuan berhasil diajukan kembali');
        return redirect('bpr');
    }


    protected function CreateHistoryApp($request, $analisa)
    {
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s', strtotime('+1 hour'));
        history_apps::create([
            'analisa' => $analisa,
            'approval' => 'ulang',
            'tgl_analisa' => date('Y-m-d H:i:s', strtotime('+1 hour ')),
            'user' => Auth::user()->id,
            'idpenjaminan' => $request->idpenjaminan,            //                           'komputer'       => gethostname(),
        ]);

    }

    protected function cekKondisiCase(request $request)
    {

        $plafon = $this->GabungNilai($request->plafon);

        $data = persyaratans::where([
            ['bank_id', $request->idbank],
            ['jns_kredit', $request->jeniskredit],
            ['min_plafon', '<=', $plafon],
            ['max_plafon', '>=', $plafon]
        ])
            ->first();

        return json_encode($data);

    }



}
