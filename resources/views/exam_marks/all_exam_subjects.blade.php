@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')

    <div class=" mx-5 py-4">

        @if (count($grades) != 0)
            <div class="d-flex justify-content-between ">
                <h3>All Exam Subjects</h3>
                <div class="">
                    <a href="{{route('exam-marks.subject')}}">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> New Exam Subject</button>
                    </a>
                </div>
            </div>

            <div class="accordion accordion-flush my-5" id="accordionFlushExample">

                @foreach($grades as $grade)
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion{{$grade->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
                      {{$grade->grade_name}}
                    </button>
                  </h2>
                  <div id="accordion{{$grade->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            @if (count($grade->examSubjects) != 0)
                                @foreach ($grade->examSubjects as $class)
                                    <div class="col-12 col-sm-6 col-md-3">

                                        <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1">
                                            <i class="fas fa-book" aria-hidden="true"></i>
                                        </span>

                                        <div class="info-box-content text-dark">
                                            <span class="info-box-text text-lg">{{isset($class->subject)  ? $class->subject : 'No class yet'}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span class="mx-4">
                                    No Subjects yet in this grade.
                                </span>
                            @endif

                        </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>

        @else

        <div class="text-center pt-5" >
            <h4>
                No Classes Created Yet
            </h4>

            {{-- <div class="mt-5">
                <a href="{{route('classes.createNewClass') }}">
                    <button class="btn btn-primary"> <i class="fa fa-plus"></i> Create Class</button>
                </a>
            </div> --}}
        </div>

        @endif


    </div>


@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script>


</script>

@endsection
