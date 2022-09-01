 $('#btn-cari').on('click', function () {
     var data_pencarian =  $('#data-pencarian').val();
     var jenis_pencarian =  $('#jenis-pencarian').val();
      
      if((jenis_pencarian!='')&&(data_pencarian!=''))
      {
             $('#form-cari').submit();
      }else{
          alert('silahkan isi data terlebih dahulu!!');
      } 
});

$(document).ready(function () {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function (event) {
        location.hash = this.getAttribute("href");
    });
});

$(window).on("popstate", function () {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});

$(document).ready(function () {
    var date_input = $('input[id="tgl"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,

    })
})
$(document).ready(function () {
    var date_input = $('.tanggal');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        widgetPositioning: {
            horizontal: 'right',
            vertical: 'top'
        }
    })
})

$(document).ready(function () {
    var date_input = $('input[name="tglLhr"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })
})

$(document).ready(function () {
    var date_input = $('input[name="dari"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })
})

$(document).ready(function () {
    var date_input = $('input[name="sampai"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })
})

function hitungUmur() {
    
    var tgl_lahir = $('#tglLahir').val();
    
    $.ajax({
        url: "hitungumur",
        method: 'get',
        data: 'tglLahir=' + tgl_lahir,
        dataType: 'json',
        success: function (data) {

            $("#tampil").val(data.umur );
            $("#tampil1").val(data.umur + ' Tahun');

            if (data.umur < 15) 
            {
                alert('Umur Kurang Dari 15 Tahun, Pengajuan Tidak dapat dilanjutkan, Mohon Periksa Kembali Tanggal Lahir Terjamin');
                $('#simpan').prop('disabled', true);
                $('#tglLahir').css("background-color", "#FFEBCD").focus();

            } 
            else 
            {
                $('#simpan').prop('disabled', false);
            }

//            $("#tgljatuhtempo").prop('value', '')
             $("#tglrealisasi").prop('disabled', false);
             
             var proses= $('#proses').val();
             
             if (proses=='update')
             {
               hitungUmurJatuhTempo();  
             }

        }
    })

}

function HitungUmurCase() {
   
    var tgl_lahir   = $('#tglLahir').val();
    var masa_kredit = $('#masaKreditCase').val();

    $.ajax({
        url     : "hitungumurjatuhtempo",
        method  : 'get',
        data    : 'tglLahir=' + tgl_lahir + '&masakredit=' + masa_kredit,
        dataType: 'json',
        success : function (data) 
        {
            $("#umurjatuhtempo").prop('value', (data.Tahun) + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');
            $("#umurjatuhtempo1").prop('value', (data.Tahun) + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');

            if (data.Tahun > 65) 
            { 
                $("#simpan").prop('disabled', true);
                $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 65 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");

            } 
            else 
            {
                $("#simpan").prop('disabled', false);
                $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");
            }
        }
    })

}
function HitungUmurJatuhTempoFix() {
    
    var masa_kredit     = $('#masaKredit').val();
    var case_ket             = $('#caseket').val();
    var realisasi             = $('#tglrealisasi').val();
    
    alert
//    if (case_ket=='Ya')
//    { var tgl = $('#tglLahir').val(); }
//    else
//    { var tgl = $('#tglrealisasi').val();}
//    
     var   tgl = $('#tglLahir').val(); 
//    alert(case_ket);
    $.ajax({
        url     : "hitungumurjatuhtempo",
        method  : 'get',
//        data    : 'tglLahir=' + tgl_lahir + '&masakredit=' + masa_kredit,
          data: 
                    {
                        'tglLahir': tgl ,
                        'masakredit': masa_kredit,  
                        'caseket': case_ket,  
                        'realisasi': realisasi
                    },
        dataType: 'json',
        success : function (data) 
        {
            $("#umurjatuhtempo").prop('value', (data.Tahun) + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');
            $("#umurjatuhtempo1").prop('value', (data.Tahun) + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');

            if (data.Tahun > 65) 
            { 
                $("#simpan").prop('disabled', true);
                $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 65 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");
            } 
            else 
            {
                $("#simpan").prop('disabled', false);
                $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");
            }
        }
    })

}


function hitungUmur1() {
    tglLahir = $("#tglLahir1").val();
    $.ajax({
        url: 'validasi/checker.php',
        data: {tgl: tglLahir},
        type: 'POST',
        dataType: 'json',
        success: function (data) {

            $("#tampil2").val(data.Tahun + ' Tahun');
            $("#tampil12").val(data.Tahun + ' Tahun');

            if (data.Tahun < 15) {
                alert('Umur Kurang Dari 15 Tahun, Pengajuan Tidak dapat dilanjutkan, Mohon Periksa Kembali Tanggal Lahir Terjamin');
                $('#simpan1').prop('disabled', true);
                $('#tglLahir1').css("background-color", "#FFEBCD").focus();

            } else {
                $('#simpan1').prop('disabled', false);
            }

            $("#tgljatuhtempo1").prop('value', '')
            $("#tglrealisasi1").prop('disabled', false);
        }
    })

}

function ValidateSuratPernyataanSehat(formData, jqForm, options)
{
    
    var form                                = jqForm[0];
//    var FileSuratSehat            = $('#fileSuratSehat'.option);
    var FileSuratSehat            = $('#fileSuratSehat');
    var PathFileSuratSehat   = FileSuratSehat.val();
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

    if (!form.fileSuratSehat.value)
    {
        alert('Harap pilih file surat Pernyataan Sehat Nasabah!!!');
        return false;
    } 
    else
    {
        if (!ekstensiOk.exec(PathFileSuratSehat))
        {
            alert(PathFileSuratSehat);
            FileSuratSehat.val('');
            return false;
        } 
        else
        {
            var file_size = $('#fileSuratSehat')[0].files[0].size;
            var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

            if (file_size > maxsize)
            {
                alert('Ukuran File surat pernyataan sehat Max ' + maxsize + 'Kb');
                FileSuratSehat.val('');
                return false;
            }
        }

    }
}

function ValidateFileUpload(file) {
        var FileSize = file.files[0].size; // in MB
        var FileType = file.value;
        var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.gif)$/i;
         
         if(!ekstensiOk.exec(FileType)){
                alert('Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png/.gif');
                file.value = '';
                return false; 
            }else{
                 var maxsize = 1024 * 700; // maksimal 700 KB (1KB = 1024 Byte)
                 if (FileSize > maxsize) {
                        alert('Kapasitas file tidak boleh lebih 700 Kb !! ');
                        file.value = '';
                        return false; 
                }  
            }
    }
    
    
function UploadSuratPernyataanSehat()
{
    
    var bar             = $('#bar_sk');
    var percent     = $('#percent_sk');
    var status          = $('#status');
                        
    $('#formPenjaminan').ajaxForm({

        beforeSubmit:ValidateSuratPernyataanSehat,
        beforeSend: function ()
        {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete)
        {
            
            $('#ProgresSuratPernyataan').removeAttr('Hidden');
            $('#simpan').attr('disabled', true);
            $('#customLoad').show();
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        success:
                function ()
                {
                    var percentVal = '<b>Succes, Saving</b>';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    alert('Pengajuan berhasil disimpan');
                    window.location.href = "bpr";
                },
        complete:
                function (xhr)
                {
                    status.html(xhr.responseText);
                },

        error:
                function ()
                {
                    var percentVal = '<b style="Color:red">Error</b>';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    alert('Pengajuan Gagal Di simpan, silahkan input kembali');
                    window.location.href = "penjaminanAdd";

                },

    });
}

// Validasi untuk surat keterangan sehat

function ValidasiSuratKeteranganSehat(formData, jqForm, options)
{
    
    ValidateSuratPernyataanSehat(formData, jqForm, options);
    var form = jqForm[0];
    var FileSuratKeterangan = $('#fileSuratSehatRs');
    var PathFileSuratKeterangan = FileSuratKeterangan.val();
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

    if (!form.fileSuratSehatRs.value)
    {
        alert('Harap pilih file Surat Keterangan Sehat Dari Rumah Sakit !!!');
        return false;
    } 
    else
    {
        if (!ekstensiOk.exec(PathFileSuratKeterangan))
        {
            alert('Silahkan upload file keterangan Dari Rumah Sakit yang memiliki ekstensi .pdf atau .PDF');
            FileSuratKeterangan.val('');
            return false;
        } 
        else
        {
            var file_size = $('#fileSuratSehatRs')[0].files[0].size;
            var maxsize = 1024 * 700; //

            if (file_size > maxsize)
            {
                alert('Ukuran File keterangan Dari Rumah Sakit Max 700 Kb');
                FileSuratKeterangan.val('');
                return false;
            }
        }

    }

}

function UploadSuratKeteranganSehat()
{
    var bar_sk = $('#bar_sk');
    var percent_sk = $('#percent_sk');
    
    var bar = $('#bar_rs');
    var percent = $('#percent_rs');
    var status = $('#status');

    $('#formPenjaminan').ajaxForm({
        beforeSubmit: ValidasiSuratKeteranganSehat,
        beforeSend:
                function ()
                {
                    
                    status.empty();
                    
                    var percentVal = '0%';
                    bar_sk.width(percentVal)
                    percent_sk.html(percentVal);
                    
                    
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    
                    
                },
        uploadProgress:
                function (event, position, total, percentComplete)
                {
                    $('#ProgresSuratPernyataan').removeAttr('Hidden');
                    $('#ProgressSuratKeterangan').removeAttr('Hidden');
                    
                    $('#customLoad').show();
                    
                    var percentVal = percentComplete + '%';
                    bar_sk.width(percentVal)
                    percent_sk.html(percentVal);
                    
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    
                },
        success:
                function ()
                {
                    
                    var percentVal = '<b>Succes, Saving</b>';
                    bar_sk.width(percentVal)
                    percent_sk.html(percentVal);
                    
                    var percentVal = '<b>Succes, Saving</b>';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    
                    alert('Pengajuan berhasil disimpan');
                    
                    window.location.href = "bpr";
                },
        complete:
                function (xhr)
                {
                    status.html(xhr.responseText);
                },

        error:
                function ()
                {
                    var percentVal = '<b style="Color:red">Format PDF Tidak Sesuai !!!</b>';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    alert('Pengajuan Gagal Di simpan, silahkan input kembali');
                    window.location.href = "penjaminanAdd";

                },
    });

}


function ValidasiCekLab(formData, jqForm, options)
{
    var form                = jqForm[0];
    var FileSuratSehat      = $('#fileSuratSehat');
    var PathFileSuratSehat  = FileSuratSehat.val();
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

    if (!form.fileSuratSehat.value)
    {
        alert('Harap pilih file surat Pernyataan Sehat Nasabah!!!');
        return false;
    } 
    else
    {
        if (!ekstensiOk.exec(PathFileSuratSehat))
        {
            alert('Silakan upload file surat pernyataan sehat yang memiliki ekstensi .pdf atau .PDF');
            FileSuratSehat.val('');
            return false;
        } 
        else
        {
            var file_size = $('#fileSuratSehat')[0].files[0].size;
            var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

            if (file_size > maxsize)
            {
                alert('Ukuran File surat pernyataan sehat Max ' + maxsize + 'Kb');
                FileSuratSehat.val('');
                return false;
            }
        }

    }
    
    var form = jqForm[0];
    var FileSuratKeterangan = $('#fileSuratSehatRs');
    var PathFileSuratKeterangan = FileSuratKeterangan.val();
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

    if (!form.fileSuratSehatRs.value)
    {
        alert('Harap pilih file Surat Keterangan Sehat Dari Rumah Sakit !!!');
        return false;
    } 
    else
    {
        if (!ekstensiOk.exec(PathFileSuratKeterangan))
        {
            alert('Silahkan upload file keterangan Dari Rumah Sakit yang memiliki ekstensi .pdf atau .PDF');
            FileSuratKeterangan.val('');
            return false;
        } 
        else
        {
            var file_size = $('#fileSuratSehatRs')[0].files[0].size;
            var maxsize = 1024 * 700; //

            if (file_size > maxsize)
            {
                alert('Ukuran File keterangan Dari Rumah Sakit Max 700 Kb');
                FileSuratKeterangan.val('');
                return false;
            }
        }

    }
    
    var form        = jqForm[0];
    var FileCekLab  = $('#fileCekLab');
    var PathFile    = FileCekLab.val();
    var ekstensiOk  = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

    if (!form.fileCekLab.value)
    {
        alert('Harap Pilih File Cek Lab Terlebih Dahulu !!!');
        return false;
    } 
    else
    {
        if (!ekstensiOk.exec(PathFile))
        {
            alert('Silakan upload file Cek Lab yang memiliki ekstensi .pdf atau .PDF');
            FileCekLab.val('');
            return false;
        } 
        else
        {
            var file_size = $('#fileCekLab')[0].files[0].size;
            var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

            if (file_size > maxsize)
            {
                alert('Ukuran File Cek Lab Max 700 Kb');
                FileCekLab.val('');
                return false;
            }
        }
    }
}



function UploadCekLab(idform)
{
    
    var bar_sk = $('#bar_sk');
    var percent_sk = $('#percent_sk');
    
    var bar = $('#bar_rs');
    var percent = $('#percent_rs');
    
    var bar_cl = $('#bar_cl');
    var percent_cl = $('#percent_cl');
    
    var status = $('#status');

    $(idform).ajaxForm({
        
        beforeSubmit: ValidasiCekLab,
        beforeSend: function () {
            
            status.empty();
             
            var percentVal = '0%';
            bar_cl.width(percentVal)
            percent_cl.html(percentVal);

            var percentVal = '0%';
            bar_sk.width(percentVal)
            percent_sk.html(percentVal);
            
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
            
        },
        uploadProgress: function (event, position, total, percentComplete) {
           
            $('#simpan').attr('disabled', true);
            $('#customLoad').show();
            
            $('#ProgresSuratPernyataan').removeAttr('Hidden');
            $('#ProgressSuratKeterangan').removeAttr('Hidden');
            $('#ProgressCekLab').removeAttr('Hidden');
            
            var percentVal = percentComplete + '%';
            bar_cl.width(percentVal)
            percent_cl.html(percentVal);
            
            var percentVal = percentComplete + '%';
            bar_sk.width(percentVal)
            percent_sk.html(percentVal);

            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
            
        },
        success: function () {
            
            var percentVal = '<b>Succes, Saving</b>';
            bar_sk.width(percentVal);
            percent_sk.html(percentVal);

            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal);
            percent.html(percentVal);
            
            var percentVal = '<b>Succes, Saving</b>';
            bar_cl.width(percentVal);
            percent_cl.html(percentVal);
           
            alert('Pengajuan Case By Case berhasil disimpan, selanjutnya silhkan klik tombol kirim!!');
            window.location.href = "bpr#casebycase";
            
        },
        complete: function (xhr) {
            status.html(xhr.responseText);

        },
        error: function () {
            var percentVal = '<b style="Color:red">Format PDF Tidak Sesuai !!!</b>';
            bar_cl.width(percentVal);
            percent_cl.html(percentVal);
            alert('Pengajuan pengajuan gagal disimpan, silahkan input kembali !!!');
            window.location.href = "/bpr";

        },
    });
}

 function CekCase()  { 
        plafon  = $("#plafon").val();
        idbank = $("#idbank").val();
//        jeniskredit = $("#jeniskredit").val();
        
         if ($('#radio-konsumtif').is(":checked")) {
             jeniskredit =   $('#radio-konsumtif').val();
        }
         if ($('#radio-produktif').is(":checked")) {
             jeniskredit =   $('#radio-produktif').val();
        }
     
//        alert(jeniskredit)
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "POST",
            url:'cek-kondisi-case',  
            data: 
                    { 
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit
                    },
            dataType: 'json',
            success: function (data) 
            {
                var  case_ket = data.case_ket;
//                         console.log(data.case_ket);
//                         const obj = JSON.parse(data);  
//                         const id_persyaratan = obj.id;

                if(case_ket=='Ya'){
                      $('#inputRealisasi').addClass('hidden') 
                      $('#inputPK').addClass('hidden') 
                      $('#nopk').val('-')
                      $('#msg_case').text('Pengajuan diproses secara case by case !!!')
                      $('#caseket').val(case_ket)
                }else{
                      $('#inputRealisasi').removeClass('hidden') 
                      $('#inputPK').removeClass('hidden') 
                      $('#nopk').val('')
                      $('#msg_case').text('')
                      $('#caseket').val(case_ket)
                }
//                alert('halo'); 
            }
        })
   }
   
 function HitungLabaBersih()  { 
      var  angsuran  = $("#angsuran").val(); 
      var  omset        = $("#omsetPenjualan").val(); 
      var  biayaRumahTangga        = $("#biayaRumahTangga").val(); 
      var  biayaUsaha        = $("#biayaUsaha").val(); 
      var  angsuranKreditTempatLain        = $("#angsuranKreditTempatLain").val(); 
      var  hpp             = $("#hpp").val(); 
//  
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "POST",
            url:'/hitung-laba-rugi',  
            data: 
                    { 
                        'angsuran': angsuran ,  
                        'hpp': hpp ,  
                        'biayaRumahTangga': biayaRumahTangga ,  
                        'biayaUsaha': biayaUsaha ,  
                        'angsuranKreditTempatLain': angsuranKreditTempatLain ,  
                        'omset': omset   
                    },
            dataType: 'json',
            success: function (data) 
            {
//                var  case_ket = data.case_ket; 
//                alert(data.kapasitas_bayar); 
//                console.log(data.kapasitas_bayar)
                $('#labaBersih').val(data.labarugi);
                
                if(data.kapasitas_bayar=="memenuhi"){ 
                        $('#memenuhi').prop('disabled',false)
                        $('#tidakMemenuhi').prop('disabled',true) 
                        $('#memenuhi').prop('checked',true)
                        $ ('#tidakMemenuhi').prop('checked',false)
                }else if(data.kapasitas_bayar=="tidak"){ 
                        $('#tidakMemenuhi').prop('disabled',false)
                        $('#memenuhi').prop('disabled',true)
                        $('#tidakMemenuhi').prop('checked',true)
                        $('#memenuhi').prop('checked',false)
                } 
                 
            }
        })
   }
 function HitungPendapatanBersih(){ 
      var  angsuran  = $("#angsuran").val(); 
      var  pendapatan        = $("#pendapatanPemohon").val(); 
      var  pendapatanLainnya        = $("#pendapatanLainnya").val(); 
      var  biayaRumahTangga        = $("#biayaRumahTangga").val();  
      var  angsuranKreditTempatLain        = $("#angsuranKreditTempatLain").val(); 
  
//  
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "POST",
            url:'/hitung-pendapatan-bersih',  
            data: 
                    { 
                        'angsuran': angsuran ,   
                        'pendapatan': pendapatan ,  
                        'pendapatanLainnya': pendapatanLainnya ,  
                        'biayaRumahTangga': biayaRumahTangga ,   
                        'angsuranKreditTempatLain': angsuranKreditTempatLain 
                      
                    },
            dataType: 'json',
            success: function (data) 
            {
//                var  case_ket = data.case_ket; 
//                alert(data.kapasitas_bayar); 
                console.log(data.kapasitas_bayar)
                $('#pendapatanBersih').val(data.pendapatanBersih);
                
                if(data.kapasitas_bayar=="memenuhi"){ 
                        $('#memenuhi').prop('disabled',false)
                        $('#tidakMemenuhi').prop('disabled',true) 
                        $('#memenuhi').prop('checked',true)
                        $ ('#tidakMemenuhi').prop('checked',false)
                }else if(data.kapasitas_bayar=="tidak"){ 
                        $('#tidakMemenuhi').prop('disabled',false)
                        $('#memenuhi').prop('disabled',true)
                        $('#tidakMemenuhi').prop('checked',true)
                        $('#memenuhi').prop('checked',false)
                } 
                 
            }
        })
   }
   
function CekPlafon() {

    var plafon          = $("#plafon").val();
    var JenisUser    = $("#level").val();
    var caseket        =$("#caseket").val();
    var umur            =$("#tampil").val();
    var idbank         =$("#idbank").val(); 
    
    var pesan = '<br><div class="alert alert-danger alert-dismissable">\n\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Silahkan Lengkapi Dokumen Surat Keterangan Kesehatan yang di buat oleh terjamin dan \n\
     Surat keterangan kesehatan dari Puskesmas/Rumah Sakit terdekat</b></div>';

    var pesan1 = '<br><div class="alert alert-danger alert-dismissable">\n\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 200 Juta akan di proses secara Case By Case, dan rate penjaminan akan di tentukan sesuai resiko, \n\
    <p style="color:black">Silahkan melengkapi data hasil Surat Pernyataan Kesehatan Dari Terjamin,\n\
    Surat Keterangan Kesehatan dari Puskesmas/Rumah Sakit Terdekat, dan Surat Keterangan CEK LAB, yang menunjukkan Hasil PEMERIKSAAN GETARAN JANTUNG, KADAR KOLESTEROL, KADAR GLUKOSA, DAN HASIL CEK URINE </p></b></b></div>';

    var pesan2 = '<br><div class="alert alert-danger alert-dismissable">\n\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 200 Juta akan di proses secara Case By Case, dan rate penjaminan akan di tentukan sesuai resiko, \n\
    <p style="color:black">Silahkan melengkapi data hasil Surat Pernyataan Kesehatan Dari Terjamin,\n\
    Surat Keterangan Kesehatan dari Puskesmas/Rumah Sakit Terdekat, dan Surat Keterangan CEK LAB , yang menunjukkan Hasil PEMERIKSAAN GETARAN JANTUNG, KADAR KOLESTEROL, KADAR GLUKOSA, HASIL CEK URINE dan RONTGEN(Pemeriksaan Paru- Paru) </p></b></b></div>';
     
    $.ajax({
        url     : 'cekplafon',
        data    :
                'plafon=' + plafon +
                '&level=' + JenisUser ,
        type: 'get',
        dataType: 'json',
        success: function (data) 
        {
            
            var ktp      = $('#ktp').val();
            var plafon      = data.plafon;
            var JenisUser   = data.level;
            var proses = $('#proses').val();
             
            if (JenisUser == 'BPR')
            {
                if (caseket == 'Tidak')
                {
                    if (plafon > 100000000 && plafon <= 200000000)
                    {
                        $("#pesanPlafon").html(pesan);
                        
                        if ( (idbank==62 ) || (idbank==63)|| (idbank==45))
                        {
                            if (plafon > 100000000) 
                            {
                                alert('Plafon diatas Rp. 100.000.000,-akan diproses secara Case By Case, mohon untuk tidak melakukan pencairan sebelum ada persetujuan dari PT. Jamkrida NTB !!!');
                                window.location.href = "/inputcase";
                            }

                        }
                        else
                        {
                            $("#CekKesehatanRs").prop('hidden', false);
                            $("#CekKesehatan").prop('hidden', true);

                            (function ()
                            {
                                UploadSuratKeteranganSehat();
                            }
                            )();
                        }
                     
                    }
                    else if (plafon <= 100000000)
                    {
                        $("#caseket").val('Tidak');
                        $("#pesanPlafon").html('');
                        if (idbank==62) //PT. BPR BIMA ABDI SWADAYA
                        {
                                   if(umur>50 && plafon>20000000){
                                       //SESUAI PKS DENGAN PT. BPR BIMA ABDI SWADAYA UNTUK UMUR DIATAS 50 DAN PLAFON DIATAS 20 JT AKAN CASE BY CASE
                                             $("#CekKesehatan").prop('hidden', false); 
                                             $("#CekKesehatanRs").prop('hidden', false);
//                                             $("#caseket").val('Ya');
                                   }else{ 
                                       if(plafon>50000000){
                                              $("#CekKesehatan").prop('hidden', true); 
                                              $("#CekKesehatanRs").prop('hidden', false);
//                                               $("#caseket").val('Ya');
                                       }else{
                                              $("#CekKesehatan").prop('hidden', true); 
                                              $("#CekKesehatanRs").prop('hidden', true);
//                                               $("#caseket").val('Ya');
                                       } 
                                   }
                                
                        }else{
                                   $("#CekKesehatanRs").prop('hidden', true);
                                   $("#CekKesehatan").prop('hidden', true); 
                        }
                 
                     
                        (function ()
                        {
                            UploadSuratPernyataanSehat()

                        })();
                    }
                    else if (plafon > 200000000)
                    { 
                       if (proses == 'update')
                        {
                           alert('Tidak dapat mengubah plafon diatas Rp. 200.000.000,-. silahkan melakukan pengajuan Case By Case');
                           $("#simpan").attr('disabled',true);
  
                        }
                        else
                        {
                           alert('Plafon diatas Dua Ratus Juta akan diproses secara Case By Case, mohon untuk tidak melakukan pencairan sebelum ada persetujuan dari PT. Jamkrida NTB !!!');
                           window.location.href = "/inputcase";
//                              $.ajax({
//                                url     : 'kirimdata',
//                                resp    :
//                                'plafon=' + plafon +
//                                '&level=' + JenisUser,
//                                type: 'get',
//                                dataType: 'json',
//                                success:function (resp)
//                                {
//                                    alert(resp.test);
//                                    $('#ktp').val(ktp);
//                                    window.location.href = "/inputcase/"+resp.test;
//                                    $('#ktp').val('12345');
//                                }
//                                   
//                            });
                        }
                        
                    }
                    
                    
                } 
                else if (caseket == 'Ya')
                {
                   
                    if (plafon > 200000000)
                    {
                        $("#CekKesehatan").prop('hidden', false);
                        $("#CekKesehatanRs").prop('hidden', false); 
                        (function ()
                        {
                            UploadCekLab('#formPenjaminan'); 
                        })();
                    }else{
                         if (proses == 'update')
                        {
                           alert('Plafon dibawah Rp. 200.000.000,- akan dimasukkan ke pengajuan Automatic Conditional Cover');
                           $("#caseket").val('Tidak');
  
                        }
                        else
                        {
                             if (
                                     idbank == 62|| //idbank bias
                                     idbank == 63//idbank pitih gumarang
                                     ) 
                            {
                                   if(plafon<100000000){
                                           alert('Plafon dibawah Rp. 100.000.000,- akan dimasukkan ke pengajuan Automatic Conditional Cover');
                                            window.location.href = "/penjaminanAdd";  
                                   }
                                  
                            }else{
                                  $("#pesanPlafon").html('');
                                  alert('Untuk pengajuan Case by Case plafon harus diatas Rp. 200.000.000,-');
                                  $("#plafon").val('');
                                  $("#plafon").focus();
                            } 
                        } 
                    }
                        
                }
            } 
            else if (JenisUser == 'Bntb')
            {
                if (data.plafon > 500000000)
                {
                    $("#caseket").val('Ya');
                    pesan = '<br><div class="alert alert-danger alert-dismissable">\n\
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 500jt, akan di proses secara Case By Case dan rate penjaminan akan di tentukan sesuai resiko, \n\
                    Silahkan melengkapi data hasil Cek Lab , yang menunjukkan Kadar Kolesterol dan Glukosa Terjamin  </b></b></div>';
                    $("#pesanPlafon").html(pesan);
                    $("#CekKesehatan").prop('hidden', false);
                    function validatePenjaminan(formData, jqForm, options) 
                    {
                        var form = jqForm[0];
                        var inputFile = document.getElementById('fileCekLab');
                        var pathFile = inputFile.value;
                        var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;
                        if (!form.fileCekLab.value)
                        {
                            alert('Harap Pilih File Cek Lab Terlebih Dahulu !!!');
                            return false;
                        } 
                        else
                        {

                            if (!ekstensiOk.exec(pathFile))
                            {
                                alert('Silakan upload file yang memiliki ekstensi .pdf atau .PDF');
                                inputFile.value = '';
                                return false;
                            }

                            var file_size = $('#fileCekLab')[0].files[0].size;
                            var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

                            if (file_size > maxsize)
                            {
                                alert('Ukuran File Max 700 Kb');
                                inputFile.value = '';
                                return false;
                            }
                        }

                        var inputFileSuratSehat = document.getElementById('fileSuratSehat');
                        var pathFileSuratSehat = inputFileSuratSehat.value;
                        var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;


                        if (!form.fileSuratSehat.value)
                        {
                            alert('Harap pilih file Surat Sehat yang akan di upload');
                            return false;
                        } 
                        else
                        {

                            if (!ekstensiOk.exec(pathFileSuratSehat)) {
                                alert('Silakan upload file yang memiliki ekstensi .pdf atau .PDF');
                                inputFileSuratSehat.value = '';
                                return false;
                            }

                            var file_size = $('#fileSuratSehat')[0].files[0].size;
                            var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

                            if (file_size > maxsize) {
                                alert('Ukuran File Max 700 Kb');
                                inputFileSuratSehat.value = '';
                                return false;
                            }
                        }

                    }

                    (function () {

                        var bar = $('.bar');
                        var percent = $('.percent');
                        var status = $('#status');

                        $('#formPenjaminan').ajaxForm({
                                    beforeSubmit: validatePenjaminan,
                                    beforeSend: function ()
                                    {
                                        status.empty();
                                        var percentVal = '0%';
                                        var posterValue = $('input[name=fileCekLab]').fieldValue();
                                        bar.width(percentVal)
                                        percent.html(percentVal);
                                    },
                                    uploadProgress: function (event, position, total, percentComplete)
                                    {
                                        $('#simpan').attr('disabled', true);
                                        $('#customLoad').show();
                                        var percentVal = percentComplete + '%';
                                        bar.width(percentVal)
                                        percent.html(percentVal);
                                    },
                                    success: function ()
                                    {
                                        var percentVal = '<b>Succes, Saving</b>';
                                        bar.width(percentVal)
                                        percent.html(percentVal);

                                    },
                                    complete: function (xhr)
                                    {

                                        status.html(xhr.responseText);
                                        alert('Pengajuan Case By Case berhasil disimpan, silahkan menunggu konfirmasi selanjutnya');
                                        window.location.href = "/bpr";
                                    },

                                    error: function () {
                                        var percentVal = '<b style="Color:red">Format PDF Tidak Sesuai !!!</b>';
                                        bar.width(percentVal);
                                        percent.html(percentVal);


                                    },
                                }

                        );


                    })();
                }
                else
                {

                    $("#caseket").val('Tidak');
                    $("#pesanPlafon").html('');
                    $("#CekKesehatan").prop('hidden', true);
                    function validatePenjaminan(formData, jqForm, options)
                    {
                        var form = jqForm[0];
                        var inputFile = document.getElementById('fileSuratSehat');
                        var pathFile = inputFile.value;
                        var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;

                        if (!form.fileSuratSehat.value)
                        {
                            alert('Harap pilih file surat sehat yang akan di upload');
                            return false;
                        }
                        else
                        {
                            if (!ekstensiOk.exec(pathFile))
                            {
                                alert('Silakan upload file yang memiliki ekstensi .pdf atau .PDF');
                                inputFile.value = '';
                                return false;
                            }
                            var file_size = $('#fileSuratSehat')[0].files[0].size;
                            var maxsize = 1024 * 70000; // maksimal 200 KB (1KB = 1024 Byte)

                            if (file_size > maxsize)
                            {
                                alert('Ukuran File Max '.maxsize + 'Kb');
                                inputFile.value = '';
                                return false;
                            }
                        }

                    }

                    (function () {

                        var bar = $('.bar');
                        var percent = $('.percent');
                        var status = $('#status');

                        $('#formPenjaminan').ajaxForm({
                            beforeSubmit: validatePenjaminan,
                            beforeSend: function ()
                            {
                                status.empty();
                                var percentVal = '0%';
                                var posterValue = $('input[name=fileCekLab]').fieldValue();
                                bar.width(percentVal)
                                percent.html(percentVal);
                            },
                            uploadProgress: function (event, position, total, percentComplete)
                            {
                                var percentVal = percentComplete + '%';
                                bar.width(percentVal)
                                percent.html(percentVal);
                            },
                            success: function ()
                            {
                                var percentVal = '<b>Succes, Saving</b>';
                                bar.width(percentVal)
                                percent.html(percentVal);
                                alert('Pengajuan berhasil disimpan, Silahkan lanjut ke proses pembayaran!!!');
                                window.location.href = "/bpr";
                            },
                            complete: function (xhr)
                            {
                                status.html(xhr.responseText);

                            },
                            error: function ()
                            {
                                var percentVal = '<b style="Color:red">Format PDF Tidak Sesuai !!!</b>';
                                alert('File gagal di Upload, Silahkan input kembali!!!');
                                bar.width(percentVal);
                                percent.html(percentVal);
                                alert('File Gagal diupload, silahkan input kembali!!!');
                                window.location.href = "/penjaminanAdd";

                            },
                        });


                    })();

                }
            }
            else if (JenisUser == 'koperasi')
            {
                
                if (caseket == 'Tidak')
                {
                    if (plafon > 100000000 && plafon <= 200000000)
                    {
                        $("#pesanPlafon").html(pesan);
                        $("#CekKesehatanRs").prop('hidden', false);
                        $("#CekKesehatan").prop('hidden', true);
                        (function ()
                        {
                            UploadSuratKeteranganSehat();
                        }
                        )();
                    }
                    else if (plafon < 100000000)
                    {
                        $("#caseket").val('Tidak');
                        $("#pesanPlafon").html('');
                        $("#CekKesehatan").prop('hidden', true);
                        $("#CekKesehatanRs").prop('hidden', true);

                        (function ()
                        {
                            UploadSuratPernyataanSehat()

                        })();
                    }
                    else if (plafon > 200000000)
                    {
                       

                       if (proses == 'update')
                        {
                           alert('Tidak dapat mengubah plafon diatas Rp. 200.000.000,-. silahkan melakukan pengajuan Case By Case');
                           $("#simpan").attr('disabled',true);
  
                        }
                        else
                        {
                           alert('Plafon diatas Dua Ratus Juta akan diproses secara Case By Case, mohon untuk tidak melakukan pencairan sebelum ada persetujuan dari PT. Jamkrida NTB !!!');
                           window.location.href = "/inputcase";
//                              $.ajax({
//                                url     : 'kirimdata',
//                                resp    :
//                                'plafon=' + plafon +
//                                '&level=' + JenisUser,
//                                type: 'get',
//                                dataType: 'json',
//                                success:function (resp)
//                                {
//                                    alert(resp.test);
//                                    $('#ktp').val(ktp);
//                                    window.location.href = "/inputcase/"+resp.test;
//                                    $('#ktp').val('12345');
//                                }
//                                   
//                            });
                        }
                        
                    }
                    
                    
                } 
                else if (caseket == 'Ya')
                {
                   
                    if (plafon > 200000000)
                    {
                        
                        $("#CekKesehatan").prop('hidden', false);
                        $("#CekKesehatanRs").prop('hidden', false);

                        (function ()
                        {
                            UploadCekLab('#formPenjaminan');

                        })();
                    }else{
                         if (proses == 'update')
                        {
                           alert('Plafon dibawah Rp. 200.000.000,- akan dimasukkan ke pengajuan Automatic Conditional Cover');
                           $("#caseket").val('Tidak');
  
                        }
                        else
                        {
                            $("#pesanPlafon").html('');
                            alert('Untuk pengajuan Case by Case plafon harus diatas Rp. 200.000.000,-');
                            $("#plafon").val('');
                            $("#plafon").focus();
                            
                        }
                       
                    }
                        
                }
                
            } 
        }
    })
}

function CekPlafon1() {

    plafon = $("#plafon1").val();
    level = $("#level1").val();
    pesan = '<br><div class="alert alert-danger alert-dismissable">\n\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Silahkan Lengkapi Dokumen Surat Keterangan Kesehatan yang di buat oleh terjamin dan \n\
     Surat keterangan kesehatan dari Puskesmas/Rumah Sakit terdekat</b></div>';
    pesan1 = '<br><div class="alert alert-danger alert-dismissable">\n\
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 200 Juta akan di proses secara Case By Case, dan rate penjaminan akan di tentukan sesuai resiko, \n\
    Silahkan melengkapi data hasil Surat Pernyataan Kesehatan Dari Terjamin, Surat Keterangan Kesehatan dari Puskesmas/Rumah Sakit Terdekat, dan Surat Keterangan dari Cek Lab , yang menunjukkan Kadar Kolesterol dan Glukosa Terjamin  </b></b></div>';
    $.ajax({
        url: 'validasi/checker.php',
        data:
                'plafon=' + plafon +
                '&level=' + level,
        type: 'POST',
        dataType: 'json',
        success: function (data) {

            if (data.level == 'BPR')
            {
                if (data.plafon > 100000000 && data.plafon <= 300000000)
                {
                    if (data.plafon > 200000000) {
                        $("#caseket1").val('Ya');
                        pesan = '<br><div class="alert alert-danger alert-dismissable">\n\
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 200 Juta akan di proses secara Case By Case, Silahkan Lengkapi Dokumen Surat Keterangan Kesehatan yang di buat oleh tertanggung dan \n\
                     Surat keterangan kesehatan dari Puskesmas/Rumah Sakit terdekat</b></div>';
                    } else {
                        $("#caseket1").val('Tidak');
                    }
                    $("#pesanPlafon1").html(pesan);
                } else if (data.plafon > 300000000)
                {
                    $("#caseket1").val('Ya');
                    $("#pesanPlafon1").html(pesan1);
                } else
                {
                    $("#caseket1").val('Tidak');
                    $("#pesanPlafon1").html('');
                }
            } else if (data.level == 'Bntb')
            {
                if (data.plafon > 500000000)
                {
                    $("#caseket1").val('Ya');
                    pesan = '<br><div class="alert alert-danger alert-dismissable">\n\
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>   <b>Plafon diatas 500jt, akan di proses secara Case By Case dan rate penjaminan akan di tentukan sesuai resiko, \n\
                    Silahkan melengkapi data hasil Cek Lab , yang menunjukkan Kadar Kolesterol dan Glukosa Terjamin  </b></b></div>';
                    $("#pesanPlafon1").html(pesan);
                } else
                {
                    $("#caseket1").val('Tidak');
                    $("#pesanPlafon1").html('');
                }
            }



        }
    })
}


function hitungUmurJatuhTempo() {
    lahir = $("#tglLahir").val();
    tempo = $("#tgljatuhtempo").val();
    idbank = $("#idbank").val();
    umur = $("#tampil").val();
    var tampung = new Array();
    $.ajax({
        url: 'validasi/checker.php',
        data: '  tempo=' + tempo +
                '&lahir=' + lahir +
                '&idbank=' + idbank,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $("#umurjatuhtempo").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');
            $("#umurjatuhtempo1").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');

            if (data.level == 'bntb') 
            {
                if (data.Tahun > 70 && data.Hari>0) {
                    $("#simpan").prop('disabled', true);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 70 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");
                } else {
                    $("#simpan").prop('disabled', false);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");
                }

            } 
            else 
            {
                if (data.Tahun >= 65 && data.Hari>0) 
                {

                    $("#simpan").prop('disabled', true);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 65 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");

                } 
                else 
                {
                    $("#simpan").prop('disabled', false);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");

                }
            }



        }
    })

}

function VaslidasiUmurCase() {
    lahir = $("#tglLahir").val();
    tempo = $("#tgljatuhtempo").val();
    idbank = $("#idbank").val();
    umur = $("#tampil").val();
    var tampung = new Array();
    $.ajax({
        url: 'validasi/checker.php',
        data: '  tempo=' + tempo +
                '&lahir=' + lahir +
                '&idbank=' + idbank,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $("#umurjatuhtempo").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');
            $("#umurjatuhtempo1").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');

            if (data.level == 'bntb') {
                if (data.Tahun > 70 && data.Hari>0) {
                    $("#simpan").prop('disabled', true);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 70 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");
                } else {
                    $("#simpan").prop('disabled', false);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");
                }

            } else {
                     if (data.Tahun >= 65 && data.Hari>0) {

                    $("#simpan").prop('disabled', true);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 65 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");

                } else {
                    $("#simpan").prop('disabled', false);
                    $("#pesanUmurJtauhTempo").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");

                }
            }



        }
    })

}

function hitungUmurJatuhTempo1() {
    lahir = $("#tglLahir1").val();
    tempo = $("#tgljatuhtempo1").val();
    idbank = $("#idbank1").val();
    umur = $("#tampil1").val();
    var tampung = new Array();
    $.ajax({
        url: 'validasi/checker.php',
        data: '  tempo=' + tempo +
                '&lahir=' + lahir +
                '&idbank=' + idbank,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $("#umurjatuhtempo2").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');
            $("#umurjatuhtempo12").prop('value', data.Tahun + ' Tahun,' + data.Bulan + ' Bulan, ' + data.Hari + ' Hari');

            if (data.level == 'bntb') {
                if (data.Tahun > 70 && data.Hari>0) {
                    $("#simpan1").prop('disabled', true);
                    $("#pesanUmurJtauhTempo1").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 70 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");
                } else {
                    $("#simpan1").prop('disabled', false);
                    $("#pesanUmurJtauhTempo1").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");
                }

            } else {
                  if (data.Tahun >= 65 && data.Hari>0) {

                    $("#simpan1").prop('disabled', true);
                    $("#pesanUmurJtauhTempo1").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur lebih dari 65 saat jatuh tempo, Pengajuan tidak dapat di proses</b></b></div>");

                } else {
                    $("#simpan1").prop('disabled', false);
                    $("#pesanUmurJtauhTempo1").html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Umur OK</b></b></div>");

                }
            }



        }
    })

}
  

$(document).ready(function () {
    var date_input = $('input[name="tgljatuhtempo"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })
})

$(document).ready(function () {
    var date_input = $('input[name="tglpk"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })
})

$(document).ready(function () {

    var date_input = $('input[name="tglrealisasi"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    })

})


function FormatCurrency(objNum) {
    var num = objNum.value
    var ent, dec;
    if (num != '' && num != objNum.oldvalue) {
        num = MoneyToNumber(num);
        if (isNaN(num)) {
            objNum.value = (objNum.oldvalue) ? objNum.oldvalue : '';
        } else {
            var ev = (navigator.appName.indexOf('Netscape') != -1) ? Event : event;
            if (ev.keyCode == 190 || !isNaN(num.split('.')[1])) {
                //alert(num.split('.')[1]);
                objNum.value = AddCommas(num.split('.')[0]) + '.' + num.split('.')[1];
            } else {
                objNum.value = AddCommas(num.split('.')[0]);
            }
            objNum.oldvalue = objNum.value;
        }
    }
}
function MoneyToNumber(num) {
    return (num.replace(/,/g, ''));
}
function AddCommas(num) {
    numArr = new String(num).split('').reverse();
    for (i = 3; i < numArr.length; i += 3) {
        numArr[i] += ',';
    }
    return numArr.reverse().join('');
}

function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num)) {
        num = "0";
        sign = (num == (num = Math.abs(num)));
        num = Math.floor(num * 100 + 0.50000000001);
        cents = num0;
        num = Math.floor(num / 100).toString();
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
            num = num.substring(0, num.length - (4 * i + 3)) + '.' +
                    num.substring(num.length - (4 * i + 3));
        return (((sign) ? '' : '-') + num);
    }
}


//Datemask2 mm/dd/yyyy
//Money Euro

//Datemask2 mm/dd/yyyy


$("[data-mask]").inputmask();


function hanyaAngka(e, decimal) {
    var key;
    var keychar;
    if (window.event) {
        key = window.event.keyCode;
    } else
    if (e) {
        key = e.which;
    } else
        return true;

    keychar = String.fromCharCode(key);
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
        return true;
    } else
    if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else
    if (decimal && (keychar == ".")) {
        return true;
    } else
        return false;
}

$('document').ready(function () {

    $('#tglrealisasi').change(function () {
        $("#masaKredit").prop('disabled', false);
//        $("#masaKredit").val('');
//        $("#plafon").prop('value', '');
    });

    $('#tgljatuhtempo').keyup(function () {
        // Keyup function for check the user action in input
//        $("#plafon").prop('value', '');
        realisasi = $("#tglrealisasi").val();
        tempo = $("#tgljatuhtempo").val();
        $.ajax({
            url: 'validasi/checker.php',
            data: 'tempo=' + tempo + '&realisasi=' + realisasi,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                bulan = 0;
                bulan = data.Bulan;
                tahun = data.Tahun;
                hari = data.Hari;
                if (hari > 0) {
                    bulan = bulan + 1;
                }
                totalbulan = bulan + (data.Tahun * 12);

                $("#jenisPenjaminan").prop('hidden', true);
                $("#masaKredit").val(totalbulan);
                $("#masaKredit1").val(totalbulan);


            }
        })
    })

    $('#tgljatuhtempo1').keyup(function () {
        // Keyup function for check the user action in input
//        $("#plafon1").prop('value', '');
        realisasi = $("#tglrealisasi1").val();
        tempo = $("#tgljatuhtempo1").val();
        $.ajax({
            url: 'validasi/checker.php',
            data: 'tempo=' + tempo + '&realisasi=' + realisasi,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $("#jenisPenjaminan1").prop('hidden', true);
                $("#masaKredit2").val(data);
                $("#masaKredit12").val(data);
            }
        })
    })

//    $('#tgljatuhtempo').change(function () {
//        
//      var  realisasi = $("#tglrealisasi").val();
//      var  tempo = $("#tgljatuhtempo").val();
//        
//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });
//        // Keyup function for check the user action in input       
//        $.ajax({
//            url: '/caridata',
//            type: 'POST',
//            data: 'tempo=' + tempo + '&realisasi=' + realisasi,
//            dataType: 'json',
//            success: function (data) {
//                $("#testAjax").val(data);
//            }
//        })
//    })

    $('#plafon').change(function () {
        bulan = $("#masaKredit").val();
        plafon = $("#plafon").val();
        idbank = $("#idbank").val();
//        jeniskredit = $("#jeniskredit").val();
        
         if ($('#radio-konsumtif').is(":checked")) {
             jeniskredit =   $('#radio-konsumtif').val();
        }
         if ($('#radio-produktif').is(":checked")) {
             jeniskredit =   $('#radio-produktif').val();
        }
     
//        alert(jeniskredit)
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "POST",
            url:'PilihJenisPenjaminan',
//            data: 'bulan='+ bulan +
//                  '&plafon='+ plafon +
//                  '&idbank='+ idbank +
//                  '&jeniskredit='+ jeniskredit, 
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
//                alert('halo');
                $("#JenisPnj").remove();
                $("#Jenispilihan").html(data);
            }
        })
    });
 
     
    
    $(document).on('click', '.detailSkimKredit', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
         bulan          = $("#masaKredit").val();
         plafon        = $("#plafon").val();
         idbank       = $("#idbank").val();
         caseket       = $("#caseket").val();
//        jeniskredit = $("#jeniskredit").val();
        
         if ($('#radio-konsumtif').is(":checked")) {
             jeniskredit =   $('#radio-konsumtif').val();
        }
         if ($('#radio-produktif').is(":checked")) {
             jeniskredit =   $('#radio-produktif').val();
        }
     
         if ($('#radio-jiwa').is(":checked")) {
             detailSkim =   $('#radio-jiwa').val();
        }
        
         if ($('#radio-macet').is(":checked")) {  
             detailSkim =   $('#radio-macet').val();    
        }
        
        
         if ($('#radio-phk').is(":checked")) {
             detailSkim =   $('#radio-phk').val();
        }
     
//       UNTUK MENGECEK KONDISI CASE BY CASE
            $.ajax({
                     type: "POST",
                     url:'showPersyaratan', 
                     data: 
                             {  
                                 'detailSkim'   : detailSkim, 
                                 'jeniskredit'   : jeniskredit, 
                                 'idbank'            : idbank,
                                 'plafon'             : plafon 
                             },
                     datatype : "json", 
                     success: function (data) 
                     {
                         console.log(data);
                         const obj = JSON.parse(data); 
                         
                         const id_persyaratan = obj.id;
                         const doc_surat_pernyataan_sehat = obj.doc_surat_pernyataan_sehat;
                         const doc_surat_keterangan_sehat = obj.doc_surat_keterangan_sehat;
                         const doc_cek_lab = obj.doc_cek_lab;
                         const doc_foto_usaha = obj.doc_foto_usaha;
                         const doc_getaran_jantung = obj.doc_getaran_jantung;
                         const doc_ktp = obj.doc_ktp;
                         const doc_persetujuan_kredit = obj.doc_persetujuan_kredit;
                         const doc_slik = obj.doc_slik; 
                         const doc_analisa_kelayakan = obj.doc_analisa_kelayakan;
                         const doc_taksasi = obj.doc_taksasi;
                         const doc_riwayat_kredit = obj.doc_riwayat_kredit;
                         const doc_sk = obj.doc_sk;
                         const max_plafon = obj.max_plafon; 
                         const max_umur = obj.max_umur;
                        
//                         console.log(obj);
                         
                          $('#idPersyaratan').val(id_persyaratan);  
                         
                         if (doc_surat_pernyataan_sehat=="Ya"){ 
                             $('#suratPernyataanSehat').removeClass('hidden');  
                             $('#fileSuratSehat').attr('required',true);  
                         }else{ 
                             $('#suratPernyataanSehat').addClass('hidden');
                              $('#fileSuratSehat').attr('required',false); 
                         }
                         
                         if (doc_surat_keterangan_sehat=="Ya"){ 
                             $('#CekKesehatanRs').removeClass('hidden');
                             $('#fileSuratSehatRs').attr('required',true); 
                         }else {
                             $('#CekKesehatanRs').addClass('hidden');
                             $('#fileSuratSehatRs').attr('required',false);  
                         }
                         if (doc_cek_lab=="Ya"){ 
                             $('#cekLab').removeClass('hidden'); 
                             $('#fileCekLab').attr('required',true);  
                         }else{
                             $('#cekLab').addClass('hidden');
                             $('#fileCekLab').attr('required',false);  
                         }
                         if (doc_getaran_jantung=="Ya"){ 
//                             alert ('getaran jantung');
                             $('#cekGetaranJantung').removeClass('hidden'); 
                             $('#fileGetaranJantung').attr('required',true);  
                         }else{
                             $('#cekGetaranJantung').addClass('hidden');
                              $('#fileGetaranJantung').attr('required',false);  
                         }
                         if (doc_ktp=="Ya"){ 
                             $('#cekKTP').removeClass('hidden') ;
                             $('#fileKtp').attr('required',true);  
                         }else{
                             $('#cekKTP').addClass('hidden');
                             $('#fileKtp').attr('required',false);  
                         }
                         if (doc_foto_usaha=="Ya"){ 
                             $('#cekUsaha').removeClass('hidden') ;
                             $('#fileUsaha').attr('required',true);  
                         }else{
                             $('#cekUsaha').addClass('hidden');
                             $('#fileUsaha').attr('required',false);  
                         }
                         if (doc_slik=="Ya"){
                             $('#cekSlik').removeClass('hidden') 
                             $('#fileSlik').attr('required',true); 
                         }else{
                             $('#cekSlik').addClass('hidden');
                            $('#fileSlik').attr('required',false);  
                         }
                         if (doc_analisa_kelayakan=="Ya"){ 
                             $('#cekAnalisis').removeClass('hidden') ;
                             $('#fileAnalisis').attr('required',true); 
                         }else{
                             $('#cekAnalisis').addClass('hidden');
                             $('#fileAnalisis').attr('required',false);  
                         }
                         if (doc_taksasi=="Ya"){ 
                             $('#cekTaksasi').removeClass('hidden');
                             $('#cekTaksasi').attr('required',true); 
                         }else{
                             $('#cekTaksasi').addClass('hidden')
                            $('#cekTaksasi').attr('required',false);   
                         }
                         
                         if (doc_persetujuan_kredit=="Ya"){
                             $('#cekSuratPersetujuanKredit').removeClass('hidden') ;
                             $('#fileSuratPersetujuanKredit').attr('required',true);  
                         }else{
                             $('#cekSuratPersetujuanKredit').addClass('hidden');
                               $('#fileSuratPersetujuanKredit').attr('required',false);  
                         }
            
                         if (doc_riwayat_kredit=="Ya"){ 
                             $('#cekDocRiwayatKredit').removeClass('hidden') ;
                             $('#fileDocRiwayatKredit').attr('required',true);  
                         }else{
                               $('#cekDocRiwayatKredit').addClass('hidden');
                               $('#fileDocRiwayatKredit').attr('required',false);  
                         }
                         if (doc_sk=="Ya"){ 
                             $('#cekDocSk').removeClass('hidden') ;
                             $('#fileSk').attr('required',true);  
                         }else{
                              $('#cekDocSk').addClass('hidden') ;
                             $('#fileSk').attr('required',false);   
                         }
                        $('#caseket').val(obj.case_ket);
//                        console.log(obj);
//                                   $("#JenisPnj").remove();
//                                  $("#Jenispilihan").html(data);
                     }
                 })

     //       UNTUK MENAMPILKAN DATA DETAIL PENJAMINAN
        $.ajax({
            type: "POST",
            url:'ShowDetailPenjaminan',
//            data: 'bulan='+ bulan +
//                  '&plafon='+ plafon +
//                  '&idbank='+ idbank +
//                  '&jeniskredit='+ jeniskredit, 
            data: 
                    {
                        'bulan': bulan ,
                        'plafon': plafon ,
                        'idbank': idbank ,
                        'jeniskredit':jeniskredit,
                        'detailSkim':detailSkim
                    },
            dataType: 'html',
            success: function (data) 
            {
                $("#JenisPnj").remove();
                $("#Jenispilihan").html(data);
            }
        })
        
    });
    


    // 
    $('#radio-pengusaha').change(function () 
    {
//        var data = $('#radio-pengusaha').val();
//        var data = $( "input[name='pekerjaan']" ).val();
//        alert(data);
          $("#detailPekerjaan").html('Mohon untuk menjelaskan deskripsi singkat tentang Jenis Usaha (Usaha Dangang, Usaha Tani,  Usaha Perikanan, Usaha Peternakan, dll)');

    });
    $('#radio-karyawan').change(function () 
    {
//        var data = $( "input[name='pekerjaan']" ).val();
//        alert(data);
        $("#detailPekerjaan").html('Mohon untuk menjelaskan deskripsi singkat tentang Pekerjaan (ASN, TNI, POLRI, DOKTER, DLL)');

    });
    
    //untuk mengambil salah satu rate menggunakan json
    $('#jeniskredit').change(function () 
    {
//        var jeniskredit = $('#jeniskredit').val();
//        $("#plafon").val('');

       if ($('#radio-karyawan').is(":checked")) {
             pekerjaan =   $('#radio-karyawan').val();
        }
         if ($('#radio-pengusaha').is(":checked")) {
             pekerjaan =   $('#radio-pengusaha').val();
        }

        if (pekerjaan == 'PENGUSAHA') {
            $("#detailPekerjaan").html('Mohon untuk menjelaskan deskripsi singkat tentang Jenis Usaha (Usaha Dangang, Usaha Tani,  Usaha Perikanan, Usaha Peternakan, dll)');
        } else {
            $("#detailPekerjaan").html('Mohon untuk menjelaskan deskripsi singkat tentang Pekerjaan (ASN, TNI, POLRI, DOKTER, DLL)');
        }
    });

    $('#jeniskredit1').change(function () {
        var jeniskredit = $('#jeniskredit').val();
//        $("#plafon1").val('');

        if (jeniskredit == 'PRODUKTIF') {
            $("#detailPekerjaan1").html('Jenis Usaha');
        } else {
            $("#detailPekerjaan1").html('Detail Pekerjaan');
        }
    });

    $('#plafon').change(function () {
        bulan = $("#masaKredit").val();
        plafon = $("#plafon").val();
        idbank = $("#idbank").val();
        var tampung = new Array();
        $.ajax({

            url: 'validasi/checker.php',
            data: 'premi=' + bulan + '&jumlahUang=' + plafon + '&idbank=' + idbank,
            type: 'POST',
            dataType: 'json',
            success: function (data) {

                for (var i = 0; i < data.length; i++) {
                    tampung[i] = data[i].namarate;
                }
                $("#premi").prop('value', tampung);
            }
        })
    });

    $('#plafon1').change(function () {
        bulan = $("#masaKredit2").val();
        plafon = $("#plafon1").val();
        idbank = $("#idbank1").val();
        jeniskredit = $("#jeniskredit1").val();
        $.ajax({
            url: 'validasi/checker.php',
            data: 'cekrate=' + bulan +
                    '&jumlahUang=' + plafon +
                    '&idbank=' + idbank +
                    '&jeniskredit=' + jeniskredit,
            type: 'POST',
            dataType: 'html',
            success: function (data, data1) {
                $("#JenisPnj1").remove();
                $("#Jenispilihan1").html(data);
            }
        })
    });


    $("#pilihbank").select2({
        placeholder: 'Sillahkan Pilih Nama Bank',
//        allowClear: true, 
        width: '100%'
    });
    $("#kd_kas").select2({
        placeholder: 'Silahkan Pilih Master Kas',
        allowClear: true,
        width: '100%'
    });



    $(document).ready(function () {
        $('#tabelSetuju').DataTable({
//           "scrollY": 450,
//           "scrollX": true,
            "pagingType": "simple",
            stateSave: true,
        });

    });

    $(document).ready(function () {
        $('.tabel').DataTable({
//           "scrollY": 450,
//           "scrollX": true,
            "pagingType": "full",//simple, full_numbers, simple_numbers or full
            stateSave: true,
        });

    });

    $(document).ready(function () {
        $('#tabelpembayaran').DataTable({
//           "scrollY": 450,
//           "scrollX": true,
            "pagingType": "simple",
            stateSave: true,

        });

    });
    $(document).ready(function () {
        $('#tabelpenjaminan').DataTable({
//           "scrollY": 450,
            "scrollX": true,
            "pagingType": "simple",
            stateSave: true,

        });

    });

    $(document).ready(function () {
        $('#tabelcasebycase').DataTable({
            stateSave: true,

        });
    });

    $(document).ready(function () {
        $('#tabelsudahbayar').DataTable({
            fixedHeader: {
                header: true,
                footer: true
            },
            stateSave: true,
            "scrollX": true,
        });
    });



    //Untuk menampilkan data di form validasi pada halaman admin

})

