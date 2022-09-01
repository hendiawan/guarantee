function ValidateFileImportExcel(formData, jqForm, options) {
    var form = jqForm[0];
    var inputFile = document.getElementById('poster');
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.xls|\.xlsx)$/i;

    if (!form.file.value) {
        alert('Harap Pilih File Terlebih Dahulu');
        return false;
    } else {

        if (!ekstensiOk.exec(pathFile)) {
            alert('Silakan upload file yang memiliki ekstensi .xls atau .xlsx');
            inputFile.value = '';
            return false;
        }

        var file_size = $('#poster')[0].files[0].size;
        var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

        if (file_size > maxsize) {


            alert('Silakan upload file dengan ukuran lebih kecil dari 50 Kb');
            inputFile.value = '';
            return false;
        }
    }
}

function validatePembayaran(formData, jqForm, options) {
    var form = jqForm[0];

    var inputFile = document.getElementById('poster');
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;


    if (!form.filePembayaran.value||!form.totalbayar.value) {
        alert('Harap Pilih File Pembayaran ');
        return false;
    } else {

        if (!ekstensiOk.exec(pathFile)) {
            alert('Silakan upload file yang memiliki ekstensi .pdf atau .jpg');
            inputFile.value = '';
            return false;
        }

        var file_size = $('#poster')[0].files[0].size;
        var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

        if (file_size > maxsize) {
            alert('Ukuran File Max 700 Kb');
            inputFile.value = '';
            return false;
        }
    }

}

function validateupload(formData, jqForm, options) {
    var form = jqForm[0];
    var inputFileUpload = document.getElementById('fileUpload');
    var pathFileUpload = inputFileUpload.value;
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;


    if (!form.fileUpload.value) {
        alert('Harap pilih file yang di upload terlebih dahulu');
        return false;
    } else {

        if (!ekstensiOk.exec(pathFileUpload)) {
            alert('Silakan upload file yang memiliki ekstensi .pdf atau .jpg');
            inputFileUpload.value = '';
            return false;
        }

        var file_size = $('#fileUpload')[0].files[0].size;
        var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

        if (file_size > maxsize) {
            alert('Ukuran File Max 700 Kb');
            inputFileUpload.value = '';
            return false;
        }
    }
}

function validateuploadScanLab(formData, jqForm, options) {
    var form = jqForm[0];
    var inputFileUploadScanLab = document.getElementById('fileUploadScanLab');
    var pathFileUpload = inputFileUploadScanLab.value;
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;


    if (!form.fileUploadScanLab.value) {
        alert('Harap pilih file Scan Lab yang di upload terlebih dahulu');
        return false;
    } else {

        if (!ekstensiOk.exec(pathFileUpload)) {
            alert('Silakan upload file yang memiliki ekstensi .pdf atau .jpg');
            inputFileUploadScanLab.value = '';
            return false;
        }

        var file_size = $('#fileUploadScanLab')[0].files[0].size;
        var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

        if (file_size > maxsize) {

            alert('Ukuran File Max 700 Kb');
            inputFileUploadScanLab.value = '';
            return false;
        }
    }
}


function validateuploadRs(formData, jqForm, options) {
    var form = jqForm[0];
    var inputFileUploadRs = document.getElementById('fileUploadRs');
    var pathFileUploadRs = inputFileUploadRs.value;
    var ekstensiOk = /(\.pdf|\.PDF|\.jpg|\.JPG|\.jpeg|\.JPEG)$/i;


    if (!form.fileUploadRs.value) {
        alert('Harap pilih file Surat Keterangan Kesehatan Dari Rumah Sakit');
        return false;
    } else {

        if (!ekstensiOk.exec(pathFileUploadRs)) {
            alert('Silakan upload file yang memiliki ekstensi .pdf atau .jpg');
            inputFileUploadRs.value = '';
            return false;
        }

        var file_size = $('#fileUploadRs')[0].files[0].size;
        var maxsize = 1024 * 700; // maksimal 200 KB (1KB = 1024 Byte)

        if (file_size > maxsize) {

            alert('Ukuran File Max 700 Kb');
            inputFileUploadRs.value = '';
            return false;
        }
    }
}

(function () {

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('#form').ajaxForm({
        beforeSubmit: ValidateFileImportExcel,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            window.location.href = "/bpr";
        },

        error: function () {
            var percentVal = '<b style="Color:red">Format Excel Tidak Sesuai !!!</b>';
            bar.width(percentVal);
            percent.html(percentVal);
            

        },
    });
    $('#formadmin').ajaxForm({
        beforeSubmit: ValidateFileImportExcel,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            window.location.href = "/datapenjaminanview";
        },

        error: function () {
            var percentVal = '<b style="Color:red">Format Excel Tidak Sesuai !!!</b>';
            bar.width(percentVal);
            percent.html(percentVal);
            

        },
    });
    
    
    //validasi form upload file pembayaran
    $('#formPembayaran').ajaxForm({
        beforeSubmit: validatePembayaran,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=filePembayaran]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $('#prosesbayar').attr('disabled',true);
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
            $('#customLoad').show();
            
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            $('#customLoad').hide();
            status.html(xhr.responseText);
            alert('Bukti pembayaran berhasil di upload');
            window.location.href = "/bpr";
        },

        error: function () {
            var percentVal = '<b style="Color:red">.....</b>';
            bar.width(percentVal);
            percent.html(percentVal);
            window.location.href = "/bpr";

        },
    });
    //validasi form upload file pembayaran
    $('#formPembayaranUlang').ajaxForm({
        beforeSubmit: validatePembayaran,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=filePembayaran]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            alert('Bukti pembayaran telah di upload');
            location.reload();
        },

        error: function () {
            var percentVal = '<b style="Color:red">.....</b>';
            bar.width(percentVal);
            percent.html(percentVal);
            window.location.href = "/bpr";

        },
    });
    //validasi form upload file surat sehat dari terjamin
    $('#formUpload').ajaxForm({
        beforeSubmit: validateupload,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=inputFileUpload]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            alert('File berhasil di upload');
            location.reload();
        },

        error: function () {
            var percentVal = '<b style="Color:red">!!!!!</b>';
            bar.width(percentVal);
            percent.html(percentVal);

        },
    }); 
    //validasi form upload file scan lab
    $('#formUploadScanLab').ajaxForm({
        beforeSubmit: validateuploadScanLab,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=inputFileUploadScanLab]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            alert('File berhasil di upload');
            location.reload();
        },

        error: function () {
            var percentVal = '<b style="Color:red">!!!!!</b>';
            bar.width(percentVal);
            percent.html(percentVal);

        },
    });
    //validasi form upload file surat sehat dari rumah sakit
    $('#formUploadRs').ajaxForm({
        
        beforeSubmit: validateuploadRs,
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=fileUploadRs]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '<b>Succes, Saving</b>';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            status.html(xhr.responseText);
            alert('File berhasil di upload');
            location.reload();
        },

        error: function () {
            var percentVal = '<b style="Color:red">!!!!!</b>';
            bar.width(percentVal);
            percent.html(percentVal);

        },
    });
    
})();




 