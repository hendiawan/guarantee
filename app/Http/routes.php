<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//---->>>>  ROUTE UNTUK PROSES LOGIN

Route::auth(); 
Route::get('/','LoginController@index' );
Route::post('/login/proses','LoginController@ProsesLogin' );
Route::get('/logout','LoginController@doLogout' );
Route::get('/home', 'HomeController@index');

//---->>>>  ROUTE UNTUK APPROVAL DIREKSI
Route::get('appdireksi', 'DireksiController@cekappdireksi');
Route::get('validasi/direksi', 'DireksiController@post_app_direksi');
Route::get('DigitalSign', 'DireksiController@DigitalSign');
Route::get('DigitalSignSb', 'DireksiController@DigitalSignSb');
Route::get('SingleDigitalSign', function () {
    return view('admin.sign.SingleDigitalSign');
});
Route::post('/PostSingleSign', 'DireksiController@TestingSingleSign');

Route::post('/PostSign', 'DireksiController@testingsign');
Route::post('/PostSignSb', 'DireksiController@signSb');

//---->>>>  ROUTE UNTUK APPROVAL VERIFIKASI
Route::get('verifikasi-sertifikat-penjaminan/{id}','VerifyController@verify');
Route::get('verifikasi-doc-sertifikat-penjaminan/{id}','VerifyController@verifyDoc');
Route::get('verifikasi-doc-sertifikat-surety/{id}','VerifyController@verifyDocSb');
Route::get('verifikasi-tanda-tangan/{id}','VerifyController@verifyttd');

//---->>>>  ROUTE UNTUK EXPORT KE SIMPK
Route::post('filterexport', 'ExportController@FilterExport');
Route::get('sinkronisasi', 'ExportController@sinkronisasi');
Route::get('sinkronisasi-perbank', 'ExportController@DataSinkronisasi');
Route::get('sinkronisasi-perbank/{id}', 'ExportController@DataSinkronisasiDetail');
Route::get('sinkronisasi-perbank/{id}/{tgl1}/{tgl2}', 'ExportController@DataSinkronisasiDetailPertgl');
Route::post('/save-export','ExportController@SaveExport');
Route::get('eksport-data-penjaminan', 'ExportController@sinkronisasi_cek_data');
Route::get('hapus-data-penjaminan', 'ExportController@hapus_data_penjaminan');

//---->>>>  ROUTE UNTUK LAPORAN
Route::post('detail_laporan_internal','LaporanController@detail_laporan_internal');
Route::post('detail_laporan_internal_excel','LaporanController@detail_laporan_internal_excel');
Route::post('cetaklaporanexcel',  'LaporanController@cetaklaporanexcel'); 
Route::post('cetaklaporanexceladmin',  'LaporanController@cetaklaporanexcel'); 
Route::post('cetaklaporan','LaporanController@cetaklaporan');
Route::get('simpanlogcetak', 'LaporanController@simpanlogcetak');
Route::get('detailcetak/{id}', 'LaporanController@tampillogcetak');
Route::post('cetaklaporanpdfadmin','LaporanController@cetaklaporanpdf');
Route::post('cetaklaporanpdf',  'LaporanController@cetakLaporanPdfUser'); 
Route::get('/cetakpdf/{id}',  'LaporanController@cetakPdf'); 
Route::get('cetaksertifikat/{id}',  'LaporanController@cetaksertifikat'); 

Route::get('sertifikatSppsb/{sppsb}',  'AdminController@sertifikatSppsb'); 

Route::get('/cetaksp3/{id}',  'LaporanController@cetakSP3'); 
Route::get('/cetakrekomendasi/{id}',  'LaporanController@cetakRekomendasi'); 

//---->>>>  ROUTE UNTUK ADMIN CONTROLLER

Route::get('ShowHistoryApproval', 'AdminController@ShowHistoryApproval');
Route::get('hasil-app-direksi', 'AdminController@casesetuju');
Route::get('terbitkan-sp3', 'AdminController@terbitkansp3');
Route::get('terbitkan-surat-tolak', 'AdminController@terbitkansurattolak');
Route::get('pembayaran/{id}', 'AdminController@cek_buktibayar');
Route::get('kesehatan/{id}', 'AdminController@cek_kesehatan');
Route::get('kesehatanrs/{id}', 'AdminController@cek_kesehatanrs');
Route::get('cek-jumlah-sudah-app', 'AdminController@cek_jumlah_sudah_app');
Route::get('/belumProsesUlangCase','AdminController@CekPengajuanulangcase');
Route::get('eksport-data-penjaminan-view','AdminController@eksport_data_penjaminan_view');
Route::get('pelunasan','AdminController@pelunasan');
Route::get('registerbank', 'Admincontroller@registerbank');
Route::get('verifysert', 'Admincontroller@qrcode');
Route::get('verifysertifikat', 'Admincontroller@verifysertifikat');
Route::get('generateqrcode', 'Admincontroller@qrcodegenerator');
Route::get('/penjaminan', 'AdminController@index');
Route::post('/registerbank', 'AdminController@postregisterbank');
Route::get('datarate', 'AdminController@datarate');
Route::get('rate', 'AdminController@rate');
Route::get('detailrate/{id}', 'AdminController@detailrate');
Route::get('detailrate/ubahrate/', 'AdminController@ubahrate');
Route::post('/simpanpenjaminan', 'AdminController@impanPenjaminan');
Route::get('/datapenjaminan', 'AdminController@datapenjaminan');
Route::get('/datapenjaminanview', 'AdminController@datapenjaminanview');
Route::get('sudahsetuju/datapenjaminanview', 'AdminController@datapenjaminanview');
Route::get('bank', 'AdminController@bank');
Route::get('fetchdatabank','AdminController@FetchDataBank');
Route::get('/belumproses/{id}','AdminController@CekPengajuan');
//Route::get('sertifikatTerbit/{id}','AdminController@CekPengajuan');
Route::get('sudahsetuju/{id}','AdminController@setuju');
Route::get('endorsment','AdminController@endorsment');
Route::post('caridatapelunasan','AdminController@caridatapelunasan');
Route::post('cari-data-penjaminan','AdminController@cariDataPenjaminan');
Route::get('ubahdatapenjaminanadmin','AdminController@ubahdatapenjaminanadmin');
Route::get('ubahdata','AdminController@ubahdata');
Route::get('sudahsetujuall','AdminController@setujuAll');
Route::get('/sertifikatTerbit/{id}','AdminController@sertifikatTerbit');
Route::get('/sertifikatSign/{id}','AdminController@sertifikatSign');
Route::get('Cetaksertifikat','AdminController@sertifikatTerbitAll');
Route::get('CetaksertifikatSign','AdminController@sertifikatTerbitSign');

Route::get('CetaksertifikatSignCek','AdminController@sertifikatTerbitSignCek');
Route::post('carisertifikat','AdminController@carisertifikat');
Route::get('tolakan/{id}','AdminController@tolakan');
Route::get('ratecase', 'AdminController@ratecase');
Route::post('simpanvalidasi', 'AdminController@simpanvalidasi');
Route::get('ajaxdata/fetchdataValidasi', 'AdminController@fetchdataValidasi');
Route::get('ajaxdata/fetchdataValidasi/pengajuan', 'AdminController@fetchdataValidasiPengajuan');
Route::get('belumproses/ajaxdata/fetchdataValidasi/pengajuan', 'AdminController@fetchdataValidasiPengajuan');
Route::get('sudahsetuju/ajaxdata/fetchdataValidasi', 'AdminController@fetchdataValidasi');
Route::get('belumproses/ajaxdata/fetchdataValidasi', 'AdminController@fetchdataValidasi');
Route::get('belumprosescase/ajaxdata/fetchdataValidasi', 'AdminController@fetchdataValidasi');
Route::get('sudahprosescase/ajaxdata/fetchdataValidasi', 'AdminController@fetchdataValidasi');
Route::get('validasi/tambah', 'AdminController@postdataValidasi');
Route::post('validasi/tambah', 'AdminController@postdataValidasi');
Route::get('belumproses/validasi/tambah', 'AdminController@postdataValidasi');
Route::get('belumprosescase/validasi/tambah', 'AdminController@postdataValidasi');
Route::get('sudahprosescase/validasi/tambah', 'AdminController@postdataValidasi');
Route::get('belumprosescase/{id}', 'AdminController@CekPengajuanCase');
Route::get('/belumProsesAll','AdminController@CekPengajuanAll');
Route::get('/belumProsesUlang','AdminController@CekPengajuanulang');
Route::get('belumProsesCaseAll', 'AdminController@CekPengajuanCaseAll');
Route::get('sudahprosescase/{id}', 'AdminController@CekPengajuanCaseSudahBayar');
Route::get('sudahprosescaseall', 'AdminController@CekPengajuanCaseSudahBayarAll');
Route::get('cetakdaftarsertifikat/{id}',  'AdminController@cetakdaftarsertifikat'); 
Route::get('terbitkansertifikat/{id}',  'AdminController@terbitkansertifikat'); 
Route::get('terbitkansertifikat',  'AdminController@PostSertifikat'); 
Route::get('sudahsetuju/terbitkansertifikat',  'AdminController@PostSertifikat'); 
Route::post('postchangepassadm','AdminController@PostChangePass');
Route::get('/cetaksuratpengajuanadmin/{id}',  'AdminController@cetaksuratpengajuan'); 
Route::get('hapuspenjaminanadmin','AdminController@hapuspenjaminan');
Route::post('/simpandatabank', 'AdminController@simpandatabank');
Route::post('/simpanrate', 'AdminController@simpanrate');
Route::post('/detailrate/simpanrate', 'AdminController@simpanrate');
Route::get('/belumproseskompensasi', 'AdminController@CekPengajuanKompensasi');
Route::post('UpdatePenjaminanAdmin', 'AdminController@UpdatePenjaminan');
Route::post('prosespelunasan', 'AdminController@prosespelunasan');
Route::get('tampildataubah', function () {
    return view('admin.endorsment');
});
Route::get('changepassadm', function () {
    return view('admin.changepass');
});
Route::get('tampildataubah', function () {
    return view('admin.endorsment');
});
Route::get('testingmap', function () {
    return view('admin.testingMap');
});

//Route::get('/testsign', 'AdminController@testingsign');


//---->>>>  ROUTE UNTUK USER CONTROLLER

Route::get('cekkompensasi','userController@cekkompensasi');
Route::get('cekktp','userController@cekktp');
Route::get('cekpklama','userController@cekpklama');
Route::get('bandingkantgljthtempo','userController@cekjatuhtempo');
Route::get('cekinputpenjaminan','userController@cekinputpenjaminan');
Route::get('cekdokkesehatan','userController@cekdokkesehatan');
Route::get('ceknopk','userController@ceknopk');
Route::get('hapuspenjaminan','userController@hapuspenjaminan');
Route::get('sertifikatuser','userController@sertifikatTerbitAll');
Route::post('carisertifikatuser','userController@carisertifikat');
Route::get('ratebank', 'usercontroller@datarate');
Route::get('viewsertifikatcetak', 'userController@sertifikatcetak');
Route::get('cektgl_realisasi','userController@cekrealisasi');
Route::get('/CekJatuhTempoCase','userController@CekJatuhTempoCase');
Route::get('hitungtanggaljatuhtempo', 'userController@tanggaljatuhtempo');
Route::get('hitungumur', 'userController@hitungumur');
Route::post('PilihJenisPenjaminan', 'userController@PilihJenisPejaminan');

Route::get('hitungumurjatuhtempo', 'userController@hitungumurCase');
//Route::get('/caritable',  'userController@datatable2'); 
Route::post('postchangepass','userController@PostChangePass');
Route::get('testdatatable',  'userController@datatable'); 
Route::get('ajaxdata/fetchdata', 'userController@fetchdata');
Route::post('ajaxdata/tambah', 'userController@postdata');
Route::get('belumBayar', 'userController@BelumBayar');
Route::get('CaseSudahBayar', 'userController@CaseDapatBayar');
Route::get('setuju', 'userController@disetujui');
Route::get('tolak', 'userController@ditolak');
Route::get('Revisi', 'userController@Revisi');
Route::get('/bpr', 'userController@index');
Route::get('/penjaminanAdd', 'userController@AddPenjaminan');
Route::get('/inputcase', 'userController@AddCase');
Route::get('/inputGrace', 'userController@AddPenjaminanGrace');
Route::get('/inputpenjaminanperpanjangan', 'userController@inputpenjaminanperpanjangan');
Route::post('/simpanPenjaminanUser', 'userController@SimpanPenjaminan');
Route::post('UpdatePenjaminanUser', 'userController@UpdatePenjaminan');
Route::post('/caridata', 'userController@loadData');
Route::post('/CekMasaKredit', 'userController@CekMasaKredit');
Route::get('jeniskredit',  'userController@jeniskredit')  ; 
Route::get('importexport',  'userController@importExport')  ; 
Route::get('importexportadmin',  'AdminController@importExport')  ; 


Route::group(['prefix'=>'rekanan'],function(){
    
    Route::get('read','ReasuransiController@read');
    Route::get('/register','ReasuransiController@index');
    Route::post('/register','ReasuransiController@index');
    Route::get('reasuransi/{id}',  'ReasuransiController@edit')  ; 
    Route::get('reasuransi',  'ReasuransiController@reasuransi')  ; 
    Route::get('get-data-sertifikat',  'ReasuransiController@cekSertifikat')  ; 
    Route::post('insert-reasuransi',  'ReasuransiController@insert')  ; 
    Route::post('update-reasuransi',  'ReasuransiController@update')  ; 
    Route::post('save-reasuransi',  'ReasuransiController@multipleInsert')  ; 
    Route::post('save-reasuransi',  'ReasuransiController@multipleInsert')  ; 
    Route::post('filterexport', 'ReasuransiController@FilterExport');
    Route::post('/search', 'ReasuransiController@search');
    Route::get('/rekap', 'ReasuransiController@rekap');
    Route::get('/cetak-laporan-pdf/{id}/{dari}/{sampai}', 'ReasuransiController@cetakpdf');
    Route::post('/rekap', 'ReasuransiController@rekapData');
    Route::get('/register-detail/{id}/{dari}/{sampai}', 'ReasuransiController@FilterExport');
  
});


Route::post('importpenjaminan',  'userController@importExcel'); 
Route::post('importpenjaminanadmin',  'AdminController@importExcel'); 
Route::get('exportpenjaminan',  'userController@exportExcel');
Route::post('/filterPenjaminan',  'userController@filterPenjaminanBpr'); 
Route::get('/prosesbayar',  'userController@prosesBayar'); 
Route::post('/pembayaran',  'userController@AddPembayaran'); 
Route::post('/pembayaranautobelumProsesAll',  'userController@AddPembayaran'); 
Route::post('/pembayaranauto',  'userController@AddPembayaran'); 
Route::post('/pembayarancase',  'userController@AddPembayaranCase'); 
Route::get('/prosesbayarcase/{id}',  'userController@prosesBayarCase'); 
Route::get('/prosesbayarauto/{id}',  'userController@prosesbayarauto'); 
Route::get('/cetaksuratpengajuan/{id}',  'userController@cetaksuratpengajuan'); 
Route::get('/cetakpenjaminanpdf/{id}',  'userController@cetakLaporanPenjaminanPdf'); 
Route::get('/hitungumur/{id}',  'userController@cetakLaporanPenjaminanPdf'); 
Route::post('simpanPenjaminanCase',  'userController@simpanPenjaminanCase'); 
Route::get('cekplafon',  'userController@cekplafon'); 
Route::get('kirimdata',  'userController@kirimdata'); 
Route::post('KirimCase',  'userController@KirimCase'); 
Route::get('changepass', function () {
    return view('user.changepass');
});

Route::get('/updateapp', function()
{
     exec('composer dump-autoload');
    echo 'composer dump-autoload complete';
});

Route::get('/home', 'VerifyController@showDocument');
Route::get('/dokumenkredit', 'VerifyController@showDocumentKredit');
Route::get('revisi','AdminController@revisi');
Route::get('CetaksertifikatSignsb','AdminController@sertifikatTerbitSignsb');
Route::get('CetaksertifikatSignCekSb','AdminController@sertifikatTerbitSignsb');

Route::post('/cari-sertifikat-sign', 'DireksiController@CariSertifikatSign');
Route::post('/cari-sertifikat-signsb', 'DireksiController@CariSertifikatSignSB');
Route::post('/filter-sertifikat-by-date',  'userController@filterSertifikatByDate'); 

Route::get('/posisi-direksi','AdminController@PengajuanPadaDireksi');


Route::get('/hitung-akrual','AkrualController@hitungAkrual' );
Route::get('/detailPenjaminan/{id}','AdminController@detailPenjaminan' );
Route::post('/post/validasi','AdminController@postValidasi' );


//Route::get('/','AdminController@postValidasi' );
Route::post('/save-export-web','ExportController@SaveExportWeb');
Route::post('/filter-sertifikat-web', 'ExportController@FilterExportWeb');
Route::get('/sinkronisasi-perbank-web', 'ExportController@DataSinkronisasiWeb');



Route::get('/test','APIController@test' );
Route::get('/get-sertifikat-filter/{id}/{tgl1}/{tgl2}','ExportController@DataSinkronisasiFilterPerbank' ); 
Route::post('/post-sertifikat','APIController@postSertifikatWeb' );
Route::post('/find-sertifikat', 'APIController@findSertifikat'); 


    //route API pada website 03.9549.12.10.01.07.2021
Route::get('/get-sertifikat/{id}/{tgl1}/{tgl2}', 'APIController@dataSertifikatTerbitPerbank');
Route::get('/get-sertifikat/{tgl1}/{tgl2}', 'APIController@dataSertifikatTerbitAll');
Route::get('/get-sertifikat/{id}', 'APIController@sertifikatTerbitById');
Route::get('/get-sertifikat-group/{dariTgl}/{sampaiTgl}', 'APIController@groupSertifikatByBank');
Route::get('/update-status-sink/{id}', 'APIController@updateStatusSinkronisasi'); 
Route::post('/post/validasi/produktif','AdminController@postValidasiProduktif');
Route::post('/post/validasi/konsumtif','AdminController@postValidasiKonsumtif');
Route::get('/penjaminanProduktif', 'userController@formProduktif');
Route::get('/penjaminanKonsumtif', 'userController@formKonsumtif');
Route::post('/simpanPenjaminanProduktif', 'userController@SimpanPenjaminanProduktif');
Route::post('/simpanPenjaminanKonsumtif', 'userController@SimpanPenjaminanKonsumtif');
Route::post('ShowDetailPenjaminan', 'userController@ShowDetailPejaminan');
Route::post('showPersyaratan', 'userController@showPersyaratan');

Route::get('/posisi-kabag','AdminController@PengajuanPadaKabag');
Route::get('/detailPenjaminanBank/{id}','userController@detailPenjaminan');
Route::post('/pengajuan-ulang','userController@pengajuanUlang');
Route::post('/cek-kondisi-case', 'userController@cekKondisiCase');
Route::post('/hitung-laba-rugi', 'AdminController@hitungLabaBersih');
Route::post('/hitung-pendapatan-bersih', 'AdminController@hitungPendapatanBersih');
Route::get('/token', function (Request $request) {
    $token = $request->session()->token();
    $token = csrf_token();
    // ...
});
Route::get('/showToken', 'APIController@showToken'); 

Route::post('/proses-sign', 'APIController@prosesSignKreditById'); 
Route::post('/proses-sign-sb', 'APIController@signsbById'); 
Route::post('/test-curl', 'APIController@TestcUrl'); 
Route::get('/show-sertifikat-sb', 'APIController@showSertifikatSb'); 
Route::get('/autoSinkSb', 'APIController@autoSinkronisasiDataSb'); 
Route::get('/update-status-sink-sb/{id}', 'APIController@updateStatusSb'); 
Route::get('/send-message', 'APIController@sendMessageTelegramBot'); 
Route::get('/auto-sink-kredit', 'APIController@autoSinkronisasiData'); 