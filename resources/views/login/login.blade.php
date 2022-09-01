@extends('layout.bootstraplogin.index')

@section('content')



<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
 

<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-3">
        <div   style="border-radius: 20px;"  class="panel panel-default">
            <div   style="border-radius: 20px;"  class="panel-heading">
                <center>
                    <strong><i class="glyphicon glyphicon-off"></i>  Login</strong>
                </center>
            </div>
            <center>
                <img src="img/jamkrida.png"  height="15%" alt="User Image">
            </center>

        </div>

        <div   style="border-radius: 30px;"  class="panel panel-default">

            <div class="panel-body">

                @if (Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                <center>
                    <form class="form-horizontal" method="POST" action="{{ URL::to('/login/proses')}}">
                        <div class="form-group">
                            <label><i class="glyphicon glyphicon-user"></i> Username</label>
                            <div class="col-sm-12">
                                <input   style="border-radius: 30px;"  type="text" name="username" class="form-control" placeholder="Username">
                                <p style="color: red"> {{ $errors->first('username') }} </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="glyphicon glyphicon-eye-open"></i> Password</label>
                            <div class="col-sm-12">
                                <input    style="border-radius: 30px;" type="password" name="password" class="form-control" placeholder="*******">
                                <p style="color: red"> {{ $errors->first('password') }} </p>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="col-sm-offset-2 ">
                                <button   style="border-radius: 30px;"  type="submit" class="btn btn-info">
                                    <i class="glyphicon glyphicon-log-in"></i> 
                                    Login
                                </button>
                                <button   style="border-radius: 30px;"  type="reset" class="btn btn-danger">
                                    <i class="glyphicon glyphicon-remove-sign"></i> 
                                    Reset
                                </button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </form>
                </center>

            </div>
        </div>
    </div>
</div>

@endsection