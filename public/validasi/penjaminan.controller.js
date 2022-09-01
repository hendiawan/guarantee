        
var app = angular.module('Penjaminan', ['datatables', 'ngRoute']);
app.controller('PenjaminanController', function ($scope, $http) {
    $scope.success = false;
    $scope.error = false;

    $scope.fetchDataPenjaminan = function () {
        $http.get('validasi/datapenjaminan/fetch_data.php').success(function (data) {
            $scope.DataPenjaminan = data;
        });
    };
    $scope.openModalPenjaminan = function () {
        var modal_popup = angular.element('#modalPenjaminan');
        modal_popup.modal('show');
    };
    $scope.closeModal = function () {
        var modal_popup = angular.element('#crudmodal');
        modal_popup.modal('hide');
    };
    $scope.addDataPenjaminan = function () {
        window.location.href = '/penjaminan';

    };

    $scope.addDataPenjaminanUser = function () {
        window.location.href = '/penjaminanAdd';

    };

    $scope.Export = function () {
        window.location.href = '/exportpenjaminan';
    };
    $scope.Import = function () {
        window.location.href = '/importexport';
    };


    $scope.submitForm = function () {
        $http({
            method: "POST",
            url: "validasi/test/insert.php",
            data: {'first_name': $scope.first_name, 'last_name': $scope.last_name, 'action': $scope.submit_button, 'id': $scope.hidden_id}
        }).success(function (data) {
            if (data.error != '')
            {
                $scope.success = false;
                $scope.error = true;
                $scope.errorMessage = data.error;
            } else
            {
                $scope.success = true;
                $scope.error = false;
                $scope.successMessage = data.message;
                $scope.form_data = {};
                $scope.closeModal();
                $scope.fetchData();
            }
        });
    };
    $scope.fetchSingleDataPenjaminan = function (id) {
        $http({

            method: "POST",
            url: "validasi/datapenjaminan/insert.php",
            data: {'id': id, 'action': 'fetch_single_data_penjaminan'}
        }).success(function (data) {
            $scope.ktp = data.ktp;
            $scope.nama = data.nama;
            $scope.tgllahir = data.tgllahir;
            $scope.umur = data.umur;
            $scope.pekerjaan = data.pekerjaan;
            $scope.jeniskredit = data.jeniskredit;
            $scope.alamat = data.alamat;
            $scope.tglrealisasi = data.tglrealisasi;
            $scope.tgljatuhtempo = data.tgljatuhtempo;
            $scope.umurjatuhtempo = data.umurjatuhtempo;
            $scope.nopk = data.nopk;
            $scope.tglpk = data.tglpk;
            $scope.plafon = data.plafon;
            $scope.jenispenjaminan = data.jenispenjaminan;
            $scope.masakredit = data.masakredit;

            $scope.hidden_id = id;
            $scope.modalTitle = 'Edit Data Pengajuan Penjaminan';
            $scope.submit_button = 'Edit';
            $scope.openModalPenjaminan();
        });
    };
    $scope.deleteDataPenjaminan = function (id) {
        if (confirm("Apakah anda yakin untuk reject pengajuan ini?"))
        {
            $http({
                method: "POST",
                url: "validasi/datapenjaminan/insert.php",
                data: {'id': id, 'action': 'Delete'}
            }).success(function (data) {
                window.location.href = '/bpr';
            });
        }
    };

    var number = 1;
    $scope.count = function () {
        return number++;
    }

     

});
