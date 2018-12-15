@extends('auth.master')
@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      @if(Session::has('message'))
        {!!Session::get('message')!!}
      @endif
      <form action="{{url('/login')}}" method="post">
        <div class="form-group has-feedback">
          <input type="email" name="email" required class="form-control" placeholder="Email">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        {{csrf_field()}}
        <div class="form-group has-feedback">
          <input type="password" name="password" required class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
  
      <a href="#">I forgot my password</a><br>
    </div>
    <!-- /.login-box-body -->
</div>
@endsection