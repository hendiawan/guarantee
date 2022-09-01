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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>		

        
<style>
    
 

body {
  font-family: Roboto, sans-serif;
}

#chart {
  max-width: 650px;
  margin: 35px auto;
}

    
    body {
     background-color: #f9f9fa
 }

 .flex {
     -webkit-box-flex: 1;
     -ms-flex: 1 1 auto;
     flex: 1 1 auto
 }

 @media (max-width:991.98px) {
     .padding {
         padding: 1.5rem
     }
 }

 @media (max-width:767.98px) {
     .padding {
         padding: 1rem
     }
 }

 .padding {
     padding: 5rem
 }

 .card {
     background: #fff;
     border-width: 0;
     border-radius: .25rem;
     box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
     margin-bottom: 1.5rem
 }

 .card {
     position: relative;
     display: flex;
     flex-direction: column;
     min-width: 0;
     word-wrap: break-word;
     background-color: #fff;
     background-clip: border-box;
     border: 1px solid rgba(19, 24, 44, .125);
     border-radius: .25rem
 }

 .card-header {
     padding: .75rem 1.25rem;
     margin-bottom: 0;
     background-color: rgba(19, 24, 44, .03);
     border-bottom: 1px solid rgba(19, 24, 44, .125)
 }

 .card-header:first-child {
     border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0
 }

 card-footer,
 .card-header {
     background-color: transparent;
     border-color: rgba(160, 175, 185, .15);
     background-clip: padding-box
 }
    
</style>
        <meta name="csrf-token" content="{{csrf_token()}}" />
    </head>
    <body>
        <div id="customLoad">
                <div class="spinner"></div>
                <strong>MOHON TUNGGU...</strong>
                <div class="loadInfo">proses update data sedang berlangsung</div>
            </div>
        <header> 
            <div style="border-color: #cccccc; margin: 2px;height: 70px; background-color: #ffffff;border-radius: 8px ;" class="navbar " role="navigation">
                <a class="navbar-brand" href="#">
                             <img alt="Brand" class="pull-left"  width="25%" src=" {{URL::asset('img/jamkrida.png')}}">
                         </a>
                <a style="margin: 10px;color:#23527c" class="navbar-brand" rel="home" href="/" title=""><b>Sistem Akseptasi Penjaminan</b></b></a>
                <div class="container">
                    
                    
                    <div class="navbar-header">
                        <form style="margin: 10px;" class="form-inline my-2 my-2" role="search" method="post" action="carisertifikat">
                                {{csrf_field()}}
                            <div class="input-group"> 
                                <input style="height: 50px; width: 100%;border-radius: 25px 0px 0px 25px"  type="text" class="form-control mr-sm-2" placeholder="Search Sertifikat" name="data" id="srch-term">
                                <div class="input-group-btn">
                                    <button   style="height: 50px; border-radius: 0px 25px 25px 0px" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                      
                         
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                       
                </div>
                        

                   <div style="margin: 10px " class="collapse navbar-collapse" id="navbarNavAltMarkup"> 
                       <ul style="color: black" class="nav navbar-nav navbar-right"> 
                         
                           <li><a style="color:#23527c " href="{{url('/datapenjaminanview')}}"> <span class="glyphicon glyphicon-home"></span> <b>Home</b></a></li>                                                  
                        @if(Auth::user()->level == 'direksi')
                                <!--<li><a href="{{url('/DigitalSign')}}"><i class="glyphicon glyphicon-transfer"></i> <b>Sign Kredit</b></a></a></li>--> 
                                <!--<li><a href="{{url('/DigitalSignSb')}}"><i class="glyphicon glyphicon-transfer"></i> <b>Sign Surety Bond</b></a></a></li>--> 
                                <!--<li><a href="{{url('/SingleDigitalSign')}}"><i class="glyphicon glyphicon-transfer"></i> <b>Single Sign</b></a></a></li>--> 
                        @endif
                        @if(Auth::user()->level != 'direksi')
                        <li class="dropdown">
                            <a style="color:#23527c" class="dropdown-toggle" data-toggle="dropdown" href="#"><b>Data</b>
<!--                             <span class="caret"></span>-->
                            </a>
                            
                              <ul style="border-radius: 10px"class="dropdown-menu">                                    
                                  <li style="margin-top: 17px"><a href="{{url('bank')}}">Data bank</a></li>
                                 <li><a href="{{url('rate')}}">Data rate</a></li>
                                 <li><a href="{{url('/rekanan/read')}}">Data reasuransi</a></li>
                                  <li style="margin-bottom: 17px"><a href="{{url('/rekanan/rekap')}}">Rekap reasuransi</a></li>
                            </ul>
                        </li>
                      
                        <li class="dropdown">
                            <a  style="color:#23527c"class="dropdown-toggle" data-toggle="dropdown" href="#"><b>Utility</b>
<!--                             <span class="caret"></span>-->
                            </a>
                            <ul style="margin: 5px; border-radius: 10px" class="dropdown-menu">                                    
                                <!--<li style="margin-top: 17px"><a href="{{url('verifysert')}}">VERIFY SERTIFIKAT</a></li>-->
                                 <li  style="margin-top: 17px"><a href="{{url('Cetaksertifikat')}}">Cetak sertifikat</a></li>
                                 <li><a href="{{url('ubahdata')}}">Perubahan data</a></li>
                                 <li><a href="{{url('pelunasan')}}">Pelunasan kredit</a></li>
                                 <li><a href="{{url('sinkronisasi')}}">Sinkronisasi data</a></li>
                                 <li><a href="{{url('sinkronisasi-perbank')}}">Sinkronisasi perbankan</a></li>
                                 <li><a href="{{url('sinkronisasi-perbank-web')}}">Sinkronisasi  via web</a></li>
                                 <li><a href="{{url('CetaksertifikatSign')}}">Sertifikat sign</a></li>
                                 <li><a href="{{url('importexportadmin')}}">Import data</a></li>
                                 <li><a href="{{url('/rekanan/reasuransi')}}">Proses reasuransi</a></li>
                                 <li  style="margin-bottom: 17px"><a href="{{url('/rekanan/register')}}">Register reasuransi</a></li> 
                            </ul>
                        </li>
                        @endif
                        <li class="dropdown">
                            <a  style="color:#23527c" class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> 
                                <!--<span class="caret"></span>-->
                            </a>
                                <ul style="border-radius: 10px"class="dropdown-menu right"> 
                                <li><a  ></i><b> {{strtoupper(Session::get('name'))}}</b></a></li> 
                                <li><a href="changepassadm"></i>Change password</a></li> 
                                @if(Auth::user()->level != 'direksi')
                                <li><a href="{{url('/register')}}">Register user</a></li> 
                                <li><a href="{{url('/registerbank')}}">Register bank</a></li> 
                                @endif
                                
                                <li><a href="{{url('/logout')}}"><i class="glyphicon glyphicon-log-out"></i><b> Logout</b></a></a></li> 
                            
                            </ul>
                        </li>
                    </ul>
                        @if(Auth::user()->level != 'direksi')
                      
                       
                
                        @endif
                </div>
                </div>
                
            </div >
      
              
                    
        </header>
        <div class="container-fluid">
                         <br>
               @yield('content')
        </div>
         
        <footer style="margin-left: 10px; margin-top: 10x"> 
            <p>
               <b> Powered by : </b>
            </p>
            <div id="topBarMain">
                <div class="pad20">
                    <a class="logoMain" href="https://bsre.bssn.go.id" target="_blank">
                        <img class="image img-responsive" size="50%"  src= "/img/logo-bsre1.png">
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



