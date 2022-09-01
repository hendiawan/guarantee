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
        <script type="text/javascript" src="{{URL::asset('../js/bootstrap-datepicker.min.js')}}"></script>
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker3.css')}}"/>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.extensions.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/inputmask/jquery.inputmask.date.extensions.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('../js/jquery-form.js')}}"></script>
        <meta name="csrf-token" content="{{csrf_token()}}" />
    </head>
    <body>
         <header>

            <nav class="navbar navbar-default">                
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <center><a referrerpolicy="no-referrer" type="media_type" class="navbar-collapse"  style="color: white">Sistem Pengajuan Penjaminan Kredit PT. Jamkrida NTB Bersaing</a>
                    </center>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{url('/datapenjaminanview')}}"> <span class="glyphicon glyphicon-home"></span> HOME</a></li>                                                  
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">DATA</b>
                             <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu">                                    
                                 <li><a href="{{url('bank')}}">DATA BANK</a></li>
                                 <li><a href="{{url('rate')}}">DATA RATE</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">UTILITY</b>
                             <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu">                                    
                                 <li><a href="{{url('verifysert')}}">VERIFY SERTIFIKAT</a></li>
                                 <li><a href="{{url('sertifikat')}}">CETAK SERTIFIKAT</a></li>
                                 <li><a href="{{url('ubahdata')}}">PERUBAHAN DATA</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">AKUN :<b> {{strtoupper(Session::get('name'))}}</b>
                                <span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
                            <ul class="dropdown-menu right">                                    
                                <li><a href="{{url('/register')}}">REGISTER USER</a></a></li> 
                                <li><a href="{{url('/registerbank')}}">REGISTER BANK</a></a></li> 
                                <li><a href="{{url('/logout')}}"><i class="glyphicon glyphicon-log-out"></i><b>Logout</b></a></a></li> 
                            </ul>
                        </li>
                    </ul>
                </div>               
            </nav>
            
            <nav class="container-fluid"   style="background-color:whitesmoke">
                <div class="container-fluid">
                    <section class="content-header">
                        <img  src="{{URL::asset('img/JAMKRIDA.png')}}"class="img-responsive" width='11%'  alt="User Image">
<!--                        <p style="margin-left: 27px; color: #2a6592"><b>[LEVEL USER :</b><b>{{strtoupper(Session::get('level'))  }}]</b></p>            -->

                    </section>
                    <!-- Content Header (Page header) -->
                    @if (Session::has('message'))
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('message') }}
                    </div>
                    @endif
            </nav>
        </header>

        <div class="container">
            <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">VERIFIKASI SERTIFIKAT</h2>
                   
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <div id="QR-Code">
                            
                                <div class="panel-heading">
                                     
                                    <div class="navbar-form navbar-right">
                                        <select class="form-control" id="camera-select"></select>
                                        <div class="form-group">
                                            <input id="image-url" type="text" class="form-control" placeholder="Image url">
                                            <button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
                                            <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
                                            <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-play"></span></button>
                                            <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-pause"></span></button>
                                            <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-stop"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div class="col-md-6">
                                        <div class="well" style="position: relative;display: inline-block;">
                                            <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                                        </div>
                                        <div class="well" style="width: 100%;">
                                            <label id="zoom-value" width="100">Zoom: 2</label>
                                            <input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
                                            <label id="brightness-value" width="100">Brightness: 0</label>
                                            <input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
                                            <label id="contrast-value" width="100">Contrast: 0</label>
                                            <input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
                                            <label id="threshold-value" width="100">Threshold: 0</label>
                                            <input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
                                            <label id="sharpness-value" width="100">Sharpness: off</label>
                                            <input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
                                            <label id="grayscale-value" width="100">grayscale: off</label>
                                            <input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
                                            <br>
                                            <label id="flipVertical-value" width="100">Flip Vertical: off</label>
                                            <input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
                                            <label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
                                            <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="thumbnail" id="result">
                                            <div class="well" style="overflow: hidden;">
                                                <img width="320" height="240" id="scanned-img" >
                                            </div>
                                            <div class="caption">
                                                <h4>HASIL SCAN</h4>
                                                <p id="scanned-QR"></p>
                                                <p ></p>
                                                <input disabled="" id="scanned-QR1" class="form-control" value="..."/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                           
                        </div> 
                    </div>
                </section>  
            </div>
        </div>
        </div>
        
        <script type="text/javascript" src="{{URL::asset('js/filereader.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('js/qrcodelib.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('js/WebCodeCamJS.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('js/main.js')}}"></script>


    </body>
</html>