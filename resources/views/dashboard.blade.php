@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row py-5">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"> <i class="fa fa-user" aria-hidden="true"></i> </span>

            <div class="info-box-content">
              <span class="info-box-text">Total Students</span>
              <span class="info-box-number">
                {{$studentCount}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-address-book" aria-hidden="true"></i> </span>

            <div class="info-box-content">
              <span class="info-box-text">Total Teachers</span>
              <span class="info-box-number">{{$teacherCount}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Grades</span>
              <span class="info-box-number">{{$gradeCount}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Classes</span>
              <span class="info-box-number">{{$classCount}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </div>
  </section>

@endsection
