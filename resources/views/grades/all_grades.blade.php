@extends('layouts.app')

@section('content')

    <div class="">
        <div class="row mx-3">

            @foreach ($grades as $grade)
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <a href="{{ route('grades.classes', ['grade' => $grade->id]) }}">
                  <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1">
                        <i class="fa fa-university" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content text-dark">
                      <span class="info-box-text text-lg">{{$grade->grade_name}}</span>
                      <span class="info-box-number">
                         {{$grade->classes->count()}} Classes
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </a>
              </div>
            @endforeach

        </div>
    </div>

@endsection
