 
 $('#cekall').click(function () {
//     alert('pilih semua ?');
       $(this).parents('#centang:eq(0)').
            find(':checkbox').attr('checked', this.checked); 
 })
 
 //FUNGSI UNTUK MENECEK TANGGAL REALISASI
function CekJatuhTempoCase()
{
             var MasaKredit = $('#masakredit').val();
             var TglRealisasi = $('#tglrealisasicase').val();
       
        $.ajax({
        url         :'/CekJatuhTempoCase',
        method      : 'get',
        data        : 'tgl_realisasi=' + TglRealisasi+
                      '&masakredit=' + MasaKredit,
        dataType    : 'json',
        success: function (data) 
        { 
            $('.TglJatuhTempo').val(data.jatuhtempo);
        }
      })
  };
  
 //FUNGSI UNTUK MENECEK TANGGAL REALISASI
  $('#tglrealisasi').change(function(){
         
         
        var tglrealisasi = $('#tglrealisasi').val();
       
        $.ajax({
        url         :'/cektgl_realisasi',
        method      : 'get',
        data        : 'tgl_realisasi=' + tglrealisasi,
        dataType    : 'json',
        success: function (data) 
        { 
            if(data.lebih==true)
            {
                $('#msg_lebih').html('<b style="color:red">Tanggal realisasi tidak boleh lebih besar dari hari ini !!!</b>');
                $('#masaKredit').attr('disabled',true); 
            }
            else
            {
                 $('#msg_lebih').html('');
                 $('#masaKredit').attr('false',true);  
            }
            
            if (data.selisih>25) 
            {
                $('#msg_realisasi').html('<b style="color:red">Pengajuan anda lewat <a style="color:black">'+data.selisih+' Hari </a> Sejak tanggal Realisasi, Silahkan hubungi staff PT. Jamkrida NTB untuk informasi lebih lanjut !!!</b>');
                 
                if (data.selisih>25) {
                   $('#masaKredit').attr('disabled',true);   
                }else{
                   $('#masaKredit').attr('false',true);  
                }
            }
            else
            {
            }
               $('#msg_realisasi').html('');
        }
      });
      
    });

//FUNGSI UNTUK MENGHITUNG TANGGAL JATUH TEMPO UNTUK PENGAJUAN ULANG
$(document).on('keyup', '#masaKredit12', function (){
    
    var masakredit=$('#masaKredit12').val();
    var realisasi=$('#tglrealisasi1').val();
    $.ajax({
        url     : "hitungtanggaljatuhtempo",
        method  : 'get',
        data    : 
                'masakredit=' + masakredit+
                '&realisasi=' + realisasi,
        dataType: 'json',
        success : function (data) {
                $("#tgljatuhtempo1").val(data.jatuhtempo);
                $("#tgljatuhtempo12").val(data.jatuhtempo);
                $('#plafon12').val('');
        }
    })
});

//FUNGSI UNTUK MENGHITUNG UMUR
$(document).on('change', '#tglLahir', function (){
    
    
});

//FUNGSI UNTUK MENGHITUNG RATE UNTUK PENGAJUAN ULANG
$('#plafon12').change(function () {
     
        $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             }); 
            const bulan= $("#masaKredit12").val();
            const plafon= $("#plafon12").val();
            const jeniskredit=$("#jeniskredit1").val();
            const idbank= $("#idbank1").val();
            $.ajax({
            type    : "POST",
            url       :'PilihJenisPenjaminan', 
            data: 
                    {
                        'bulan': bulan ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'html',
            success: function (data) 
            {
                $("#JenisPnj1").remove();
                $("#Jenispilihan1").html(data);
            }
        })
    });

//FUNGSI UNTUK MENGUBAH JENIS KREDIT DI MENU EXPORT FILE EXCEL
$(document).on('change', '#jenisKredit', function () {
    var jeniskredit=$('#jenisKredit').val();
    $.ajax({
        url: "jeniskredit",
        method: 'get',
        data: 'jeniskredit=' + jeniskredit,
        dataType: 'html',
        success: function (data) {
            
            $("#jenispenjaminan").empty();
            $("#jenispenjaminan").html(data);

        }
    })
});
//FUNGSI UNTUK MENGHITUNG TANGGAL JATUH TEMPO
$(document).on('keyup', '#masaKredit', function () {
    var masakredit=$('#masaKredit').val();
    var realisasi=$('#tglrealisasi').val();
    $.ajax({
        url: "hitungtanggaljatuhtempo",
        method: 'get',
        data: 'masakredit=' + masakredit+
         '&realisasi=' + realisasi,
        dataType: 'json',
        success: function (data) {
            $("#tgljatuhtempo1").val(data.jatuhtempo);
            $("#tgljatuhtempo").val(data.jatuhtempo);
            
        }
    })
});



//FUNGSI UNTUK MENYIMPAN LOG CETAK
$(document).on('click', '.logcetaksertifikat', function () {
    var id = $(this).attr("id");
    var analisa;
    
    $.ajax({
        method: 'get',
        data: 'id=' + id,
        url: "simpanlogcetak",
        dataType: 'json',
        success: function (data) {

        }
    });
});

$(document).on('change', '#tgljatuhtempo', function () {
    var jatuhtempo=$('#tgljatuhtempo').val();
    var realisasi=$('#tglrealisasi').val();
    $.ajax({
        url: "bandingkantgljthtempo",
        method: 'get',
        data: 'jatuhtempo=' + jatuhtempo+
         '&realisasi=' + realisasi,
        dataType: 'json',
        success: function (data) {
          
           
           if(data.hasil=='1'){
               $('#errorjatuhtempo').html('<p style="color:red;"><b>Tanggal jatuh tempo tidak boleh lebih kecil atau sama dengan tanggal realisasi</b><p>')
               $('#plafon').prop('disabled',true);
              
               
            }else{
               $('#errorjatuhtempo').html('');
               $('#plafon').prop('disabled',false);
           }

        }
    })
});

function selectData(data){
                  $('#phone').val(data.phone);
                  $('#name').val(data.namaterjamin);
                    $('#tglLahir').css("background-color", "#FFEBCD").val(data.tgllahir);
                    $('#tempatlahir').val(data.tempatlahir);
                    $('#alamat').val(data.alamat);
                    $('#desa').val(data.desa);
                    $('#kecamatan').val(data.kecamatan);
                    $('#kabupaten').val(data.kabupaten);
                    $('#pekerjaan').val(data.pekerjaan);
                    $('#tampil').val(data.umur);
                    $('#tampil1').val(data.umur);
                    $('#jeniskredit').val(data.jeniskredit);
                   // $('#tglpk').val(data.tglpk);
                    $('#tglrealisasi').prop('disabled', false);
//                    $('#tglrealisasi').val(data.tglrealisasi);
                //    $('#tgljatuhtempo').prop('disabled', false);
//                    $('#tgljatuhtempo').val(data.tgljatuhtempo);
                   // $('#masaKredit').val(data.masakredit);
                 //   $('#masaKredit1').val(data.masakredit);
                   // $('#umurjatuhtempo').val(data.umurjatuhtempo);
                   // $('#umurjatuhtempo1').val(data.umurjatuhtempo);
                   // $('#plafon').val(data.plafon);
}

$(document).on('change', '#ktp', function () 
{
    
    var noktp           = $('#ktp').val();
    var kodepusat       = $('#kodepusat').val();
    var idbank          = $('#idbank').val();
    var jenispengajuan  = $('#jenispengajuan').val();
    var caseket         = $('#caseket').val();
    
    if (noktp.length < 16)
    {
        alert('Nomor KTP tidak boleh kurang dari 16 karakter !!!');
        $('#ktp').focus();
        $('#simpan').prop('disabled', true);
    }
    else
    {
         $('#simpan').prop('disabled', false);
    }
    
    $.ajax({
        url: "cekktp",
        method: 'get',
        data:'noktp='+noktp+
            '&idbank='+idbank+
            '&kodepusat='+kodepusat,
        dataType: 'json',
        success: function (data) 
        {
              console.dir(data);
//             alert(data.kodepusat);
//             var Pesan='Nomor KTP yang dimasukkan sudah terdaftar sebelumnya dengan nomor sertifikat: ' + data.kodesertifikat
//                            + ' dan berlaku sampai : '+data.tgljatuhtempo+' status pertanggungan masih '+data.status+' di : '+data.namabank;
//            
            var Pesan = 'Nomor KTP yang dimasukkan sudah terdaftar sebelumnya dengan perincian data sebagai berikut:'; ;
            var hari = new Date().getDate();
            var bulan = new Date().getMonth();
            var tahun = new Date().getFullYear();
            var bln = bulan + 1;
            var tanggal = hari + "-" + bln + "-" + tahun;
            
            
           var hariIni = new Date();
           var pembanding= new Date();
          
           
            if (jenispengajuan == 'baru') 
            {   
                if (data.ktp == noktp)
                {
                    if(data.status=='Aktif')
                    {
                        console.dir(data);
                        var i = data.penjaminan.length;
                        var nomorsertifikat,status;
                        var tampungan=[];
                        while (i > 0)
                        {
                            var str = data.penjaminan[i - 1]['tgljatuhtempo'];
                            var tanggal = str.split("-");
                            var tahun = tanggal[0];
                            var bulan = tanggal[1];
                            var hari = tanggal[2];
                            status = data.penjaminan[i - 1]['app'];
                            pembanding.setFullYear(tahun, bulan, hari);
                            nomorsertifikat = data.penjaminan[i - 1]['kodesertifikat'];
                            if (nomorsertifikat == null)
                            {
                                nomorsertifikat = "Belum Terbit";
                                var btn = "Tidak tersedia";
                                if(status=='Pengecekan'||status=='Revisi'){
                                    
                                     $('#btnDoubleFasilitas').attr('disabled',true);
                                     $('#msgConfirmastion').html('<p style="color:red;"><b>Tidak dapat melakukan pengajuan Masih Ada Pengajuan yang berstatus Pengecekan Atau Revisi</b><p>');
                                     $('#plafon').prop('disabled', true);
                                     $('#simpan').prop('disabled', true);
                                }

                            } else
                            {
                                if (pembanding > hariIni)
                                {
                                    var btn = "<button id=" + data.penjaminan[i - 1]['kodesertifikat'] + " class='btn btn-success pilihKompensasi'>Kompensasi</button>";
                                } else
                                {
                                    var btn = "Pengajuan Baru";
                                }
                            }

                            tampungan.push("\
                            <tr>\
                                <td>" + nomorsertifikat + "</td>\n\
                                <td>" + data.penjaminan[i - 1]['nama'] + "</td>\n\
                                <td>" + formatNumber(data.penjaminan[i - 1]['plafon']) + "</td> \n\
                                <td>" + data.penjaminan[i - 1]['tgljatuhtempo'] + "</td>\n\
                                <td>" + btn + "</td>\n\
                            </tr>");
                            i--;
                        }
                       $('#datapenjaminan').html(tampungan);
                       $('#Pesan').html(Pesan);
                       $('#modalKonfirmasi').modal('show'); 
                     
                     if(data.fasilitas==1)
                     { 
                       $('#btnDoubleFasilitas').hide();
                       $('.pilihKompensasi').click(function () {
                           var nosertifikat = $(this).attr("id");
                           
                                $.ajax({
                                    url: "cekktp",
                                    method: 'get',
                                    data:   'noktp=' + noktp +
                                            '&nosertifikat=' + nosertifikat +
                                            '&idbank=' + idbank +
                                            '&kodepusat=' + kodepusat,
                                    dataType: 'json',
                                    success: function (data)
                                    {
                                        $('#jenispengajuan').val('kompensasi');
                                        selectData(data);
                                        $('#nosertifikat').val(data.kodesertifikat);
                                        $('#nosertifikat1').val(data.kodesertifikat);
                                        $('#pklamaHide').val(data.nopk);
                                        $('#pklamaShow').val(data.nopk);
                                        $('#SertifikatLama').attr('hidden',false);
                                        $('#PKLama').attr('hidden',false);
                                        $('#labelNoPK').html('No. Adendum Perjanjian Kredit');
                                        $('#labelTglPK').html('Tanggal Adendum Perjanjian Kredit');
                                        $('#DetailAlamat').remove();
                                        $('#modalKonfirmasi').modal('hide'); 
                                    }});
                       });
                     }  
                     if(data.fasilitas>1)
                     {
                            $('#btnDoubleFasilitas').click(function ()
                            {
                                $('#jenispengajuan').val('double');
                                selectData(data);
                                $('#SertifikatLama').remove();
                                $('#PKLama').remove();
                                $('#labelNoPK').html('No. Perjanjian Kredit');
                                $('#labelTglPK').html('Tanggal Perjanjian Kredit');
                                $('#DetailAlamat').remove();

                            });
                            
                             $('.pilihKompensasi').click(function () {
                                var nosertifikat = $(this).attr("id");

                                $.ajax({
                                    url: "cekktp",
                                    method: 'get',
                                    data: 'noktp=' + noktp +
                                            '&nosertifikat=' + nosertifikat +
                                            '&idbank=' + idbank +
                                            '&kodepusat=' + kodepusat,
                                    dataType: 'json',
                                    success: function (data)
                                    {
                                        $('#jenispengajuan').val('kompensasi');
                                        selectData(data);
                                        $('#nosertifikat').val(data.kodesertifikat);
                                        $('#nosertifikat1').val(data.kodesertifikat);
                                        $('#pklamaHide').val(data.nopk);
                                        $('#pklamaShow').val(data.nopk);
                                        $('#SertifikatLama').attr('hidden', false);
                                        $('#PKLama').attr('hidden', false);
                                        $('#labelNoPK').html('No. Adendum Perjanjian Kredit');
                                        $('#labelTglPK').html('Tanggal Adendum Perjanjian Kredit');
                                        $('#DetailAlamat').remove();
                                        $('#modalKonfirmasi').modal('hide');
                                    }});
                            });
                       }
                    }
                    else if(data.app=='Lunas')
                    {
                        alert('Nomor KTP yang dimasukkan sudah terdaftar sebelumnya dengan nomor sertifikat: ' + data.kodesertifikat
                            + ' dan berlaku sampai : '+data.tgljatuhtempo+' status kredit sudah Lunas  di : '+data.namabank);
                            selectData(data);
                            $('#plafon').prop('disabled', false);
                            $('#simpan').prop('disabled', false);
                             
                    }
                    else if(data.app=='Tolak' && data.case=='Ya')
                    {                        
                         alert('Pengajuan tidak dapat di proses, Data sudah ada sebelumnya dengan status CASE BY CASE dan di TOLAK oleh PT jamkrida NTB Bersaing, silahkan hubungi Bagian Penjaminan PT Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                   
                    }
                    else if (data.app=='Tolak')
                    {
                         alert('KTP sudah terdaftar dan sudah ditolak oleh  PT. Jamkrida NTB, silahkan konfirmasi Bagian Penjamian PT Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else if (data.app=='Ulang')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ulang Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else if (data.app=='Pengecekan')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else if (data.app=='Revisi')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else
                    {
                         $('#plafon').prop('disabled', false);
                         $('#simpan').prop('disabled', false);
                    } 
                } 
                else 
                {
                    $('#plafon').prop('disabled', false);
                    $('#simpan').prop('disabled', false);
                }
            }
            else
            {
                if (data.ktp == noktp)
                {
                    if(data.status=='Aktif'&&data.app=='Cetak')
                    {
                        alert(Pesan);
                        $('#simpan').prop('disabled', true);
                        $('.btnUpdateBank').prop('disabled', true);
                    }
                     else if (data.status=='Aktif' && data.app!='Tolak')
                    {
                         alert('Nomor KTP yang dimasukkan sudah terdaftar sebelumnya dengan status tolak, Silahkan cek catatan pada tolkan !!');
                         $('#simpan').prop('disabled', true);
                         $('.btnUpdateBank').prop('disabled', true);
                    }
                      else if (data.app=='Tolak')
                    {
                         alert('KTP sudah terdaftar dan sudah ditolak oleh  PT. Jamkrida NTB, silahkan konfirmasi Bagian Penjamian PT Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else if (data.app=='Ulang')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ulang Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                     else if (data.app=='Pengecekan')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true);
                         
                    }
                    else if (data.app=='Revisi')
                    {
                         alert('KTP sudah terdaftar dan masih dalam proses Pengajuan Ke PT. Jamkrida NTB');
                         $('#plafon').prop('disabled', true);
                         $('#simpan').prop('disabled', true); 
                    }
                     else if(data.status=='Expired')
                    {
                         alert('Nomor KTP yang dimasukkan sudah terdaftar sebelumnya dan sudah berakhir pada tanggal : '+data.tgljatuhtempo+' anda akan diarahkan ke penginputan penjaminan baru');
                         window.location.href = "penjaminanAdd";
                    
                    } 
                     selectData(data);

                } 
                else 
                { 
                    var proses=$('#proses').val(); 
                    if (proses!='update')
                    {
                       alert('Nomor KTP yang dimasukkan belum terdaftar sebelumnya, anda akan diarahkan untuk mengisi pengajuan baru');
                       window.location.href = "penjaminanAdd";   
                    }
                       
                    
                }
            }
           

        }
    })
});

$(document).on('change', '#pklama', function () 
{
    var nopk = $('#pklama').val();
    var idbank = $('#idbank').val();
    if (nopk.length < 5)
    {
         alert('Nomor PK Lama tidak boleh kurang dari 5 karakter');
         $('#plafon').prop('disabled',true);
    }
    else
    {
         $('#plafon').prop('disabled',false);
    }
    $.ajax({
        url: "cekpklama",
        method: 'get',
        data: 'nopk=' + nopk+
              '&idbank=' + idbank,
        dataType: 'json',
        success: function (data) {
            
            
                if (data.nopk == nopk)
                {
                    if(data.status=='Aktif'&&data.app=='Cetak'){
                        alert('Nomor PK yang dimasukkan sudah terdaftar sebelumnya dengan nomor sertifikat ' + data.kodesertifikat
                        + ' dan berlaku sampai : '+data.tgljatuhtempo+' status pertanggungan masih '+data.status+' anda akan melakukan kompensasi pengajuan');
                    }else if(data.status=='Aktif'){
                         alert('Nomor PK yang dimasukkan sudah terdaftar sebelumnya, dan masih dalam proses pengajuan ke PT. Jamkrida NTB');
                         $('#simpan').prop('disabled', true);
                    }else if(data.status=='Expired'){
                         alert('Nomor PK yang dimasukkan sudah terdaftar sebelumnya dan sudah berakhir pada tanggal : '+data.tgljatuhtempo+' anda akan diarahkan ke penginputan penjaminan baru');
                         window.location.href = "penjaminanAdd";
                    
                    }
                    $('#ktp').val(data.ktp);
                    $('#name').val(data.namaterjamin);
                    $('#tglLahir').css("background-color", "#FFEBCD").val(data.tgllahir);
                    $('#tempatlahir').val(data.tempatlahir);
                    $('#alamat').val(data.alamat);
                    $('#desa').val(data.desa);
                    $('#kecamatan').val(data.kecamatan);
                    $('#kabupaten').val(data.kabupaten);
                    $('#pekerjaan').val(data.pekerjaan);
                    $('#tampil').val(data.umur);
                    $('#tampil1').val(data.umur);
                    $('#jeniskredit').val(data.jeniskredit);
                    $('#nosertifikat').val(data.kodesertifikat);
                    $('#nosertifikat1').val(data.kodesertifikat);
                    
                   // $('#tglpk').val(data.tglpk);
                    $('#tglrealisasi').prop('disabled', false);
//                    $('#tglrealisasi').val(data.tglrealisasi);
//                    $('#tgljatuhtempo').prop('disabled', false);
//                    $('#tgljatuhtempo').val(data.tgljatuhtempo);
                   // $('#masaKredit').val(data.masakredit);
                 //   $('#masaKredit1').val(data.masakredit);
                   // $('#umurjatuhtempo').val(data.umurjatuhtempo);
                   // $('#umurjatuhtempo1').val(data.umurjatuhtempo);
                   // $('#plafon').val(data.plafon);

                } else {
                         alert('Nomor PK yang dimasukkan belum terdaftar sebelumnya, anda akan diarahkan untuk mengisi pengajuan baru');
                         window.location.href = "penjaminanAdd";
                    
                }

        }
    })
});

$(document).on('change', '#nopk', function () 
{
    var nopk = $('#nopk').val();
    var idbank = $('#idbank').val();
    var jenis= $('#jenispengajuan').val();
    if (nopk.length < 5)
    {
        
        if(jenis=='baru')
        {
            alert('Nomor PK tidak boleh kurang dari 5 karakter');
        return false;
        }
        else
        {
            alert('Nomor Adendum PK tidak boleh kurang dari 5 karakter');
        return false;
        }
        
    }
    $.ajax({
        url: "ceknopk",
        method: 'get',
        data: 'nopk=' + nopk+
              '&idbank=' + idbank,
        dataType: 'json',
        success: function (data) {
            if (data.nopk>0) 
            {
                alert('Nomor PK sudah terdaftar sebelumnya!!! silahkan periksa kembali NO PK yang anda masukkan !!');
                 $("#simpan").prop('disabled', true);
                
            }else{
                  $("#simpan").prop('disabled', false);
            }

        }
    })
});

$(document).on('change', '#totaltf', function () 
{
    var total = $('#totalbayar').val();
    var totaltf = $('#totaltf').val();
    if(totaltf!=total){
        alert('Total transfer harus sama dengan total bayar !!!');
        $('#totaltf').val('');
    }
    
});

$(document).on('change', '#ratecase', function () 
{
    var ratecase = $('#ratecase').val();
    var idpenjaminan = $('#idpenjaminan').val();

    $.ajax({
        url: "ratecase",
        method: 'get',
        data: 'ratecase=' + ratecase +
              '&idpenjaminan=' + idpenjaminan,
        dataType: 'json',
        success: function (data) {

            $('#ijp').val(data.ijp);
            $('#ijp1').val(data.ijp);
            $('#potongan').val(data.potongan);
            $('#potongan1').val(data.potongan);
            $('#premi').val(data.nett);
            $('#premi1').val(data.nett);
        }
    })
});

$(document).on('click', '.ubahrate', function () 
{
    var idrate = $(this).attr("id");

    $.ajax({

        url: "ubahrate",
        method: 'get',
        data: 'idrate=' + idrate,
        dataType: 'json',
        success: function (data) {
           
            $("#hidden_id").val(idrate);
            $("#idbank").val(data.idbank);
            $("#idproduk").val(data.idproduk);
            $("#namarate").val(data.namaproduk);
            $("#dari").val(data.dari);
            $("#sampai").val(data.sampai);
            $("#jenispenjaminan").val(data.jenispenjaminan);
            $("#rate").val(data.rate);
            $("#submit").val('Ubah');
            $(".modal-title").text('UBAH RATE');
            $("#modalRate").modal('show');


        }
    })
}); 
$(document).on('click', '.uploadDocSk', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Dokumen SK Pengangkatan| PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalSkPengangkatan').modal('show');
            $('.modal-title').text('Upload Dokumen SK Pengangkatan' );
            $('.btn_upload').val('Upload');
        }
    })
});
$(document).on('click', '.uploadRiwayatKredit', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Dokumen Riwayat Kredit| PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalRiwayatKredit').modal('show');
            $('.modal-title').text('Upload Dokumen Riwayat Kredit' );
            $('.btn_upload').val('Upload');
        }
    })
});
$(document).on('click', '.uploadGetaranJantung', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Dokumen Getaran Jantung| PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalGetaranJantung').modal('show');
            $('.modal-title').text('Upload Dokumen Getaran Jantung' );
            $('.btn_upload').val('Upload');
        }
    })
}); 
$(document).on('click', '.uploadPersetujuanKredit', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Dokumen Persetujuan Kredit| PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalPersetujuanKredit').modal('show');
            $('.modal-title').text('Upload Dokumen Persetujuan Kredit' );
            $('.btn_upload').val('Upload');
        }
    })
}); 
$(document).on('click', '.uploadTaksasi', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih File Hasil Taksasi Agunan | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalTaksasi').modal('show');
            $('.modal-title').text('Upload File Taksasi' );
            $('.btn_upload').val('Upload');
        }
    })
}); 
$(document).on('click', '.uploadAnalisis', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih File Analisis | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalAnalisis').modal('show');
            $('.modal-title').text('Upload File Analisis' );
            $('.btn_upload').val('Upload');
        }
    })
}); 

$(document).on('click', '.uploadFotoUsaha', function () 
{
    var id = $(this).attr("id"); 
    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Foto Usaha | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalUsaha').modal('show');
            $('.modal-title').text('Upload Foto Usaha  ' );
            $('.btn_upload').val('Upload');
        }
    })
});


$(document).on('click', '.uploadHasilSlik', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih Foto SLIK | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalSlik').modal('show');
            $('.modal-title').text('Upload SLIK ' );
            $('.btn_upload').val('Upload');
        }
    })
});

$(document).on('click', '.uploadktp', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih File KTP Terjamin + Pasangan | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalUploadktp').modal('show');
            $('.modal-title').text('Upload KTP  ' );
            $('.btn_upload').val('Upload');
        }
    })
});


$(document).on('click', '.uploadsuratsehat', function () 
{
    var id = $(this).attr("id");

    //$('#formUpload')[0].reset();
//    $("#formUpload").prop('action','ajaxdata/tambah');
    $.ajax({
        url     : "/ajaxdata/fetchdata",
        method  : 'get',
        data    : 'id= ' + id,
        dataType: 'json',
        success : function (data)
        {
            $('.titleupload').html('Pilih File Surat Keterangan Sehat | PDF  |JPG');
            $('input[name=namaterjamin]').val(data.nama);
            $('.sertifikat').val(data.nosertifikat);
            $('#modalUploadSuratSehat').modal('show');
            $('.modal-title').text('Upload Surat Sehat ' );
            $('#btn_upload_surat_sehat').val('UploadSuratSehat');
        }
    })
});


$(document).on('click', '.uploadsuratsehatRs', function () 
{
    var id = $(this).attr("id");
    $('#formUploadRs')[0].reset();
    $("#formUploadRs").prop('action', 'ajaxdata/tambah');
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {
            $('#titleuploadRs').html('Pilih File Surat Sehat Dari RS | PDF  |JPG');
            $('#namaterjaminRs').val(data.nama);
            $('#sertifikatRs').val(data.nosertifikat);
            $('#modalUploadRs').modal('show');
            $('.modal-title').text('Upload Surat Sehat RS');
            $('#button_actionRs').val('Upload');
        }
    })
});


$(document).on('click', '.uploadbuktibayar', function () 
{
    var totalbayar;
    var id = $(this).attr("id");
    //$('#formUpload')[0].reset();
    $("#formUpload").prop('action', 'ajaxdata/tambah');
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {
            totalbayar = data.nett + data.admin + data.materai;
            $('#titleupload').html('Pilih File Bukti Bayar | PDF  |JPG');
            $('#nett').val(data.nett);
            $('#nett1').val(data.nett);
            $('#sertifikatbayar').val(data.nosertifikat);
            $('#kodebayar').val(data.kodebayar);
            $('#kodebayar1').val(data.kodebayar);
            $('#namaterjaminbayar').val(data.nama);
            $('#admin').val(data.admin);
            $('#admin1').val(data.admin);
            $('#materai').val(data.materai);
            $('#materai1').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#totalbayar_adm').val(data.totalbayar);
            $('#totalbayar1').val(data.totalbayar);
            $('#idpenjaminanBayar').val(data.id);
            $('#penjaminanid').val(data.idpenjaminan);
            $('#modalUploadPembayaran').modal('show');
            $('.modal-title').text('Upload Bukti Bayar');
            $('#button_actionBayar').val('Upload Ulang Bukti Bayar');
        }
    })
});

$(document).on('click', '.deletepenjaminan', function () 
{
 var id = $(this).attr("id"); 
  if(confirm('Apakah anda yakin untuk menghapus data ini??')){
    $.ajax({
        url: "hapuspenjaminan",
        method: 'get',
        data: 'id=' + id,
        dataType: 'json',
        success: function (data)
        {
           alert(data);
           window.location.reload();
        }
    })
  }  
});

$(document).on('click', '.admindeletepenjaminan', function () 
{
  var id = $(this).attr("id"); 
  if(confirm('Apakah anda yakin untuk menghapus data ini??'+id)){
    $.ajax({
        url                : "/hapuspenjaminanadmin",
        method      : 'get',
        data             : 'id=' + id,
        dataType  : 'json',
        success: function (data)
        {
           alert(data);
           window.location.reload();
        }
    })
  }  
});

$(document).on('click', '.terbitkansertifikat', function () 
{
    var id = $(this).attr("id");
    //$('#formUpload')[0].reset();
    $("#formUpload").prop('action', 'ajaxdata/tambah');
    $.ajax({
        url                  : "/ajaxdata/fetchdataValidasi",
        method        : 'get',
        data               : 'id='+id,
        dataType    : 'json',
        success: function (data)
        {

            $('#registrasi').val(data.nosertifikat);
            $('#sertifikat').val(data.kodesertifikat);
            $('#namabank').val(data.namabank);
            $('#ktp').val(data.ktp);
            $('#nama').val(data.nama);
            $('#umur').val(data.umurjatuhtempo);
            $('#pekerjaan').val(data.pekerjaan);
            $('#idpenjaminan').val(id);
            $('#jeniskredit').val(data.jeniskredit);
            $('#tgllahir').val(data.tgllahir);
            $('#jenispenjaminan').val(data.jenispenjaminan);
            $('#nopk').val(data.nopk);
            $('#rate').val(data.rate);
            $('#ijp').val(data.ijp);
            $('#admin').val(data.admin);
            $('#materai').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#masakredit').val(data.masakredit);
            $('#potongan').val(data.potongan);
            $('#periode').val(data.periode);
            $('#plafon').val(data.plafon);
            $('#premi').val(data.nett);
            $('#ceklab').attr("href", "/files/scanlab/" + data.ceklab);
            $('#kesehatan').attr("href", "/files/suratsehat/" + data.kesehatan);
            $('#pembayaran').attr("href", "/files/buktibayar/" + data.pembayaran); 
            $('#modalsertifikat').modal('show');
            
            document.onkeypress = enter;
            function enter(e) {
                if (e.which == 13) {
                  $('#btn-terbitkan').submit();
                }
            }
            
        }
    })
});

$('#sertifikat_form').on('submit', function (event) 
{
    $('#btn-terbitkan').attr('disabled',true);
    $('#customLoad').show();
    var id = $('#idpenjaminan').val();
    var sertifikat = $('#sertifikat').val();
    var registrasi = $('#registrasi').val();

    $.ajax({

        url: "terbitkansertifikat",
        method: 'get',
        //data: 'jenis=' + jenis + '&periode=' + periode,
        data: 'id=' + id + 
              '&sertifikat=' + sertifikat+
              '&registrasi=' + registrasi,
        dataType: "json",
        success: function (data)
        {

            if (data.error.length > 0)
            {
                var error_html = '';
                for (var count = 0; count < data.error.length; count++)
                {
                    error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                }
                $('#form_output').html(error_html);
            } 
            else
            {
               
               $('#form_output').html(data.success);
                $('#sertifikat_form')[0].reset();
                setTimeout(function () 
                {
                    $('#sertifikatmodal').modal('hide');
                }, 2000);
                alert('Sertifikat berhasil diterbitkan');
                window.location.href = "sudahsetujuall";
            }
        }
    })
});







$('.admineditpenjaminan').on('click', function (event) {
   
    var data = $(this).attr("id");
    var jenis = $('#jenis').val();
    var penjaminan;
     $('#formPenjaminanUpdate')[0].reset();
    $.ajax({
        method: 'get',
        data: 'data=' + data ,
        url: "ubahdatapenjaminanadmin",
        dataType: 'json',
        success: function (data)
        { 
            var hari = new  Date().getDate();;
            var bulan = new Date().getMonth();
            var tahun = new Date().getFullYear();;
            var bln =  bulan+1;
            var tanggal = hari+"-"+bln+"-"+tahun;
            
//            var tanggal = new Date(); 
            if((data.case=='Ya') && (data.statusbayar='0') )
            {
              $('#nopk').attr('required',false);  
              $('#tglrealisasi').attr('disabled',true);  
              $('#tglrealisasi').val(tanggal);  
              $('#tgljatuhtempo').attr('disabled',true);  
              $('#tgljatuhtempo').val(tanggal);  
              $('#nopk').attr('disabled',true);  
              $('#tglpk').attr('disabled',true);  
//              $('#tglpk').val(new Date().getdate());  
            }else{
                  $('#tglrealisasi').val(data.tglrealisasi);
                  $('#tgljatuhtempo').val(data.tgljatuhtempo);
                  $('#tglrealisasi').attr('disabled',false);  
                  $('#tglpk').attr('disabled',false);  
            }
      
            penjaminan = data.jenispenjaminan;
       
            $('#phone').val(data.phone);
            $('#idbank').val(data.idbank);
            $('#kodepusat').val(data.kodepusat);
            $('#statusbayar').val(data.statusbayar);
            $('#caseket').val(data.case);
            $('#siup').val(data.siup);
            $('#npwp').val(data.npwp);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#ktp').val(data.ktp);
            $('#ktplama').val(data.ktp);
            $('#name').val(data.nama);
            $('#tglLahir').val(data.tgllahir);
            $('#tempatlahir').val(data.tempatlahir);
            $('#tampil1').val(data.umur);
            $('#tampil').val(data.umur);
            $('#kodepenjaminan').val(data.nosertifikat);
            $('#kodepenjaminan1').val(data.nosertifikat);
           $('#penggunaan').val(data.penggunaan);  
//           $('#pekerjaan').val(data.pekerjaan);  
           if (data.jenis_pekerjaan=='KARYAWAN'){
                  $('#radio-karyawan').attr('checked',true)
           }
           if (data.jenis_pekerjaan=='PENGUSAHA'){
                  $('#radio-pengusaha').attr('checked',true)
           }  
            $('#detail_Pekerjaan').val(data.pekerjaan);   
            
            if (data.jeniskredit=='PRODUKTIF'){
                  $('#radio-produktif').attr('checked',true)
           } 
           if (data.jeniskredit=='KONSUMTIF'){
                  $('#radio-konsumtif').attr('checked',true)
           } 
            $('#jeniskredit').val(data.jeniskredit); 
            $('#alamat').val(data.alamat);
            $('#masaKredit1').val(data.masakredit);
            $('#masaKredit').val(data.masakredit);
            $('#umurjatuhtempo1').val(data.umurjatuhtempo);
            $('#umurjatuhtempo').val(data.umurjatuhtempo);
            $('#nopk').val(data.nopk);
            $('#tglpk').val(data.tglpk);
            $('#plafon').val(data.plafon);
            $('#tglpengajuan').val(data.tglpengajuan);
            $('#tglpengajuan1').val(data.tglpengajuan);
            $('#modalEditPenjaminan').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('DETAIL DATA PENJAMINAN');
            $('#button_action').val('update');
            $('#jenis_penjaminan').val(data.jenispenjaminan1);

            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             }); 
            const masakredit= data.masakredit ;
            const plafon= data.plafon ;
            const jeniskredit= data.jeniskredit ;
            const idbank= data.idbank;
            $.ajax({
            type    : "POST",
            url       :'PilihJenisPenjaminan', 
            data: 
                    {
                        'bulan': masakredit ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'html',
            success: function (data) 
            {
                    $("#Jenispilihan").html(data);
                    $('#jenisPenjaminan').val(penjaminan);

                }
            });
        }
    })

});

$('.tombolpelunasan').on('click', function (event) {
    var data = $(this).attr("id");
    var jenis = $('#jenis').val();
    var penjaminan;
     $('#formPenjaminanUpdate')[0].reset();
    $.ajax({
        method: 'get',
        data: 'data=' + data ,
        url: "ubahdatapenjaminanadmin",
        dataType: 'json',
        success: function (data)
        {

            if (data.level == 'bntb') 
            {
                $('#bntb').prop('hidden', false);
                $('#npwp').prop('required', true);
                $('#siup').prop('required', true);
                 $('#level').val('Bntb'); 
            } 
            else {
                $('#bntb').prop('hidden', true);
                $('#npwp').prop('required', false);
                $('#siup').prop('required', false);
                $('#level').val('BPR');
            }
            penjaminan = data.jenispenjaminan;
            $('#caseket').val(data.caseket);
            $('#idbank').val(data.idbank);
            $('#siup').val(data.siup);
            $('#npwp').val(data.npwp);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#ktp').val(data.ktp);
            $('#name').val(data.nama);
            $('#tglLahir').val(data.tgllahir);
            $('#tempatlahir').val(data.tempatlahir);
            $('#tampil1').val(data.umur);
            $('#tampil').val(data.umur);
            $('#kodepenjaminan').val(data.nosertifikat);
            $('#kodepenjaminan1').val(data.nosertifikat);
            $('#pekerjaan').val(data.pekerjaan);
            $('#jeniskredit').val(data.jeniskredit);
            $('#alamat').val(data.alamat);
            $('#tglrealisasi').val(data.tglrealisasi);
            $('#tgljatuhtempo').val(data.tgljatuhtempo);
            $('#masaKredit1').val(data.masakredit);
            $('#masaKredit').val(data.masakredit);
            $('#umurjatuhtempo1').val(data.umurjatuhtempo);
            $('#umurjatuhtempo').val(data.umurjatuhtempo);
            $('#nopk').val(data.nopk);
            $('#tglpk').val(data.tglpk);
            $('#plafon').val(data.plafon);
            $('#tglpengajuan').val(data.tglpengajuan);
            $('#tglpengajuan1').val(data.tglpengajuan);
            $('#modalpelunasan').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('PROSES PELUNASAN KREDIT');
            $('#button_action').val('update');

              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             }); 
            const bulan= data.masakredit ;
            const plafon= data.plafon ;
            const jeniskredit= data.jeniskredit ;
            const idbank= data.idbank;
            $.ajax({
            type    : "POST",
            url       :'PilihJenisPenjaminan', 
            data: 
                    {
                        'bulan': bulan ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'html',
            success: function (data) 
            {
                    $("#JenisPnj").html(data);
                    $('#JenisPnj').val(penjaminan);

                }
            });
        }
    })

});



$(document).on('click', '.klickvalidasi', function () 
{
    var id = $(this).attr("id");
    var analisa;
    $('#validation_form')[0].reset();
    $('#form_output').html('');
    $('#peringatan').html('');
    $.ajax({
        method  : 'get',
        data    : 'id='+id,
        url     : "/ajaxdata/fetchdataValidasi/pengajuan",
        dataType: 'json',
        success: function (data)
        {
            if (data.analisa==null)
            {
                analisa='';
            }
            else
            {
                analisa=data.analisa;
            }
            if(data.jenispengajuan=='kompensasi')
            {
                $('#nopkkonpensasi').html('Nomor Adendum PK');
            }
            
             if(data.tglGrace!='01/01/1970'){ 
                   $('#tblGrace'). removeClass('hidden');
                   $('#ketGracePeriode').html('Selama : '+data.masaGrace+' Bulan '+'Sejak Tanggal : ' +data.tglGrace+'  S/D '  +data.akhirGrace);
            }else{
                  $('#tblGrace'). addClass('hidden');
            }
            
            var cek_jatuh_tempo = data.cek_jatuh_tempo;
            
            if (cek_jatuh_tempo>65){
                   $('#notification').html('<b style="color:red">Umur jatuh tempo lebih dari ketentuan !!!</b>')
                   $('.proses').attr('disabled', true);
            }else{
                $('#notification').html('')
                $('.proses').attr('disabled', false);
            }
            
            $('#ktp').val(data.ktp);
            $('#phone').val(data.phone);
            $('#nama').val(data.nama);
            $('#umur').val(data.umurjatuhtempo);
            $('#pekerjaan').val(data.pekerjaan);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#jeniskredit').val(data.jeniskredit);
            $('#tgllahir').val(data.tgllahir);
            $('#jenispenjaminan').val(data.jenispenjaminan);
            $('#nopk').val(data.nopk);
            $('#rate').val(data.rate);
            $('#ijp').val(data.ijp);
            $('#admin').val(data.admin);
            $('#materai').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#masakredit').val(data.masakredit);
            $('#potongan').val(data.potongan);
            $('#periode').val(data.periode);
            $('#plafon').val(data.plafon);
            $('#premi').val(data.nett);
            $('#analisa').val(analisa);
//            $('#ceklab').attr("href", "files/scanlab/" + data.ceklab);
           // $('#kesehatan').attr("href", "files/suratsehat/" + data.kesehatan);
//            $('#kesehatanrs').attr("href", "files/suratsehatrs/" + data.kesehatanrs);
           // $('#pembayaran').attr("href", "cekbuktibayar/" + data.nosertifikat);
            
//            $('#validasiModal').modal('show');
            $('#validasiModal').modal('show');
            $('.modal-title').text('VALIDASI PENGAJUAN');
            if(data.kesehatanrs=='')
            {
              $("#kesehatanrstable").prop('hidden', true);   
            }
           else
           {
              $("#kesehatanrstable").prop('hidden', false);    
           }
           
            if(data.ceklab=='')
            {
              $("#ceklabinput").prop('hidden', true);   
            }
           else
           {
              $("#ceklabinput").prop('hidden', false);    
           }
           

           $(document).on('click', '#ceklab', function () {
                window.open('/files/scanlab/'+data.ceklab,'myWindow', 'fullscreen=yes,scrollbars=yes');
           });
            
           $(document).on('click', '#pembayaran', function () {
                window.open('pembayaran/'+data.nosertifikat,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });
            $(document).on('click', '#kesehatan', function () {
                window.open('kesehatan/'+data.nosertifikat,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });
            
            $(document).on('click', '#kesehatanrs', function () {
                window.open('kesehatanrs/'+data.nosertifikat,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });
            
            if (data.lewat > 0) {
                $('#peringatan').html('<div class="alert alert-danger">' + data.pengajuan + '</div>');
            }
            var idPenjaminan = $('#idpenjaminan').val();
            $.ajax({
                method: 'get',
                data: 'id=' + idPenjaminan,
                url: "ShowHistoryApproval",
                dataType: 'html',
                success: function (data)
                {
//                    alert(data.pesan.request.id);
//                    console.log(JSON.stringify(data));
//                    console.log(data.pesan[id]);
//                    console.dir(data);
//                    console.log(data.pesan['analisa']);
//                    $('#historyApproval').html(data.pesan[i-1]['analisa']);
//                    var i=data.pesan.length; 
//                    while(i>0)
//                    {
//                         $('#historyApproval').html(data.pesan[i-1]['analisa']);
//                        alert(data.pesan[i-1]['analisa']);
//                        i--;
//                       
//                    }
                    $('#historyApproval').html(data);

                }
            });
            
            
        }
    })

});

$(document).on('click', '.klickvalidasidireksi', function () {
    var id = $(this).attr("id");
    var analisa;
    
    $('#validation_form_direksi')[0].reset();
    $('#form_output').html('');

    $.ajax({
        method: 'get',
        data: 'id='+id,
        url: "/ajaxdata/fetchdataValidasi/pengajuan",
        dataType: 'json',
        success: function (data)
        {
            
            if (data.analisa==null){
                analisa='SESUAI';
            }else{
                analisa=data.analisa;
            }
            
            if(data.jenispengajuan=='kompensasi'){
                $('#nopkkonpensasi').html('Nomor Adendum PK');
            }
            $('#petugas').val(data.oleh);
            $('#ktp').val(data.ktp);
            $('#nama').val(data.nama);
            $('#umur').val(data.umurjatuhtempo);
            $('#pekerjaan').val(data.pekerjaan);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#jeniskredit').val(data.jeniskredit);
            $('#tgllahir').val(data.tgllahir);
            $('#jenispenjaminan').val(data.jenispenjaminan);
            $('#nopk').val(data.nopk);
            $('#rate').val(data.rate);
            $('#ijp').val(data.ijp);
            $('#admin').val(data.admin);
            $('#materai').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#masakredit').val(data.masakredit);
            $('#potongan').val(data.potongan);
            $('#premi').val(data.nett);
            $('#periode').val(data.periode);
            $('#plafon').val(data.plafon);
            $('#analisaUmur').val(data.analisa_umur);
            $('#Tensi').val(data.tensi);
            $('#Glukosa').val(data.guladarah);
            $('#kolesterol').val(data.kolesterol);
            $('#Jantung').val(data.tekanan_jantung);
            $('#analisaKesehatan').val(data.analisa_kesehatan);
            $('#analisa').val(analisa);
            $('#ceklab').attr("href", data.url_penjaminan + data.ceklab);
            $('#kesehatan').attr("href", data.url_penjaminan+ data.kesehatan);
            $('#kesehatanrs').attr("href", data.url_penjaminan + data.kesehatanrs);
            $('#pembayaran').attr("href", data.url_penjaminan + data.pembayaran);
            $('#rekomendasi').val(data.hasilakhir);   
            $('#tangapan').val(data.tanggapandir);   
            $('#validasiModal').modal('show');
            $('.modal-title').text('VALIDASI PENGAJUAN');
           
           if(data.kesehatanrs==''){
              $("#kesehatanrstable").prop('hidden', true);   
           }else{
              $("#kesehatanrstable").prop('hidden', false);    
           }
            $(document).on('click', '#kesehatan', function () {
                window.open('/files/suratsehat/'+data.kesehatan,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });
             $(document).on('click', '#ceklab', function () {
                window.open('/files/scanlab/'+data.ceklab,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });
             $(document).on('click', '#pembayaran', function () {
                window.open('/files/buktibayar/'+data.pembayaran,'myWindow', 'fullscreen=yes,scrollbars=yes');
            });

        }
    })

});

$('.prosesValidasi').click(function(){
    var konfirmasi= confirm('Apakah anda yakin data yang diberikan sudah sesuai !!!!? ');
    if(konfirmasi==true)
    {
        
      var   approval='Setuju';
      $('#validation_form').submit();
                //Kirim data ke database setelah klik submit validasi
//       subbmitValidasiAutoCover(approval);
    }
   
})
$('.proses').click(function(){
    var konfirmasi= confirm('Apakah anda yakin data yang diberikan sudah sesuai !!!!? ');
    if(konfirmasi==true)
    {
        
      var   approval='Setuju';
      $('#validation_form').submit();
                //Kirim data ke database setelah klik submit validasi
//       subbmitValidasiAutoCover(approval);
    }
   
})

$('.revisi').click(function(){
    var konfirmasi= confirm('Apakah anda yakin untuk mengemebalikan pengajuan ini ke bank? ');
    if(konfirmasi==true)
    {
       var   approval='Revisi';
                //Kirim data ke database setelah klik submit validasi
       subbmitValidasiAutoCover(approval);
    }
   
})

$('.tolak').click(function(){
    var konfirmasi= confirm('Pengajuan ini tidak akan dapat diajukan kembali jika anda melakuan penolakan, apakah anda yakin? ');
    if(konfirmasi==true)
    {
       var   approval='Tolak';
                //Kirim data ke database setelah klik submit validasi
       subbmitValidasiAutoCover(approval);
    }
   
})

$('.tolakCase').click(function(){
    var konfirmasi= confirm('Pengajuan ini tidak akan dapat diajukan kembali jika anda melakuan penolakan, apakah anda yakin? ');
    if(konfirmasi==true)
    {
       var   approval='Tolak';
                //Kirim data ke database setelah klik submit validasi
      subbmitValidasiCase (approval);
    }
   
})

$('.revisiCase').click(function(){
    var konfirmasi= confirm('Apakah anda yakin untuk mengembalikan pengajuan ini ke bank? ');
    if(konfirmasi==true)
    {
       var   approval='Revisi';
                //Kirim data ke database setelah klik submit validasi
      subbmitValidasiCase (approval);
    }
   
})
$('.prosesCase').click(function(){
    var konfirmasi= confirm('Apakah anda yakin semua data sudah sesuai ??');
    if(konfirmasi==true)
    {
       var   approval='direksi';
                //Kirim data ke database setelah klik submit validasi
      subbmitValidasiCase (approval);
    }
   
})


function subbmitValidasiAutoCover(approval)
{
     $('#validation_form').on('submit', function (event) 
        {
        //autocover
        
            var validasi = $('#validasi').val();
            var cekcase = $('#case').val();
            var idpenjaminan = $('#idpenjaminan').val();
            var nama = $('input[name=nama]:checked').val();
            var umur = $('input[name=umur]:checked').val();
            var pekerjaan = $('input[name=pekerjaan]:checked').val();
            var jeniskredit = $('input[name=jeniskredit]:checked').val();
            var periode = $('input[name=periode]:checked').val();
            var plafon = $('input[name=plafon]:checked').val();
            var premi = $('input[name=premi]:checked').val();
            var kesehatan = $('input[name=kesehatan]:checked').val();
            var kesehatanrs = $('input[name=kesehatanrs]:checked').val();
            var pembayaran = $('input[name=pembayaran]:checked').val();
            var masaKredit = $('input[name=masaKredit]:checked').val();
            var potongan = $('input[name=potongan]:checked').val();
            var ktp = $('input[name=ktp]:checked').val();
            var rate = $('input[name=rate]:checked').val();
            var ijp = $('input[name=ijp]:checked').val();
            var nopk = $('input[name=nopk]:checked').val();
            var jenispenjaminan = $('input[name=jenispenjaminan]:checked').val();
            var tgllahir = $('input[name=tgllahir]:checked').val();
            var analisa = $('#analisa').val();

            if (rate) {
                rate = $('input[name=rate]:checked').val();
            } else {
                rate = '';
            }
            if (ijp) {
                ijp = $('input[name=ijp]:checked').val();
            } else {
                ijp = '';
            }
            if (pekerjaan) {
                pekerjaan = $('input[name=pekerjaan]:checked').val();
            } else {
                pekerjaan = '';
            }
            if (jeniskredit) {
                jeniskredit = $('input[name=jeniskredit]:checked').val();
            } else {
                jeniskredit = '';
            }

            if (periode) {
                periode = $('input[name=periode]:checked').val();
            } else {
                periode = '';
            }
            if (premi) {
                premi = $('input[name=premi]:checked').val();
            } else {
                premi = '';
            }

            if (kesehatan) {
                kesehatan = $('input[name=kesehatan]:checked').val();
            } else {
                kesehatan = '';
            }
            if (kesehatanrs) {
                kesehatanrs = $('input[name=kesehatanrs]:checked').val();
            } else {
                kesehatanrs = '';
            }
            if (pembayaran) {
                pembayaran = $('input[name=pembayaran]:checked').val();
            } else {
                pembayaran = '';
            }
            if (nama) {
                nama = $('input[name=nama]:checked').val();
            } else {
                nama = '';
            }
            if (umur) {
                umur = $('input[name=umur]:checked').val();
            } else {
                umur = '';
            }
            if (tgllahir) {
                tgllahir = $('input[name=tgllahir]:checked').val();
            } else {
                tgllahir = '';
            }
            if (jenispenjaminan) {
                jenispenjaminan = $('input[name=jenispenjaminan]:checked').val();
            } else {
                jenispenjaminan = '';
            }

            if (masaKredit) {
                masaKredit = $('input[name=masaKredit]:checked').val();
            } else {
                masaKredit = '';
            }
            if (potongan) {
                potongan = $('input[name=potongan]:checked').val();
            } else {
                potongan = '';
            }
            if (ktp) {
                ktp = $('input[name=ktp]:checked').val();
            } else {
                ktp = '';
            }

            if (analisa) {
                analisa = $('#analisa').val();
            } else {
                analisa = '';
            }
            if (nopk) {
                nopk = $('input[name=nopk]:checked').val();
            } else {
                nopk = '';
            }

            $.ajax({

                url: "validasi/tambah",
                method: 'get',
                //data: 'jenis=' + jenis + '&periode=' + periode,
                data:   'analisa=' + analisa +
                        '&validasi=' + validasi +
                        '&nama=' + nama +
                        '&rate=' + rate +
                        '&ijp=' + ijp +
                        '&umur=' + umur +
                        '&jeniskredit=' + jeniskredit +
                        '&periode=' + periode +
                        '&plafon=' + plafon +
                        '&premi=' + premi +
                        '&kesehatan=' + kesehatan +
                        '&kesehatanrs=' + kesehatanrs +
                        '&pembayaran=' + pembayaran +
                        '&masaKredit=' + masaKredit +
                        '&potongan=' + potongan +
                        '&ktp=' + ktp +
                        '&idpenjaminan=' + idpenjaminan +
                        '&tgllahir=' + tgllahir +
                        '&jenispenjaminan=' + jenispenjaminan +
                        '&nopk=' + nopk +
                        '&case=' + cekcase +
                        '&pekerjaan=' + pekerjaan+
                        '&approval=' + approval,
                dataType: "json",
                success: function (data)
                {
                    if (data.error.length > 0)
                    {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                        }
                        $('#form_output').html(error_html);


                    } 
                    else 
                    {
                        $('#customLoad').show();
                        $('#form_output').html(data.success);
                        $('#validation_form')[0].reset();
                        setTimeout(function () 
                        {
                            $('#validasiModal').modal('hide');
                        }, 2000);

                        alert(data.success);

                        if(data.cek_sudah_app=='1')
                        {
                             window.location.href = "datapenjaminanview";
                        }
                        else
                        {                   
                            if(data.approval=='Tolak'){
                                 window.location.href = "datapenjaminanview";
                            }else{
                                 window.location.href = "belumProsesAll";
                            } 
                        }

                    }
                }
            })
        }); 
}


$(document).on('click', '.validasicase', function () 
{
    var id = $(this).attr("id");
    $('#validation_form_bayar')[0].reset();
    $('#form_output').html('');

    $.ajax({
        method: 'get',
        data: 'id= ' + id,
        url: "/ajaxdata/fetchdataValidasi",
        dataType: 'json',
        success: function (data)
        {

            $('#idpenjaminan').val(id);
            $('#nama').val(data.nama);
            $('#premi').val(data.ijp);
            $('#nett').val(data.nett);
            $('#potongan').val(data.potongan);
            $('#admin').val(data.admin);
            $('#materai').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#analisa').val(data.analisa);
            $('#pembayaran').attr("href", "/files/buktibayar/" + data.pembayaran);
            $('#validasiCaseModal').modal('show');
            $('.modal-title').text('VALIDASI PEMBAYARAN');


        }
    })

});

$(document).on('click', '.validasicaseBelumBayar', function () 
{
    var id = $(this).attr("id");
    $('#validation_form_case')[0].reset();
    $('#form_output').html('');

    $.ajax({
        method:'get',
        data:'id='+id,
        url:"/ajaxdata/fetchdataValidasi",
        dataType:'json',
        success:function(data)
        {
            
            $('#ktp').val(data.ktp);
            $('#nama').val(data.nama);
            $('#ijp').val(data.ijp);
            $('#ijp1').val(data.ijp);
            $('#ratecase').val(data.rate);
            $('#potongan').val(data.potongan);
            $('#potongan1').val(data.potongan);
            $('#premi').val(data.nett);
            $('#premi1').val(data.nett);
            $('#umur').val(data.umurjatuhtempo);
            $('#pekerjaan').val(data.pekerjaan);
            $('#idpenjaminan').val(id);
            $('#jeniskredit').val(data.jeniskredit);
            $('#tgllahir').val(data.tgllahir);
            $('#jenispenjaminan').val(data.jenispenjaminan);
            $('#nopk').val(data.nopk);
            $('#masakredit').val(data.masakredit);
            $('#periode').val(data.periode);
            $('#plafon').val(data.plafon);
            
            if(data.url_penjaminan!=null){ 
              
//            $('#analisa').val(data.analisa);
                $('#kesehatan') .attr("href", data.url_penjaminan  + data.kesehatan);
                $('#kesehatanrs').attr("href", data.url_penjaminan  + data.kesehatanrs);  
                 
                $('#ceklab').attr("href", data.url_penjaminan  + data.ceklab);
//                                 $('#ceklab').attr("target", "_blank");
            }else{
               $('#ceklab').attr("href", "/files/scanlab/" + data.ceklab);
//            $('#analisa').val(data.analisa);
                $('#kesehatan') .attr("href", "/files/suratsehat/" + data.kesehatan);
                $('#kesehatanrs').attr("href", "/files/suratsehatrs/" + data.kesehatanrs);  
            } 
            $('#validasiCaseBelumBayarModal').modal('show');
            $('.modal-title').text('VALIDASI CASE BY CASE');
            $('#analisa').val(data.analisa);
            $('#analisaUmur').val(data.analisaUmur);
            $('#TekananDarah').val(data.TekananDarah);
            $('#GulaDarah').val(data.GulaDarah);
            $('#Kolesterol').val(data.Kolesterol);
            $('#Tekananjantung').val(data.Tekananjantung);
            $('#analisaKesehatan').val(data.analisaKesehatan);
            $('#hasilakhir').val(data.hasilakhir);
           
            if(data.statusbayar=='1')
            {//cek apakah file pembayaran kosong atau ditidak
                
                if(data.url_penjaminan!=null){ 
                     $('#pembayaran').attr("href", data.url_penjaminan+ data.pembayaran);
                }else{ 
                       $('#pembayaran').attr("href", "/files/buktibayar/" + data.pembayaran);
                }
                
              $("#pembayaraninput").prop('hidden', false); 
              if (data.cekpembayaran=='Ok') 
              {
               $('#validasipembayaran1').attr('checked', true); 
              } else if (data.cekpembayaran=='Tolak') 
              {
               $('#validasipembayaran1').attr('checked', true);
              }
            
               
            }
            else
            {
              $("#pembayaraninput").prop('hidden', true);   
              $('#FormCatatanPembayaran').hide();
            }
           
            $('#cek_pembayaran').val(data.statusbayar);//UNTUK MEMBERIKAN STATUS PEMBAYARAN PADA FORM
           
            if(data.statusbayar==1)
            {
                $('#FormAnalisa').hide();
            }
           
           
           if(data.cekktp=='Ok'){
               $('#validasiktp').attr('checked',true);
               $('#validasiktp1').attr('checked',false);
           }else if(data.cekktp=='Tolak') {
               $('#validasiktp1').attr('checked',true);
               $('#validasiktp').attr('checked',false);
           }
           if(data.ceknama=='Ok'){
               $('#validasinama').attr('checked',true);
               $('#validasinama1').attr('checked',false);
           }else if(data.ceknama=='Tolak') {
               $('#validasinama1').attr('checked',true);
                $('#validasinama').attr('checked',false);
           }
           
           if(data.cektgllahir=='Ok'){
               $('#validasitgllahir').attr('checked',true);
               $('#validasitgllahir1').attr('checked',false);
           }else if(data.cektgllahir=='Tolak') {
               $('#validasitgllahir1').attr('checked',true);
               $('#validasitgllahir').attr('checked',false);
           }
            
           if(data.cekpekerjaan=='Ok'){
               $('#validasipekerjaan1').attr('checked',true);
               $('#validasipekerjaan').attr('checked',false);
           }else if(data.cekpekerjaan=='Tolak') {
               $('#validasipekerjaan').attr('checked',true);
               $('#validasipekerjaan1').attr('checked',false);
           }
           
           //JENIS PRODUKTIF/ KONSUMTIF
           if(data.cekjeniskredit=='Ok'){
               $('#validasijeniskredit1').attr('checked',true);
               $('#validasijeniskredit').attr('checked',false);
           }else if(data.cekjeniskredit=='Tolak') {
               $('#validasijeniskredit').attr('checked',true);
               $('#validasijeniskredit1').attr('checked',false);
           }
           
           if(data.cekjenispenjaminan=='Ok'){
               $('#validasijenijp').attr('checked',true);
               $('#validasijenijp1').attr('checked',false);
           }else if(data.cekjenispenjaminan=='Tolak') {
               $('#validasijenijp1').attr('checked',true);
               $('#validasijenijp').attr('checked',false);

           }
           
           if(data.ceknopk=='Ok'){
               $('#validasinopk1').attr('checked',true);
               $('#validasinopk').attr('checked',false);
           }else if(data.ceknopk=='Tolak') {
               $('#validasinopk').attr('checked',true);
               $('#validasinopk1').attr('checked',false);
           }
             
           // TANGGAL PERTANGGUNGAN
           
           if(data.cekperiode=='Ok'){
               $('#validasiperiode').attr('checked',true);
               $('#validasiperiode1').attr('checked',false);
           }else if(data.cekperiode=='Tolak') {
               $('#validasiperiode1').attr('checked',true);
               $('#validasiperiode').attr('checked',false);
           }
           
           // LAMA KREDIT
           if(data.cekmasakredit=='Ok'){
               $('#validasimasaKredit1').attr('checked',true);
               $('#validasimasaKredit').attr('checked',false);
           }else if(data.cekmasakredit=='Tolak') {
               $('#validasimasaKredit').attr('checked',true);
               $('#validasimasaKredit1').attr('checked',false);

           }
           
           if(data.cekplafon=='Ok'){
               $('#validasiplafond1').attr('checked',true);
               $('#validasiplafond').attr('checked',false);
           }else if(data.cekplafon=='Tolak') {
               $('#validasiplafond').attr('checked',true);
               $('#validasiplafond1').attr('checked',false);

           }
           
           if(data.cekrate=='Ok'){
               $('#validasirate').attr('checked',true);
               $('#validasirate1').attr('checked',false);
           }else if(data.cekrate=='Tolak') {
               $('#validasirate1').attr('checked',true);
               $('#validasirate').attr('checked',false);

           }
           
           if(data.ceknett=='Ok'){
               $('#validasipremi').attr('checked',true);
               $('#validasipremi1').attr('checked',false);

           }else if(data.ceknett=='Tolak') {
               $('#validasipremi1').attr('checked',true);
               $('#validasipremi').attr('checked',false);

           }
          // Cek GROSS IJP
           if(data.cekijp=='Ok'){
               $('#validasiijp').attr('checked',true);
               $('#validasiijp1').attr('checked',false);

           }else if(data.cekijp=='Tolak') {
               $('#validasiijp1').attr('checked',true);
               $('#validasiijp').attr('checked',false);

           }
           
           if(data.cekpembayaran=='Ok'){
               $('#validasibayar').attr('checked',true);
               $('#validasibayar1').attr('checked',false);
           }else if(data.cekpembayaran=='Tolak') {
               $('#validasibayar1').attr('checked',true);
               $('#validasibayar1').attr('checked',false);
           }
            
           if(data.ceksuratsehat=='Ok'){
               $('#validasikesehatan').attr('checked',true);
               $('#validasikesehatan1').attr('checked',false);
           }else if(data.ceksuratsehat=='Tolak') {
               $('#validasikesehatan1').attr('checked',true);
               $('#validasikesehatan').attr('checked',false);

           }
            
           if(data.ceksuratsehatrs=='Ok'){
               $('#validasikesehatanrs').attr('checked',true);
              $('#validasikesehatanrs1').attr('checked',false);

           }else if(data.ceksuratsehatrs=='Tolak') {
               $('#validasikesehatanrs1').attr('checked',true);
               $('#validasikesehatanrs').attr('checked',false);

           }
           if(data.ceklabcek=='Ok'){
               $('#validasiceklab').attr('checked',true);
               $('#validasiceklab1').attr('checked',false);

           }else if(data.ceklabcek=='Tolak') {
               $('#validasiceklab1').attr('checked',true);
               $('#validasiceklab').attr('checked',false);

           }
          
           if(data.cekpotongan=='Ok'){
               $('#validasidiscount1').attr('checked',true);
                $('#validasidiscount').attr('checked',false);

           }else if(data.cekpotongan=='Tolak') {
               $('#validasidiscount').attr('checked',true);
               $('#validasidiscount1').attr('checked',false);

           }
           if(data.cekumur=='Ok'){
               $('#validasiumur').attr('checked',true);
               $('#validasiumur1').attr('checked',false);

           }else if(data.cekumur=='Tolak') {
               $('#validasiumur1').attr('checked',true);
               $('#validasiumur').attr('checked',false);

           }
           
           if(data.cekplafon=='Ok'){
               $('#validasiplafond1').attr('checked',true);
               $('#validasiplafond').attr('checked',false);

           }else if(data.cekplafon=='Tolak') {
               $('#validasiplafond').attr('checked',true);
               $('#validasiplafond1').attr('checked',false);

           }
           
           if(data.ceklab==''){
              $("#ceklabinput").prop('hidden', true); 
              $("#validasiceklab").prop('checked', true);  
           }else{
              $("#ceklabinput").prop('hidden', false); 
           }
          
           var idPenjaminan = $('#idpenjaminan').val();
            $.ajax({
                method: 'get',
                data: 'id=' + idPenjaminan,
                url: "ShowHistoryApproval",
                dataType: 'html',
                success: function (data)
                {
//                    alert(data.pesan.request.id);
//                    console.log(JSON.stringify(data));
//                    console.log(data.pesan[id]);
//                    console.dir(data);
//                    console.log(data.pesan['analisa']);
//                    $('#historyApproval').html(data.pesan[i-1]['analisa']);
//                    var i=data.pesan.length; 
//                    while(i>0)
//                    {
//                         $('#historyApproval').html(data.pesan[i-1]['analisa']);
//                        alert(data.pesan[i-1]['analisa']);
//                        i--;
//                       
//                    }
                    $('#historyApproval').html(data);
                    
                }
            });
           
        }
    })

});

//Kirim data ke database setelah klik submit validasi
function subbmitValidasiCase (approval)
{
    $('#validation_form_case').on('submit', function (event)
    {
        var validasi = $('#validasi').val();
        var idpenjaminan = $('#idpenjaminan').val();
        var nama = $('input[name=nama]:checked').val();
        var umur = $('input[name=umur]:checked').val();
        var pekerjaan = $('input[name=pekerjaan]:checked').val();
        var jeniskredit = $('input[name=jeniskredit]:checked').val();
        var periode = $('input[name=periode]:checked').val();
        var plafon = $('input[name=plafon]:checked').val();
        var premi = $('input[name=premi]:checked').val();
        var kesehatan = $('input[name=kesehatan]:checked').val();
        var kesehatanrs = $('input[name=kesehatanrs]:checked').val();
        var ceklab = $('input[name=ceklab]:checked').val();
        var masaKredit = $('input[name=masaKredit]:checked').val();
        var potongan = $('input[name=potongan]:checked').val();
        var ktp = $('input[name=ktp]:checked').val();
        var analisa = $('#analisa').val();
        var rate = $('input[name=rate]:checked').val();
        var ijp = $('input[name=ijp]:checked').val();
        var nopk = $('input[name=nopk]:checked').val();
        var jenispenjaminan = $('input[name=jenispenjaminan]:checked').val();
        var tgllahir = $('input[name=tgllahir]:checked').val();
        var pembayaran = $('input[name=pembayaran]:checked').val();
        var ratecase = $('#ratecase').val();
        var ijpcase = $('#ijp1').val();
        var potongancase = $('#potongan1').val();
        var ijpnettcase = $('#premi1').val();

        var TekananDarah = $('#TekananDarah').val();
        var GulaDarah = $('#GulaDarah').val();
        var Kolesterol = $('#Kolesterol').val();
        var Tekananjantung = $('#Tekananjantung').val();
        var analisaKesehatan = $('#analisaKesehatan').val();
        var analisaPekerjaan = $('#analisaPekerjaan').val();
        var analisaUmur = $('#analisaUmur').val();
        var catatanPembayaran = $('#catatanPembayaran').val();
        var caseket = $('#case').val();
        var hasilakhir = $('#hasilakhir').val();


        if (plafon)
        {
            plafon = $('input[name=plafon]:checked').val();
        } else
        {
            plafon = '';
        }

        if ($('#cek_pembayaran').val() == '0') {
            pembayaran = $('input[name=pembayaran]:checked').val();
        } else {
            if (pembayaran) {
                pembayaran = $('input[name=pembayaran]:checked').val();
            } else {
                pembayaran = '';
            }
        }


        if (rate) {
            rate = $('input[name=rate]:checked').val();
        } else {
            rate = '';
        }
        if (ijp) {
            ijp = $('input[name=ijp]:checked').val();
        } else {
            ijp = '';
        }

        if (pekerjaan) {
            pekerjaan = $('input[name=pekerjaan]:checked').val();
        } else {
            pekerjaan = '';
        }
        if (jeniskredit) {
            jeniskredit = $('input[name=jeniskredit]:checked').val();
        } else {
            jeniskredit = '';
        }

        if (periode) {
            periode = $('input[name=periode]:checked').val();
        } else {
            periode = '';
        }
        if (premi) {
            premi = $('input[name=premi]:checked').val();
        } else {
            premi = '';
        }

        if (kesehatan) {
            kesehatan = $('input[name=kesehatan]:checked').val();
        } else {
            kesehatan = '';
        }
        if (kesehatanrs) {
            kesehatanrs = $('input[name=kesehatanrs]:checked').val();
        } else {
            kesehatanrs = '';
        }

        if (nama) {
            nama = $('input[name=nama]:checked').val();
        } else {
            nama = '';
        }
        if (umur) {
            umur = $('input[name=umur]:checked').val();
        } else {
            umur = '';
        }
        if (tgllahir) {
            tgllahir = $('input[name=tgllahir]:checked').val();
        } else {
            tgllahir = '';
        }
        if (jenispenjaminan) {
            jenispenjaminan = $('input[name=jenispenjaminan]:checked').val();
        } else {
            jenispenjaminan = '';
        }

        if (masaKredit) {
            masaKredit = $('input[name=masaKredit]:checked').val();
        } else {
            masaKredit = '';
        }
        if (potongan) {
            potongan = $('input[name=potongan]:checked').val();
        } else {
            potongan = '';
        }
        if (ktp) {
            ktp = $('input[name=ktp]:checked').val();
        } else {
            ktp = '';
        }

        if (analisa) {
            analisa = $('#analisa').val();
        } else {
            analisa = '';
        }

        if (nopk) {
            nopk = $('input[name=nopk]:checked').val();
        } else {
            nopk = '';
        }
        if (ceklab) {
            ceklab = $('input[name=ceklab]:checked').val();
        } else {
            ceklab = '';
        }

        $('#customLoad').show();
        $('#action').attr('disabled', true);

            $.ajax({
                url: "validasi/tambah",
                method: 'get',
                data:
                        'cekpembayaran=' + $('#cek_pembayaran').val() +
                        '&ratecase=' + ratecase +
                        '&ijpcase=' + ijpcase +
                        '&potongancase=' + potongancase +
                        '&ijpnettcase=' + ijpnettcase +
                        '&ceklab=' + ceklab +
                        '&rate=' + rate +
                        '&ijp=' + ijp +
                        '&validasi=' + validasi +
                        '&nama=' + nama +
                        '&umur=' + umur +
                        '&jeniskredit=' + jeniskredit +
                        '&periode=' + periode +
                        '&plafon=' + plafon +
                        '&premi=' + premi +
                        '&kesehatan=' + kesehatan +
                        '&kesehatanrs=' + kesehatanrs +
                        '&masaKredit=' + masaKredit +
                        '&potongan=' + potongan +
                        '&ktp=' + ktp +
                        '&idpenjaminan=' + idpenjaminan +
                        '&tgllahir=' + tgllahir +
                        '&jenispenjaminan=' + jenispenjaminan +
                        '&nopk=' + nopk +
                        '&pekerjaan=' + pekerjaan +
                        '&TekananDarah=' + TekananDarah +
                        '&GulaDarah=' + GulaDarah +
                        '&Kolesterol=' + Kolesterol +
                        '&Tekananjantung=' + Tekananjantung +
                        '&analisaKesehatan=' + analisaKesehatan +
                        '&analisa=' + analisa +
                        '&analisaUmur=' + analisaUmur +
                        '&pembayaran=' + pembayaran+
                        '&approval=' + approval+
                        '&hasilakhir=' + hasilakhir+
                        '&caseket=' + caseket+ 
                        '&catatanPembayaran=' + catatanPembayaran,

                dataType: "json",
                success: function (data)
                {
                    if (data.error.length > 0)
                    {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                        }
                        $('#form_output').html(error_html);
                        $('#customLoad').hide();
                    } else
                    {
                        $('#form_output').html(data.success);
                        $('#validation_form_case')[0].reset();
                        setTimeout(function () {
                            $('#validasiCaseBelumBayarModal').modal('hide');
                        }, 2000);
                        alert(data.success);
                        window.location.href = "datapenjaminanview";
                    }
                }
            })


    });
}


$(document).on('click', '.uploadscanlab', function () {
    var id = $(this).attr("id");
    $('#formUploadScanLab')[0].reset();
    $("#formUploadScanLab").prop('action', 'ajaxdata/tambah');
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {
            $('#titleupload1').html('Pilih File ScanLab | PDF  |JPG');
            $('#namaterjamin1').val(data.nama);
            $('#sertifikat1').val(data.nosertifikat);
            $('#modalUploadSuratScanlab').modal('show');
            $('.modal-title').text('Upload Scan Lab');
            $('#button_action1').val('Upload');
        }
    })
});


//Klick btn 

$('#btn_sign').on('click', function () {
      $('#customLoad').show();
//      $('#btn_sign').attr('disabled',true);
});


//Validasi sudah bayar

$('#validation_form_bayar').on('submit', function (event) {
   
    var validasi = $('#validasi').val();
    var idpenjaminan = $('#idpenjaminan').val();
    var analisa = $('#analisa').val();
    var pembayaran = $('input[name=pembayaran]:checked').val();
    if (pembayaran) {
        pembayaran = $('input[name=pembayaran]:checked').val();
    } else {
        pembayaran = '';
    }


    $.ajax({

        url: "validasi/tambah",
        method: 'get',
        //data: 'jenis=' + jenis + '&periode=' + periode,
        data: 'analisa=' + analisa + 
               '&validasi=' + validasi + 
               '&nama=' + 
               '&pembayaran=' + pembayaran + 
               '&idpenjaminan=' + idpenjaminan,
        dataType: "json",
        success: function (data)
        {
            if (data.error.length > 0)
            {
                var error_html = '';
                for (var count = 0; count < data.error.length; count++)
                {
                    error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                }
                $('#form_output').html(error_html);
            } else
            {
                $('#action').attr('disabled',true);
                $('#form_output').html(data.success);
                $('#validation_form_bayar')[0].reset();
                setTimeout(function () {
                    $('#validasiCaseModal').modal('hide');
                }, 2000);
                alert(data.success);
                window.location.href = "datapenjaminanview";
            }
        }
    })
});


$(document).on('click', '.edit', function () {
    var id = $(this).attr("id");
    $('#form_output').html('');
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'name= ' + id,
        dataType: 'json',
        success: function (data)
        {
            $('#first_name').val(data.first_name);
            $('#last_name').val(data.last_name);
            $('#pekerjaan').val(data.pekerjaan);
            $('#student_id').val(id);
            $('#studentModal').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('Edit Data');
            $('#button_action').val('update');
        }
    })
});

$('#uploadsurat').click(function () {
    $('#studentModal').modal('show');
    $('#formPenjaminan')[0].reset();
    $('#form_output').html('');
    $('#button_action').val('insert');
    $('#action').val('Add');
    $('.modal-title').text('Add Data');
});


    
$('.Sign').click(function(){
    var id = $(this).attr("id");
    $('#SignModal').modal('show');
    $('#SignDireksi')[0].reset();
    $('#form_output').html('');

    $.ajax({
        method: 'get',
        data: 'id='+id,
        url: "/ajaxdata/fetchdataValidasi/pengajuan",
        dataType: 'json',
        success: function (data)
        {
            
            if (data.analisa==null){
                analisa='SESUAI';
            }else{
                analisa=data.analisa;
            }
            
            if(data.jenispengajuan=='kompensasi'){
                $('#nopkkonpensasi').html('Nomor Adendum PK');
            }
            $('#petugas').val(data.oleh);
            $('#ktp').val(data.ktp);
            $('#nama').val(data.nama);
            $('#umur').val(data.umurjatuhtempo);
            $('#pekerjaan').val(data.pekerjaan);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#jeniskredit').val(data.jeniskredit);
            $('#tgllahir').val(data.tgllahir);
            $('#jenispenjaminan').val(data.jenispenjaminan);
            $('#nopk').val(data.nopk);
            $('#rate').val(data.rate);
            $('#ijp').val(data.ijp);
            $('#admin').val(data.admin);
            $('#materai').val(data.materai);
            $('#totalbayar').val(data.totalbayar);
            $('#masakredit').val(data.masakredit);
            $('#potongan').val(data.potongan);
            $('#periode').val(data.periode);
            $('#plafon').val(data.plafon);
            $('#analisaUmur').val(data.analisa_umur);
            $('#Tensi').val(data.tensi);
            $('#Glukosa').val(data.guladarah);
            $('#kolesterol').val(data.kolesterol);
            $('#Jantung').val(data.tekanan_jantung);
            $('#analisaKesehatan').val(data.analisa_kesehatan); 
            $('#validasiModal').modal('show');
            $('.modal-title').text('TANDA TANGAN DIGITAL');
         

        }
    })
})

$(document).on('click', '.editpenjaminan', function () {
    var id = $(this).attr("id");
    var penjaminan;
    $('#formPenjaminanUpdate')[0].reset();
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        { 
            
            if((data.case=='Ya') && (data.statusbayar='0') )
            {
              $('#nopk').attr('required',false);  
              $('#tglrealisasi').attr('disabled',true);  
              $('#tgljatuhtempo').attr('disabled',true);  
              $('#nopk').attr('disabled',true);  
              $('#tglpk').attr('disabled',true);  
            }
            penjaminan = data.jenispenjaminan; 
      
            if(data.tglGrace!='01/01/1970'){ 
               $('#formGracePeriod'). removeClass('hidden');
               $('#tglGrace').val(data.tglGrace);
               $('#masaGrace').val(data.masaGrace);
            }else{
                  $('#formGracePeriod'). addClass('hidden');
            }
           
            
            $('#phone').val(data.phone);
            $('#kodepusat').val(data.kodepusat);
            $('#statusbayar').val(data.statusbayar);
            $('#caseket').val(data.case);
            $('#siup').val(data.siup);
            $('#npwp').val(data.npwp);
            $('#idpenjaminan').val(data.idpenjaminan);
            $('#ktp').val(data.ktp);
            $('#ktplama').val(data.ktp);
            $('#name').val(data.nama);
            $('#tglLahir').val(data.tgllahir);
            $('#tempatlahir').val(data.tempatlahir);
            $('#tampil1').val(data.umur);
            $('#tampil').val(data.umur);
            $('#kodepenjaminan').val(data.nosertifikat);
            $('#kodepenjaminan1').val(data.nosertifikat);
            $('#pekerjaan').val(data.pekerjaan);
            
            
           if (data.jenis_pekerjaan=='KARYAWAN'){
                  $('#radio-karyawan').attr('checked',true)
           }
           if (data.jenis_pekerjaan=='PENGUSAHA'){
                  $('#radio-pengusaha').attr('checked',true)
           }
              
            $('#detail_Pekerjaan').val(data.pekerjaan);   
           
            if (data.jeniskredit=='PRODUKTIF'){
                  $('#radio-produktif').attr('checked',true)
           }
           if (data.jeniskredit=='KONSUMTIF'){
                  $('#radio-konsumtif').attr('checked',true)
           }
           
            $('#jeniskredit').val(data.jeniskredit); 
            $('#penggunaan').val(data.penggunaan);
            $('#alamat').val(data.alamat);
            $('#tglrealisasi').val(data.tglrealisasi);
            $('#tgljatuhtempo1').val(data.tgljatuhtempo);
            $('#tgljatuhtempo').val(data.tgljatuhtempo);
            $('#masaKredit1').val(data.masakredit);
            $('#masaKredit').val(data.masakredit);
            $('#umurjatuhtempo1').val(data.umurjatuhtempo);
            $('#umurjatuhtempo').val(data.umurjatuhtempo);
            $('#nopk').val(data.nopk);
            $('#tglpk').val(data.tglpk);
            $('#plafon').val(data.plafon);
            $('#tglpengajuan').val(data.tglpengajuan);
            $('#tglpengajuan1').val(data.tglpengajuan);
            $('#modalEditPenjaminan').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('DETAIL DATA PENJAMINAN');
            $('#button_action').val('update');
            $('#jenis_penjaminan').val(data.jenispenjaminan1);   
            
            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             }); 
            const bulan= data.masakredit ;
            const plafon= data.plafon ;
            const jeniskredit= data.jeniskredit ;
            const idbank= data.idbank;
            $.ajax({
            type    : "POST",
            url       :'PilihJenisPenjaminan', 
            data: 
                    {
                        'bulan': bulan ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'html',
            success: function (data) 
            {
                    $("#Jenispilihan").html(data);
                    $('#jenisPenjaminan').val(penjaminan); 
            }
            });
            
        }
    })
    
    
});

$(document).on('click', '.kirimPenjaminan', function () {
    var id = $(this).attr("id");
    var penjaminan;
    $('#formPenjaminanUpdate')[0].reset();
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {  
            $('#NamaTerjamin').val(data.nama);
            $('#PlafonKredit').val(formatNumber(data.plafon));
            $('#idpenjaminancase').val(data.idpenjaminan);
            $('#nosertfikatcase').val(data.nosertifikat);
            $('#modalKirim').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('KIRIM PENJAMINAN CASE BY CASE');
            $('#button_action').val('Kirim');
        }
    })
});

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

$(document).on('click', '.ajukankembali', function () 
{
    var id = $(this).attr("id");
    var penjaminan;
    $('#formPenjaminanUpdate1')[0].reset();
    $.ajax({
        url: "/ajaxdata/fetchdata",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {
            if (data.statusbayar!=1 && data.case=="Ya")
            {
                $('#nopk1').hide();
                $('#nopk1').attr('required',false); 
                $('#tglrealisasi1').hide();
                $('#tglpk1').hide(); 
            }
            penjaminan = data.jenispenjaminan;
            $('#caseket1').val(data.case);
            $('#siup1').val(data.siup);
            $('#npwp1').val(data.npwp);
            $('#idpenjaminan1').val(data.idpenjaminan);
            $('#ktp1').val(data.ktp);
            $('#name1').val(data.nama);
            $('#tglLahir1').val(data.tgllahir);
            $('#tempatlahir1').val(data.tempatlahir);
            $('#tampil12').val(data.umur);
            $('#tampil2').val(data.umur);
            $('#kodepenjaminan2').val(data.nosertifikat);
            $('#kodepenjaminan12').val(data.nosertifikat);
            $('#pekerjaan1').val(data.pekerjaan);
            $('#jeniskredit1').val(data.jeniskredit);
            $('#alamat1').val(data.alamat);
            $('#tglrealisasi1').val(data.tglrealisasi);
            $('#tgljatuhtempo12').val(data.tgljatuhtempo);
            $('#tgljatuhtempo1').val(data.tgljatuhtempo);
            $('#masaKredit12').val(data.masakredit);
            $('#masaKredit2').val(data.masakredit);
            $('#umurjatuhtempo12').val(data.umurjatuhtempo);
            $('#umurjatuhtempo2').val(data.umurjatuhtempo);
            $('#nopk1').val(data.nopk);
            $('#tglpk1').val(data.tglpk);
            $('#plafon12').val(data.plafon);
            $('#tglpengajuan2').val(data.tglpengajuan);
            $('#tglpengajuan12').val(data.tglpengajuan);
            $('#nosertifikat').val(data.nosertifikat);
            $('#modalAjukankembali').modal('show');
            $('#action').val('Edit');
            $('.modal-title').text('DATA PENGAJUAN ULANG');
            $('#jenis_penjaminan_ulang').val(data.jenispenjaminan1);
            $('#button_action1').val('update');
            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             }); 
            const bulan= data.masakredit ;
            const plafon= data.plafon ;
            const jeniskredit= data.jeniskredit ;
            const idbank= data.idbank;
            $.ajax({
            type    : "POST",
            url       :'PilihJenisPenjaminan', 
            data: 
                    {
                        'bulan': bulan ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'html',
            success: function (data) {
                    $("#JenisPnj1").html(data);
                    $('#JenisPnj1').val(penjaminan);
                }
            });
        }
    })
});


//$('#simpan1').on('click', function () {
//    $('#customLoad').show();
//    $('#simpan1').attr('disabled',true);
//})

$(document).on('click', '.klickvalidasisp3', function () {
    var id = $(this).attr("id");
    var konfir=confirm('Terbitkan Surat Persetujuan Prinsip Penjaminan ?');
    if (konfir){
        $.ajax({
            method: 'get',
            data: 'id=' + id,
            url: "terbitkan-sp3",
            dataType: 'json',
            success: function (data)
            {
                alert(data.success);
                window.location.href = "datapenjaminanview";
            }
        })
    }
   
});

$(document).on('click', '.klickvalidasitolak', function () {
    var id = $(this).attr("id");
    $('#idTolakan').val(id);
    $('#modalTolak').modal('show');
});

$(document).on('click', '.terbitkanTolak', function () {
    var id = $('#idTolakan').val();
    var analisa = $('#alasanTolak').val();
    var konfirmasi = confirm('Apakah alasan tolakan sudah sesuai?')
    if (konfirmasi){
        $.ajax({
            method: 'get',
            data: 'idpenjaminan=' + id+'&analisa='+analisa+'&approval=Tolak',
            url: "terbitkan-surat-tolak",
            dataType: 'json',
            success: function (data)
            {
                alert(data.success);
                window.location.href = "datapenjaminanview";
            }
        })
    }
    
});

$('#validation_form_direksi').on('submit', function (event) {

    var konfirmasi=confirm('Apakah anda yakin semua data sudah di isi dengan lengkap??');
   
    if(konfirmasi)
    {
            $('#proses').attr('disabled',true);
            $('#customLoad').show();
            var idpenjaminan = $('#idpenjaminan').val();
            var approval = $('#approval').val();
            var tanggapan = $('#tangapan').val();

            $.ajax({

                url: "validasi/direksi",
                method: 'get',
                //data: 'jenis=' + jenis + '&periode=' + periode,
                data: 'idpenjaminan=' + idpenjaminan +
                      '&approval=' + approval +
                      '&tanggapan=' + tanggapan ,
                dataType: "json",
                success: function (data)
                {
                    $('#form_output').html(data.success);
                    $('#validation_form_direksi')[0].reset();
                    setTimeout(function () {
                        $('#validasiModal').modal('hide');
                    }, 2000);
                    alert(data.success);
                    window.location.href = "/appdireksi";
                }
            })
    }
    
    
    
});


$(document).on('click', '.export-data', function () 
{
    var nosertifikat = $(this).attr("id");
    $.ajax({
            url                 : "eksport-data-penjaminan-view",
            method      : 'get',
            data             : 'nosertifikat=' + nosertifikat,
            dataType  : "json",
            success : function (data)
            {
//                 $('#id_btn_simpan').val(nosertifikat);
                   $('#tgl_verifikasi_kasi').val(data.tglterbit);
                   $('#tgl_verifikasi_keu').val(data.tglterbit);
                   $('#nomor_sertifikat').val(nosertifikat);
                   $('#nomor_sertifikat_view').val(nosertifikat);
                   $('#nama_terjamin').val(data.nama);
                   $('#penerima_jaminan').val(data.namabank);
                   $('#tanggal_pengajuan').val(data.tglpengajuan);
                   $('#tanggal_terbit').val(data.tglterbit);
                   $('.data-export').modal('show');
            }
        })

});

$(document).on('click', '.export-data-simpan', function () {
    var nosertifikat = $('#nomor_sertifikat').val();
    var tgl_verifikasi_kasi = $('#tgl_verifikasi_kasi').val();
    var tgl_verifikasi_keu = $('#tgl_verifikasi_keu').val();
    var nosertifikat = $('#nomor_sertifikat').val();
    var kode_kas = $('#kd_kas').val();
    var konfirmasi = confirm('Apakah anda yakin untuk Export Data Dengan No Sertifikat : ' + nosertifikat + '?');
    if (konfirmasi) {
        
        $('#id_btn_simpan').attr('disabled',true);
        $.ajax({
            url     : "eksport-data-penjaminan",
            method  : 'get',
            data    : 'nosertifikat=' + nosertifikat+
                      '&tgl_verifikasi_kasi=' + tgl_verifikasi_kasi+
                      '&tgl_verifikasi_keu=' + tgl_verifikasi_keu+
                      '&kd_kas=' + kode_kas
                    ,
            dataType: "json",
            success : function (data)
            {
                alert(data.success);
                window.location.href = "sinkronisasi";
            }
        })
    }

});

$(document).on('click', '.hapus-penjaminan', function () {
    var no_transaksi = $(this).attr("id");
    var kd_terjamin = $(this).attr("name");
    var konfirmasi = confirm('Apakah anda yakin untuk menghapus Data Dengan No transaksi : ' + no_transaksi + '?');
    if (konfirmasi) {
        $.ajax({
            url: "hapus-data-penjaminan",
            method: 'get',
            data: 'no_transaksi=' + no_transaksi+
                  '&kd_terjamin=' + kd_terjamin 
                    ,
            dataType: "json",
            success: function (data)
            {
                alert(data.success);
                location.reload();
            }
        })
    }

});
