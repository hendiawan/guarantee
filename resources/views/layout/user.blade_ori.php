<!DOCTYPE html>
<html>
    <head>
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
        <script type="text/javascript" src="{{URL::asset('../js/moment.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/moment-with-locales.js')}}"></script>
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
                 <a class="navbar-brand" href="#">Sistem Pengajuan Penjaminan</a>
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
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                                 
                            <ul class="dropdown-menu">                                    
                                <li><a href="/"><i class="glyphicon glyphicon-log-out"></i>Notifikasi</a></a></li> 
                            </ul>
                        </li>
                        <li><a href="/bpr"><span class="glyphicon glyphicon-home"></span> HOME</a></li>                                                 
                        @if(Session::get('level')!='User')
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                               <b>INPUT</b> <span class="caret"></span></a>
                            <ul class="dropdown-menu">   
                                <li><a href="penjaminanAdd"><i class="glyphicon glyphicon-log-out"></i>PENJAMINAN BARU</a></a></li> 
                                <li><a href="inputpenjaminanperpanjangan"><i class="glyphicon glyphicon-log-out"></i>PENJAMINAN KOMPENSASI</a></a></li> 
                                <li><a href="importexport"><i class="glyphicon glyphicon-log-out"></i>FILE EXCEL</a></a></li> 
                                <li><a href="inputcase"><i class="glyphicon glyphicon-log-out"></i>CASE BY CASE</a></a></li> 
                            </ul>
                        </li>
                        @endif 
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                               <b>DATA</b> <span class="caret"></span></a>

                            <ul class="dropdown-menu">                                    
                                <li><a href="sertifikatuser" ><i class="glyphicon glyphicon-log-out"></i>SERTIFIKAT</a></a></li> 
                                <li><a href="ratebank" ><i class="glyphicon glyphicon-log-out"></i>RATE</a></a></li> 
                              
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">          
                                <span class="glyphicon glyphicon-user"></span>  <b>{{ strtoupper(Session::get('name')) }}</b> <span class="caret"></span></a>

                            <ul class="dropdown-menu">                                    
                                <li><a href="changepass"></i>CHANGE PASS</a></a></li> 
                                <li><a href="logout"><i class="glyphicon glyphicon-log-out"></i><b>Logout</b></a></a></li> 
                            </ul>
                        </li>
                    </ul>
                </div>               
            </nav> 
            <br>
            <br>
            <br>
            
            <nav class="container-fluid"   style="background-color:whitesmoke">
                <div class="container-fluid">
                    <section class="content-header">
                        <img  src="{{URL::asset('img/jamkrida.png')}}"class="img-responsive" width='11%'  alt="User Image">
                    </section>    
                </div>
                <!-- Content Header (Page header) -->
               
<!--                <p>Level :<b>{{strtoupper(Session::get('level')) }}</b></p>-->
 @yield('content')
            </nav>
        </header>

       
        <footer>
            <p>
                &copy PT. Jamkrida NTB Bersaing 2018
            </p>
        </footer>
    </body>
</html>

<script type="text/javascript" src="{{URL::asset('validasi/penjaminan.controller.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('validasi/validation.upload.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('validasi/validation.click.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('validasi/validation.controller.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('validasi/validation.datatable.js')}}"></script>
