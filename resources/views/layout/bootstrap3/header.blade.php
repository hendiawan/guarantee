<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">  
            <a class="navbar-brand" href="<?php echo URL::to('/buku'); ?>"><i class="glyphicon glyphicon-home">&nbsp;Pendataan Buku</i></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">   
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-book"></i>  Buku <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to('/buku/add'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Buku</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo URL::to('/buku'); ?>"><i class="glyphicon glyphicon-list-alt"></i> View Table</a></li>
                </ul>
                </li>
           
                
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-print"></i>  Penerbit <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to('/penerbit/add'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Penerbit</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo URL::to('/penerbit'); ?>"><i class="glyphicon glyphicon-list-alt"></i> View Table</a></li>
                </ul>
                </li>
                
                    
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-pencil"></i>  Penulis <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to('/penulis/add'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Penulis</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo URL::to('/penulis'); ?>"><i class="glyphicon glyphicon-list-alt"></i> View Table</a></li>
                </ul>
                </li>
           
             
       
                
        </ul>
               <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i> 
                    <?php
                    if (Auth::check()) {
                        $user = Auth::user();
                        echo $user->username;
                   }
                    ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php  echo URL::to('/login/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
          

        </div>
    </div>
</nav>