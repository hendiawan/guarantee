@extends('layout.user')

@section('content')
 


<body>
    <div class="container">
         <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <h2 align="center">RATE PENJAMINAN KREDIT</h2>
        </strong>
    </div>
    <div class="panel-body" >
        <section  class="col-lg-13 connectedSortable">
            <div class="box box-solid">
                  
        <br />
    
        <br />
               
        <br />
        <div class="table-responsive" style="overflow-x: unset;">

            <table id='tabelpembayaran' class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO </th>
                        <th>NAMA BANK</th>
                        <th>NAMA RATE</th>                        
                        <th>DARI(Bln)</th>
                        <th>SAMPAI(Bln)</th>
                        <th>RATE(%)</th>
                       
                    </tr>
                </thead>
                <tbody>
                       <?php $i=1; ?>
                    @foreach($rate as $datas)
                            
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> namabank}}</td>
                                <td>{{$datas -> namarate}}</td>
                                <td>{{$datas -> dari}}</td>
                                <td>{{$datas -> sampai}}</td>
                                <td>{{$datas -> rate}}</td>
                                
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                </tbody>
            </table>
        </div>

  
            </div>
        </section>  
    </div>
</div>
    </div>
   
</body>   
<br>
<br>
@endsection




