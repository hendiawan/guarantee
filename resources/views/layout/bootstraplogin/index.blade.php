<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @include('layout.bootstrapadmin.head')
    </head>
    <body>
        @include('layout.bootstrapadmin.nav')
        <div class="container">
            @yield('content')
            
        </div>
        @include('layout.bootstrapadmin.footer')
    </body>
    <hr>
    <footer> 
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
</html>