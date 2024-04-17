@extends('auth.layouts')

@section('title', 'Login Page')

@section('body_class', 'hold-transition login-page')

@section('content')

<div class="login-box">
    <div class="login-logo">
      {{-- <a href="../../index2.html"><b>Admin</b>LTE</a> --}}
      <img src="{{asset('images/school_logo.png')}}" alt="AdminLTE Logo" class="img-circle elevation-3" style="opacity: .8;width:50px;">
      <span class="brand-text font-weight-bold text-secondary" style="font-size: 18px">La Yaung LMS</span>
  </a>    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label required">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                @error('email')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label required">Password</label>
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
      </div>
    </div>
  </div>

@endsection
