@extends('layouts.app')

@section('content')

    <div class="">

        @if (count($grades) != 0)

            <div class="d-flex justify-content-between pt-4 mx-5">
                <h3>All Grades</h3>
                <div>
                    <a href="{{route('grades.create')}}" class="text-decoration-none">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> Add New Grade </button>
                    </a>
                </div>
            </div>


            <div class="row mx-3 mt-3">
                @foreach ($grades as $grade)
                <div class="col-12 col-sm-6 col-md-3 mt-4">
                    <a href="{{ route('grades.classes', ['grade' => $grade->id]) }}" class="text-decoration-none">
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

        @else
            <div class="text-center pt-5" >
                <h4>
                    No Grades Created Yet
                </h4>

                <div class="mt-5">
                    <a href="{{route('grades.create') }}">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> Create Grade</button>
                    </a>
                </div>
            </div>
        @endif


    </div>

@endsection
