@extends('layouts.app')

@section('content')


    @if (count($classes) != 0)
    <div class="mx-3 p-3">

        <div class="d-flex justify-content-between mt-3">
            <h4 class="text-capitalize">{{$grade->grade_name}} classes</h4>

            <div class="">
                <a href="{{route('classes.createNewClass',['gradeIdParameter' => $grade->id]) }}">
                    <button class="btn btn-primary"> <i class="fa fa-plus"></i> Add Class</button>
                </a>
            </div>
        </div>


        <div class="row">
            @foreach ($classes as $class)
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <a href="{{route('grades.classes.show.registrations',['gradeId' => $grade->id, 'classId' => $class->id])}}" class="text-decoration-none">
                    <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1">
                        <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content text-dark">
                        <span class="info-box-text text-lg">{{$class->class_name}}</span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                </a>
                </div>
            @endforeach
        </div>
    </div>
    @else
        <div class="containter ">
            <div class="text-center pt-5" >
                <h4 class="text-capitalize">
                    No Classes in this Grade
                </h4>

                <div class="mt-5">
                    <a href="{{route('classes.createNewClass',['gradeIdParameter' => $grade->id]) }}">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> Create Class</button>
                    </a>
                </div>

            </div>
        </div>

    @endif


@endsection
