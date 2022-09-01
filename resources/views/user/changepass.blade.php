@extends('layout.user')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('postchangepass')}}">
                        {{ csrf_field()}}

                        <div class="form-group{{ $errors-> has('username') ? ' has-error' : ''}}">
                            
                            <div class="col-md-6">
                                <input hidden="" id="name" type="text" class="form-control" name="username" value="{{ Session::get('name')}}">

                                @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('username')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors-> has('passwordlama') ? ' has-error' : ''}}">
                            <label for="passwordlama" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="passwordlama" type="password" class="form-control" name="passwordlama">

                                @if ($errors->has('passwordlama'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('passwordlama')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors-> has('password') ? ' has-error' : ''}}">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('password')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors-> has('password_confirmation') ? ' has-error' : ''}}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('password_confirmation')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                         

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
