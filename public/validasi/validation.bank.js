$(document).on('click', '.updatebank', function () {
    var id = $(this).attr("id");

    $.ajax({
        url: "fetchdatabank",
        method: 'get',
        data: 'id= ' + id,
        dataType: 'json',
        success: function (data)
        {
           $('#idbank').val(id);
           $('#name').val(data.namabank);
           $('#kodecabang').val(data.kodecabang);
           $('#alamat').val(data.alamat);
           $('#telp').val(data.telp);
           $('#dis').val(data.dis);
           $('#admin').val(data.admin);
           $('#materai').val(data.materai);
           $('#share').val(data.share);
           $('#minijp').val(data.minijp);
           $('#action').val('update');
        }
    })
});