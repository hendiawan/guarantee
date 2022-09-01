
<br/>
<br/>
@extends('layout.bootstraplogin.index')

@section('content')

<div class="jumbotron text-center">
    <center>
        <!--<div style="background-image:url('img/jamkrida.png');background-repeat:no-repeat;position: relative "></div>-->
        <img src="/img/jamkrida.png"  height="15%" alt="User Image">
    </center>
  <h1>DETAIL INFOMASI PEMILIK TANDA TANGAN</h1>
  <p>NOMOR : <strong>{{$sertifikat->kodesertifikat }}</strong></p>
</div>
  <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                    <strong>DETAIL TANDA TANGAN</strong> 
                    <strong></strong>
                </center>
            </div>
<div id="main" class="container-fluid">
    <div class="topTabs">
        <div id="topTabs-container-home">
            <div class="topTabsContent" style="padding-left:0;"> 
                <div id="tab1">					
                    <p><b>(Penjamin)</b></p>
                    <p>
                        <img  src="/img/ttd.png"class="img-responsive" width='27%'  alt="User Image">
                    </p>  
                    <p><b>INDRA MANTHICA</b></p>
                    <p>Direktur Utama</p>				                    	
                </div>
                <div id="tab2">
                    <div class="widget-content pad20f">	
                        <center>
                              <p><strong>PT JAMKRIDA NTB BERSAING</strong></p>
                        </center>
                      
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

 
 

@endsection
