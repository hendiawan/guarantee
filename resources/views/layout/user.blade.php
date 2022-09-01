<!DOCTYPE html>
<html>
      <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>        
        <script src="{{URL::asset('js/select2/select2.js')}}"></script>
        <script src="{{URL::asset('js/select2/select2.min.js')}}"></script>
        <script src="{{URL::asset('js/angular.min.js')}}"></script>
        <script src="{{URL::asset('js/angular-route.js')}}"></script>
<!--		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>-->
        <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('js/angular-datatables.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
         <link rel="stylesheet" href="{{URL::asset('../css/icheck-bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/icheck-bootstrap.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/select2.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/bootstrap-glyphicons.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/datatables.bootstrap.css')}}">
        <link rel="stylesheet" href="{{URL::asset('../css/custom.css')}}">
<!--        <link rel="stylesheet" type="text/css" href="{{URL::asset('/css/style.css') }}"/>-->
        <script type="text/javascript" src="{{URL::asset('../js/bootstrap-datepicker.min.js')}}"></script>
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker3.css')}}"/>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.extensions.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.date.extensions.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/jquery-form.js')}}"></script>
        <meta name="csrf-token" content="{{csrf_token()}}" />
    </head>
    <body>
        <div id="customLoad">
            <div class="spinner"></div>
            <strong>MOHON TUNGGU...</strong>
            <div class="loadInfo">proses update data sedang berlangsung</div>
        </div>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">  
                <a style="margin-left: 100px;margin-bottom: 10px;"  class="navbar-brand" href="#">
                               <img alt="Brand" class="pull-left"  width="25%" src=" {{URL::asset('img/jamkrida.png')}}">
                         </a>
                 
                 <div class="container">
                           
<!--                 <a class="navbar-brand" href="#">Sistem Pengajuan Penjaminans</a>-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    </center>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        
<!--                        <li>
                            <form  >
                                <input style="width: 130px; margin-top: 10px;border-top-left-radius: 20px;border-bottom-right-radius: 20px;" class="form-control" type="search" placeholder="Cari" aria-label="Cari">
                                <button style="height: 100%;margin-top: -69px;margin-left: 95px" class="btn btn-success " type="submit">Cari</button>
                            </form>
                        </li>-->
                       
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">     
                            <ul class="dropdown-menu">                                    
                                <li><a href="/"><i class="glyphicon glyphicon-log-out"></i>Notifikasi</a></a></li> 
                            </ul>
                        </li>
                        <li style="margin-top: 8px"><a href="/bpr"></span><b> Home</b></a></li>                                                 
                        @if(Session::get('level')!='User')
                       <li style="margin-top: 8px" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                             <b>Input</b></a>
                            <ul class="dropdown-menu">   
                                @if((session::get('idbank')=='45')||(session::get('idbank')=='46'))<!--idbank sumbawa barat pusat--> 
                                <li><a href="penjaminanProduktif"><i class="glyphicon glyphicon-plus-sign"></i> Penjaminan Produktif</a></a></li> 
                                <li><a href="penjaminanKonsumtif"><i class="glyphicon glyphicon-plus-sign"></i> Penjaminan Konsumtif</a></a></li> 
                                @else
                                 <li><a href="penjaminanAdd"><i class="glyphicon glyphicon-plus-sign"></i> Penjaminan baru</a></a></li> 
                                 <li><a href="inputcase"><i class="glyphicon glyphicon-plus-sign"></i> Case by case</a></a></li> 
                                 @endif
                                <!--<li><a href="inputpenjaminanperpanjangan"><i class="glyphicon glyphicon-plus-sign"></i> Penjaminan kompensasi</a></a></li>--> 
                                <li><a href="importexport"><i class="glyphicon glyphicon-plus-sign"></i> Input file excel</a></a></li>  
                                <!--<li><a href="inputGrace"><i class="glyphicon glyphicon-plus-sign"></i> Grace Periode</a></a></li>--> 
                            </ul>
                        </li>
                        @endif 
                    <li style="margin-top: 8px"  class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                           <b>Data</b></a>
                            <ul class="dropdown-menu">                                    
                                <li><a href="sertifikatuser" ><i class="glyphicon glyphicon-print"></i> Cetak sertifikat</a></a></li> 
                                <li><a href="ratebank" ><i class="glyphicon glyphicon-hdd"></i> Rate</a></a></li> 
                            </ul>
                    </li>
                    <li style="margin-top: 8px" class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                          <!--<span class="glyphicon glyphicon-off"></span>  <b>-->
                              {{ strtoupper(Session::get('name')) }}</b> <span class="caret"></span></a> 
                      <ul class="dropdown-menu">                                    
                          <li><a href="changepass"></i>CHANGE PASS</a></a></li> 
                          <li><a href="logout"><i class="glyphicon glyphicon-log-out"></i><b>Logout</b></a></a></li> 
                      </ul>
                  </li>
                    </ul>
                </div>               
                </div>               
            </nav>    
             <br>
        </header>
        <div style="margin-top: 70px" class="container-fluid">
                        @yield('content')
        </div>
        <footer style="margin:10px"> 
            <p>
               <b> Powered by : </b>
            </p>
            <div id="topBarMain">
                <div class="pad20">
                    <a class="logoMain" href="https://bsre.bssn.go.id" target="_blank">
                        <img class="image img-responsive" size="50%"  src= "img/logo-bsre1.png">
                    </a>
                    <p align="right" class="address"><strong>   &copy PT. JAMKRIDA NTB BERSAING</strong><br>Ruko Bung Karno Jaya No. 11, Jl Bung Karno (Sayung) Cilinaya -  Mataram- Nusa Tenggara Barat<br>
                        Tlp.: (0370) 639304, 639305</p>
                </div>
            </div>
        </footer>
    </body>
</html>

<script type="text/javascript"  src="{{URL::asset('validasi/penjaminan.controller.js')}}"></script>
<script type="text/javascript"  src="{{URL::asset('validasi/rate.controller.js')}}"></script>
<script type="text/javascript"  src="{{URL::asset('validasi/test.controller.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('validasi/validation.upload.js')}}"></script>
<script type="text/javascript"  src="{{URL::asset('validasi/validation.click.js')}}"></script>
<script type="text/javascript"  src="{{URL::asset('validasi/validation.controller.js')}}"></script>
<script type="text/javascript"  src="{{URL::asset('validasi/validation.bank.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('validasi/validation.datatable.js')}}"></script>
