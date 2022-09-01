@extends('layout.admin')
@section('content')
<button type="button" name="add_button" ng-click="addDataRate()" class="btn btn-primary">DATA RATE</button>

<body ng-app="Rate" ng-controller="RateController">

    <div  class="container" ng-init="fetchDataRate()">
        <br />
        <h3 align="center">Data Rate BPR PT. Jamkrida NTB Bersaing</h3>
        <br />
        <div class="alert alert-success alert-dismissible" ng-show="successRate" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            @{{successMessageRate}}
        </div>           
        <br />
        <div class="table-responsive" style="overflow-x: unset;">

            <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bank</th>
                        <th>Nama Rate</th>                        
                        <th>Dari</th>
                        <th>Sampai</th>
                        <th>Rate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-init='id = count()' ng-repeat="name in tampilDataRate">                        
                        <td>@{{id}}</td>
                        <td>@{{name.namabank}}</td>
                        <td>@{{name.namarate}}</td>
                        <td>@{{name.dari}}</td>
                        <td>@{{name.sampai}}</td>
                        <td>@{{name.rate}}</td>
                        <td><button type="button" ng-click="fetchSingleDataRate(name.idrate)" class="btn btn-warning btn-xs">Edit</button></td>
                        <td><button type="button" ng-click="deleteDataRate(name.idrate)" class="btn btn-danger btn-xs">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>   
<br>
<br>
@endsection


<div class="modal fade" tabindex="-1" role="dialog" id="modalRate">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <form method="post" ng-submit="FormSimpanDataRate()">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@{{modalTitle}}</h4>
                </div>
                <div class="modal-body" (onClose)="select.clear()">                    
                    <div ng-hide="hiddennamabank" class=" form-group">
                        <label>Nama Bank</label><br>
                        <input class="form-control" disabled=""   ng-model="namaBank">
                    </div>

                    <div ng-hide="hiddenidbank" class=" form-group">
                        <label>Kode Bank</label><br>
                        <select   name="idbank"  ng-model="idbank" id="idproduk" class="form-control">
                            <option value="" >Pilih Bank</option>                       
                            <?php
                            $i = 1;
                            ?>
                            @foreach($bank as $data)                              
                            <option   value="  {{ $data - > idbank}}"> {{ $i." - ".$data - > namabank}}</option>   
                            <?php $i++ ?>
                            @endforeach                     
                        </select>    
                    </div>
                    <div class="form-group">
                        <label>Nama Rate</label>
                        <input class="form-control" id="namarate" ng-model="namarate" name="namarate" placeholder="Nama Produk" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Dari [Bulan]</label>
                        <input class="form-control" id="dari" ng-model="dari" name="dari" placeholder="Dari" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Sampai [Bulan]</label>
                        <input class="form-control" id="sampai" ng-model="sampai" name="sampai" placeholder="sampai" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Rate</label>
                        <input class="form-control" id="rate" ng-model="rate" name="rate" placeholder="rate" type="text" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" value="@{{hidden_id}}" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="@{{submit_button}}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

