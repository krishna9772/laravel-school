{{-- @extends('layouts.app')

@section('content')

<div>

    {{-- @foreach ($paginatedData as $gradeId => $curriculums)
        <h2>Grade ID: {{ $gradeId }}</h2>
        <ul>
            @foreach ($curriculums as $curriculum)
                <li>{{ $curriculum->name }} - {{ $curriculum->user->name }}</li>
            @endforeach
        </ul>
    @endforeach --}}

    {{-- {{ $paginatedData->links() }}
</div>

@endsection --}}


@extends('layouts.app')

@section('styles')
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }
  </style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">

        @if (count($paginatedData) != 0)
            <div class="">
                <div class="d-flex justify-content-between py-4">
                    <h3 class="">Subjects</h3>
                    <div>
                        <div class="d-flex mr-5">
                            <label for="" class="  form-label mt-2 mr-1">Filter:</label>
                            <select id="filter" name="filter" class="form-control ">
                                <option value="all">All</option>

                                @foreach ($paginatedData as $filterOptions)
                                    <option value="{{ $filterOptions[0]->grade->id }}"> {{ $filterOptions[0]->grade->grade_name }} </option>
                                @endforeach
                                {{-- <option value="student">Student</option>
                                <option value="teacher">Teacher</option> --}}
                            </select>
                        </div>

                    </div>
            </div>


            <div class="row">
                    @foreach ($paginatedData as $data)
                    <div class="col-md-4 mt-3">
                        <!-- general form elements -->
                        <div class="card card-primary">
                        <div class="card-header">
                            <div>
                            <h3 class="card-title">{{ $data[0]->grade->grade_name }}</h3>
                            </div>
                            <div class=" float-right ">
                            <a href="{{route('curricula.edit',$data[0]->grade->id)}}" class="text-decoration-none" title="Edit">
                                <i class="fa fa-edit mr-3"></i>
                            </a>
                            {{-- <a type="button" data-grade-id="{{$data[0]->grade->id}}" class=" text-decoration-none deleteBtn" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a> --}}
                            <a type="button" class="" data-toggle="modal" data-target="#deleteCurriculaModal_{{$data[0]->grade->id}}">
                                <i class="fa fa-trash"></i>
                            </a>

                            <div class="modal fade" id="deleteCurriculaModal_{{$data[0]->grade->id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class='modal-header'>
                                        <p class='col-12 modal-title text-center'>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                              </button><br><br>
                                          <span class=" text-dark" style="font-size: 18px">Are you sure to delete all curricula of <br>
                                            <span class=" font-weight-bold text-dark" style="font-size: 19px"> {{$data[0]->grade->grade_name}}? </span>
                                          </span>

                                        </p>
                                      </div>

                                    <div class="modal-footer  justify-content-center ">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" data-grade-id="{{$data[0]->grade->id}}" class="btn btn-danger deleteBtn">Delete</button>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            </div>
                        </div>
                        <!-- /.card-header -->

                            <div class="card-body p-0">


                                <ul class="list-group">
                                    @foreach ($data as $curriculum)
                                        <li class="list-group-item">
                                            <span class="float-left">{{$curriculum->curriculum_name }}</span>
                                            <span class="float-right">{{$curriculum->user ? $curriculum->user->user_name : '' }}</span>
                                        </li>
                                    @endforeach
                                    {{-- @foreach ($data as $user)
                                            <li class="list-group-item">
                                                <span class="float-left">{{$user->curriculum_name }}</span>
                                                {{-- <span class="float-right">{{$user->user_name }}</span> --}}
                                            {{-- </li>
                                    @endforeach  --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="mt-1">
                    {{ $paginatedData->links() }}
                </div>
            </div>
        @else
        <div class="text-center pt-5" >
            <h4>
                No Subjects Created Yet
            </h4>

            <div class="mt-5">
                <a href="{{route('curricula.create') }}">
                    <button class="btn btn-primary"> <i class="fa fa-plus"></i> New </button>
                </a>
            </div>

        </div>
        @endif



    </div>
</section>

@endsection

@section('scripts')

<script>

$(document).ready(function () {
        $('#filter').change(function() {
            var filterType = $(this).val();

            $.ajax({
                type: 'get',
                url: '{{ route('curricula.filter', ["filter_type" => ":filter_type"]) }}'.replace(':filter_type', filterType),
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('.row').empty();

                    $.each(response.data, function(gradeId, curriculums) {
                        var editUrl = "{{ route('curricula.edit', ':curriculum') }}".replace(':curriculum', gradeId);

                        var card = `
                            <div class="col-md-4 mt-3">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <div>
                                            <h3 class="card-title">${curriculums[0].grade.grade_name}</h3>
                                        </div>
                                        <div class=" float-right ">
                                            <a href="${editUrl}" class="text-decoration-none">
                                                <i class="fa fa-edit mr-3"></i>
                                            </a>

                                            <a type="button" class="" data-toggle="modal" data-target="#deleteCurriculaModal_${gradeId}">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <div class="modal fade" id="deleteCurriculaModal_${gradeId}">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class='modal-header'>
                                                        <p class='col-12 modal-title text-center'>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                              </button><br><br>
                                                          <span class=" text-dark" style="font-size: 18px">Are you sure to delete all curricula of <br>
                                                            <span class=" font-weight-bold text-dark" style="font-size: 19px"> ${curriculums[0].grade.grade_name}? </span>
                                                          </span>

                                                        </p>
                                                      </div>

                                                    <div class="modal-footer  justify-content-center ">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                      <button type="button" data-grade-id="${gradeId}" class="btn btn-danger deleteBtn">Delete</button>
                                                    </div>
                                                  </div>
                                                  <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group">
                        `;

                        $.each(curriculums, function(index, curriculum) {
                            var curriculumName = curriculum.curriculum_name;
                            var teacherName = curriculum.user.user_name;

                            card += `
                                <li class="list-group-item">
                                    <span class="float-left">${curriculumName}</span>
                                    <span class="float-right">${teacherName}</span>
                                </li>
                            `;
                        });


                        card += `
                                    </ul>
                                </div>
                            </div>
                        </div>
                        `;

                        $('.row').append(card);

                        $('.deleteBtn').off('click').on('click', function() {
                            var $card = $(this).closest('.col-md-4');
                            var $gradeId = $(this).data('grade-id');
                            console.log('grade id is ' + $gradeId);

                            $.ajax({
                                type: 'GET',
                                url : '{{route('curricula.delete.with.grade', ["gradeId" => ":gradeId"]) }}'.replace(':gradeId', $gradeId),
                                success: function(response) {
                                    $card.remove();
                                    console.log(response);
                                    if(response == 'success'){
                                        window.location.href = '{{ route('curricula.index') }}';
                                    }
                                },
                                error: function(xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    var response = JSON.parse(xhr.responseText);
                                    console.log(response);
                                }
                            });
                        });

                    });
                },

        });
    });
    $('.deleteBtn').click(function() {

        var $card = $(this).closest('.col-md-4');

        $gradeId = $(this).data('grade-id');
        console.log('grade id is ' + $gradeId);

        $.ajax({
            type: 'GET',
            url : '{{route('curricula.delete.with.grade', ["gradeId" => ":gradeId"]) }}'.replace(':gradeId', $gradeId),
            success: function(response) {
                $card.remove();
                console.log(response);
                if(response == 'success'){
                    window.location.href = '{{route('curricula.index')}}';
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);
                    console.log(response);
            }
        });
    });
});
</script>

@endsection
