@extends('layouts.app')

@section('content')

    <div class=" mx-3 py-5">
        <div class="">
            @foreach ($grades as $grade)

                <div class="mb-5">
                    <h4>{{$grade->grade_name}}</h4>

                    <div class="row">

                        @if (count($grade->classes) != 0)
                            @foreach ($grade->classes as $class)
                                <div class="col-12 col-sm-6 col-md-3">
                                    <a href="">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1">
                                            <i class="fa fa-university" aria-hidden="true"></i>
                                        </span>

                                        <div class="info-box-content text-dark">
                                            <span class="info-box-text text-lg">{{$class->class_name}}</span>
                                            <span class="info-box-number">
                                            {{$class->grade->grade_name}}
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="mx-3 my-2">
                                <h5>There is No Class Yet</h5>
                            </div>

                        @endif
                    </div>
                </div>

            @endforeach

        </div>
    </div>

@endsection
