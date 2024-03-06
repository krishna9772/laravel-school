@extends('auth.layouts')

@section('title', 'Login Page')

@section('body_class', 'hold-transition login-page')

@section('content')

<div class="login-box">
    <div class="login-logo">
      {{-- <a href="../../index2.html"><b>Admin</b>LTE</a> --}}
      School Management System
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                @error('email')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                @error('password')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            @error('error')
                <p class="text-danger">{{$message}}</p>
            @enderror
          <div class="row">

            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        {{-- <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div> --}}
        <!-- /.social-auth-links -->

        {{-- <p class="mb-1 mt-2">
          <a href="forgot-password.html">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="{{route('registerPage')}}" class="text-center">Don't Have An Account? Register</a>
        </p> --}}
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

@endsection
