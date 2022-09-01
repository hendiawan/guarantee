           
var rate = angular.module('Rate', ['datatables', 'ngRoute']);
rate.controller('RateController', function ($scope, $http) {

    $scope.successRate = false;
    $scope.error = false;
    $scope.hiddenidbank = false;
    $scope.hiddennamabank = true;


    $scope.fetchDataRate = function () {
        $http.get('validasi/penjaminan/fetch_data.php').success(function (data) {
            $scope.tampilDataRate = data;
          
        });
    };

    $scope.closeModalRate = function () {
        var modal_popup = angular.element('#modalRate');
        modal_popup.modal('hide');
    };

    $scope.openModalRate = function () {
        var modal_popup = angular.element('#modalRate');
        modal_popup.modal('show');

    };


    $scope.addDataRate = function () {
       
        $('#pilihbank').val(null).trigger('change');
        $scope.modalTitle = 'Add Data Rate';
        $scope.submit_button = 'Insert';
        $scope.openModalRate();       
        $scope.namarate = "";
        $scope.dari = "";
        $scope.sampai = "";
        $scope.rate = "";
        $scope.hiddenidbank = false;
        $scope.hiddennamabank = true;
       
//        $('#pilihbank').attr("required", "true");


    };

    $scope.FormSimpanDataRate = function () {
        $http({
            method: "POST",
            url: "validasi/penjaminan/insert.php",
            data: 
                 {
                    'idbank': $scope.idbank, 
                    'namarate': $scope.namarate, 
                    'kategori': $scope.kategori, 
                    'jeniskategori': $scope.jeniskategori, 
                    'dari': $scope.dari, 
                    'sampai': $scope.sampai, 
                    'rate': $scope.rate, 
                    'action': $scope.submit_button, 
                    'id': $scope.hidden_id
                }
        }).success(function (data) {
            if (data.error != '')
            {
                $scope.successRate = false;
                $scope.error = true;
                $scope.successMessageRate = data.error;
            } else
            {
                $scope.successRate = true;
                $scope.error = false;
                $scope.successMessageRate = data.message;
                $scope.form_data = {};
               
                $scope.closeModalRate();
                $scope.fetchDataRate();
            }
        });
    };
    $scope.fetchSingleDataRate = function (id) {
        $http({
            method: "POST",
            url: "validasi/penjaminan/insert.php",
            data: {'id': id, 'action': 'fetch_single_data_rate'}
        }).success(function (data) {
          
            $scope.idbank = data.idbank;
            $scope.namaBank = data.namabank;
            $scope.namarate = data.namarate;
            $scope.dari = data.dari;
            $scope.sampai = data.sampai;
            $scope.rate = data.rate;
            $scope.hidden_id = id;
            $scope.modalTitle = 'Edit Rate';
            $scope.submit_button = 'Edit';
            $scope.hiddenidbank = true;
            $scope.hiddennamabank = false;
//            $("#pilihbank").select2("val",data.idbank);
            $scope.openModalRate();
        });
    };

    $scope.deleteDataRate = function (id) {
        if (confirm("Are you sure you want to remove it?"))
        {
            $http({
                method: "POST",
                url: "validasi/penjaminan/insert.php",
                data: {'id': id, 'action': 'Delete'}
            }).success(function (data) {
                $scope.successRate = true;
                $scope.error = false;
                $scope.successMessageRate = data.message;
                $scope.fetchDataRate();             
                window.location.href='/rate';
            });
        }
    };

    var number = 1;
    $scope.count = function () {
        return number++;
    }


});

