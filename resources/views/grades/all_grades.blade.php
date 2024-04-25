@extends('layouts.app')

@section('content')

    <div class="">

        {{-- @if (count($grades) != 0) --}}

            {{-- <div class="d-flex justify-content-between pt-4 mx-5">
                <h3>Grades</h3>
                <div>
                    <a href="{{route('grades.create')}}" class="text-decoration-none">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> Add New Grade </button>
                    </a>
                </div>
            </div> --}}


            <div class="row mx-3 mt-3">
                @foreach ($grades as $grade)
                <div class="col-12 col-sm-6 col-md-3 mt-4">
                    <a href="{{ route('grades.classes', ['grade' => $grade->id]) }}" class="text-decoration-none">
                    <div class="info-box" style="position: relative">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </span>

                        <div class="info-box-content text-dark">
                        <span class="info-box-text text-lg text-capitalize">{{$grade->grade_name}}</span>
                        <span class="info-box-number">
                            {{$grade->classes->count()}} Class{{$grade->classes->count() > 1 ? 'es' : ''}}
                        </span>
                        </div>
                        <!-- /.info-box-content -->

                        <span class="text-black-50 question-mark" style="position: absolute; right: 10px; bottom: 10px">
                            <span data-container="body" data-toggle="popover" data-placement="right"  title="{{$grade->grade_name}} Description" data-content="{{$grade->description}}">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </span>

                        {{-- <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                            Popover on right
                          </button> --}}



                    </div>
                    </a>
                </div>
                @endforeach
            </div>

        {{-- @else --}}
            {{-- <div class="text-center pt-5" >
                <h4>
                    No Grades Created Yet
                </h4>

                <div class="mt-5">
                    <a href="{{route('grades.create') }}">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> Create Grade</button>
                    </a>
                </div>
            </div> --}}
        {{-- @endif --}}


    </div>

@endsection
@section('scripts')

<script>
    $('[data-toggle="popover"]').popover();

    $('.question-mark').click(function(event) {
        event.stopPropagation();
        event.preventDefault();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.popover').length) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });
</script>

@endsection
