// $(document).ready(function () {
//
//        var Table = $('#tabel-test').DataTable({
//
//            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
//                    "<'row'<'col-xs-12't>>" +
//                    "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "testdatatable",
//                data: function (d) {
//                    d.nama = $('input[name=nama]').val();
//                }
//            },
//            columns: [
//                {data: 'tglpengajuan'}, 
//                {data: 'nama'},
//                {data: 'umur'},
//                {data: 'jeniskredit'},
//                {data: 'plafon'},
////                {
////                : 'action', orderable: false, searchable: false}
//            ]
//        });
//
//        $('#search-form').on('submit', function (e) {
//            Table.draw();
//            e.preventDefault();
//        });
//
//       
//
//
//    })


