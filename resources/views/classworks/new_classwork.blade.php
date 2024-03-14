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
      <div class="row justify-content-center">
        <!-- left column -->
        <div class="col-md-5 mt-5">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New Topic</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addCurriculumForm">

              <div class="card-body">

                <div class="form-group">
                    <label for="" class="form-label required">Select Grade</label>
                    <select name="gradeSelect" id="gradeSelect" class="form-control">
                        <option value="">Select Grade</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="selectBoxError1"></p>
                </div>

                {{-- <div class="form-group">
                    <label for="" class="form-label">Curriculu select Grade</label>
                    <select name="" id="" class="form-control">
                        <option value="">Select Curr</option>
                        @foreach ($grades as $grade)
                            @foreach ($grade->curricula as $curriculum)
                            <option value="{{$curriculum->id}}">{{$curriculum->curriculum_name}}</option>
                            @endforeach

                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="selectBoxError1"></p>
                </div> --}}

                <div class="form-group">
                    <label for="" class="form-label">Select Class</label>
                    <select name="classSelect" id="classSelect" class="form-control">
                        <option value="">Select Class</option>
                    </select>
                    <p class="text-danger mt-1" id="selectBoxError2"></p>
                </div>

                <div class="form-group">
                    <label for="" class="form-label">Select Curriculum</label>
                    <select name="curriculumSelect" id="curriculumSelect" class="form-control">
                        <option value="">Select Curriculum</option>
                    </select>
                    <p class="text-danger mt-1" id="selectBoxError3"></p>
                </div>

                <div class="form-group">
                    <label for="" class="form-label required">Topic Name</label>
                    <input type="text" name="name" id="nameInputBox" class="form-control" placeholder="Enter Topic Name">
                    <p class="text-danger" id="nameErrorMessage"></p>
                </div>

                {{-- <div id="dynamicRows">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Curriculum Name</label>
                            <input type="text" name="curriculum_name[]" class="form-control" placeholder="Enter Curriculum Name">
                            <p class="text-danger curriculum-name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Select Teacher</label>
                            <select name="teacher_id[]" class="form-control">
                                <option value="">Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->user_id}}">{{$teacher->user_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger mt-1 teacher-id-error"></p>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group">
                    <button type="button" id="addSourceBtn" class="btn btn-success" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add Source</button>
                    {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                        Launch Default Modal
                    </button> --}}

                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Source Type</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body py-4">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="mx-3 border-0 bg-white ">
                                        <img src="{{asset('images/menu_icons/url image.jpg')}}" width="70px">
                                        <p class="mt-2">URL</p>
                                    </button>
                                    <button type="button" class="mx-3 border-0 bg-white ">
                                        <img src="{{asset('images/menu_icons/files (1).png')}}" width="70px">
                                        <p class="mt-2">File</p>
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div> --}}
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->

                    <button type="button" id="removeBtn" class="btn btn-danger"> <i class="fa fa-minus"></i> Remove</button>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-info mr-2">Save</button>
                    <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                </div>
              </div>
            </form>
          </div>


        </div>
      </div>
    </div>
</section>

@endsection

@section('scripts')

<script>

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var initialFormHTML = $('#addCurriculumForm').html();

    function restoreInitialForm() {
        $('#addCurriculumForm').html(initialFormHTML);
        inputFieldCount = $("input[name='curriculum_name[]']").length;

        attachEventHandlers();
    }

    attachEventHandlers();

    function attachEventHandlers(){
        function clearGradeIdInputBoxError() {
            $('#gradeSelect').removeClass('is-invalid');
            $('#gradeIdErrorMessage').text('');
        }

        $('#gradeSelect').change(function() {
            clearGradeIdInputBoxError();
        });

        $('#nameInputBox').on('input', function () {
            clearNameInputBoxError();
        });


        function clearNameInputBoxError() {
            $('#nameInputBox').removeClass('is-invalid');
            $('#nameErrorMessage').text('');
        }


        $('#addCurriculumForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route('curricula.store') }}',
                data: $(this).serialize(),
                success: function (response) {
                    if(response == 'success'){
                        window.location.href = '{{ route('curricula.index') }}';
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    console.log(response);

                    let gradeSelectBoxError = response.errors.grade_id ? response.errors.grade_id[0] : '';

                    if (gradeSelectBoxError) {
                        $('#gradeSelectBoxError').html(gradeSelectBoxError);
                        $('#gradeSelect').addClass('is-invalid');
                    } else {
                        $('#gradeSelectBoxError').html('');
                        $('#gradeSelect').removeClass('is-invalid');
                    }

                    $('.curriculum-name-error').text('');
                    $('.teacher-id-error').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            var errorMessage = value[0];

                            var [fieldName, index] = key.split('.');

                            var $row = $('[name="' + fieldName + '[]"]').eq(index).closest('.row');

                            if (fieldName === 'curriculum_name') {
                                $row.find('.curriculum-name-error').text('Curriculum name is required');
                                $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                            } else if (fieldName === 'teacher_id') {
                                $row.find('.teacher-id-error').text('Teacher field is required');
                                $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                            }
                        });
                    }
                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
        });

        var inputFieldCount = 1;

        function toggleButtons() {
            if (inputFieldCount >= 5) {
                $("#addMoreBtn").prop("disabled", true);
            } else {
                $("#addMoreBtn").prop("disabled", false);
            }
        }

        $("#addMoreBtn").click(function() {
            if (inputFieldCount < 5) {
                var newRow = `
                    <div class="row">
                        <div class="form-group col-6">
                            <input type="text" name="curriculum_name[]" class="form-control" placeholder="Enter Curriculum Name">
                            <p class="text-danger curriculum-name-error"></p> <!-- Unique ID for error message -->
                        </div>
                        <div class="form-group col-6">
                            <p class="text-danger mt-1 teacher-id-error"></p> <!-- Unique ID for error message -->
                        </div>
                    </div>
                `;
                $("#dynamicRows").append(newRow);
                inputFieldCount++;
                toggleButtons();
            }
        });


        $("#removeBtn").click(function () {
            if (inputFieldCount > 1) {
                $("#dynamicRows .row:last-child").remove();
                inputFieldCount--;
                toggleButtons();
            }
        });

        toggleButtons();

        $('#cancelBtn').click(function(){
            restoreInitialForm();
        });


        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty(); // Clear previous options
            $('#selectBoxError1').text('');
            $('#curriculumSelect').empty();

            // var selectedGrade = $(this).val();
            // if (selectedGrade !== '') {
            //     $('#classSelect').prop('disabled', false);
            //     $('#selectBoxError1').text('');
            // } else {
            //     $('#classSelect').prop('disabled', true);
            //     $('#selectBoxError1').text('Please select a grade first');
            //     $('#selectBoxError2').text('');
            // }

            if (gradeId === '') {
                // If 'Select Grade' is selected, show 'Select Class' in class select box
                $('#classSelect').append($('<option>', {
                    value: '',
                    text : 'Select Class',
                }));

                $('#curriculumSelect').append($('<option>', {
                    value: '',
                    text : 'Select Curriculum',
                }));

            } else {
                // Filter classes based on selected grade
                var classesFound = false;
                var curriculumFound = false;
                @foreach ($grades as $grade)
                    if ('{{$grade->id}}' === gradeId) {
                        @foreach ($grade->classes as $class)
                            $('#classSelect').append($('<option>', {
                                value: '{{$class->id}}',
                                text : '{{$class->class_name}}'
                            }).attr('data-description', '{{$class->description}}'));
                            classesFound = true;
                        @endforeach

                        @foreach ($grade->curricula as $curriculum)
                            $('#curriculumSelect').append($('<option>', {
                                value: '{{$curriculum->id}}',
                                text : '{{$curriculum->curriculum_name}}'
                            }));
                            curriculumFound = true;
                        @endforeach
                    }
                @endforeach

                $('#selectBoxError2').text('');
                $('#selectBoxError3').text('');

                if (!classesFound) {
                    $('#classSelect').append($('<option>', {
                        value: '',
                        text : 'No Classes in this grade'
                    }));
                }

                if (!curriculumFound) {
                    $('#curriculumSelect').append($('<option>', {
                        value: '',
                        text : 'No Curricula in this grade'
                    }));
                }
            }
        });

        $('#classSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError2').text('First, select a grade');
                // return false; // Prevent the dropdown from opening
            } else {
                $('#selectBoxError2').text('');
            }
        });

        $('#curriculumSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError3').text('First, select a grade');
                // return false; // Prevent the dropdown from opening
            } else {
                $('#selectBoxError3').text('');
            }
        });

    }


    $('#cancelBtn').click(function(){
        restoreInitialForm();
    });


});

</script>

@endsection
