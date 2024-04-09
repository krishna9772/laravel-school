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
              <h3 class="card-title">Add New Subject</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addCurriculumForm">

              <div class="card-body">

                <div class="form-group">
                    <label for="" class="form-label required">Select Grade</label>
                    <select name="grade_id" id="gradeSelect" class="form-control">
                        <option value="">Select Grade</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="gradeSelectBoxError"></p>
                </div>

                <div id="dynamicRows">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Subject</label>
                            <input type="text" name="curriculum_name[]" class="form-control" placeholder="Enter Subject Name">
                            <p class="text-danger curriculum-name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Select Teacher</label>
                            <select name="teacher_id[]" class="form-control teacherSelect">
                                <option value="">Select Teacher</option>
                            </select>
                            <p class="text-danger mt-1 teacher-id-error"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" id="addMoreBtn" class="btn btn-success"><i class="fa fa-plus"></i> Add More</button>
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

        function clearDescInputBoxError() {
            $('#descInputBox').removeClass('is-invalid');
            $('#gradeSelectBoxError').text('');
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
                                $row.find('.curriculum-name-error').text('Subject name is required');
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
                            <select name="teacher_id[]" class="form-control teacherSelect">
                                <option value="">Select Teacher</option>
                            </select>
                            <p class="text-danger mt-1 teacher-id-error"></p> <!-- Unique ID for error message -->
                        </div>
                    </div>
                `;
                $("#dynamicRows").append(newRow);
                inputFieldCount++;
                toggleButtons();
            }
        });


        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('.teacherSelect').empty(); // Clear previous options
            $('#selectBoxError1').text('');


            if (gradeId === '') {
                // If 'Select Grade' is selected, show 'Select Class' in class select box
                $('.teacherSelect').append($('<option>', {
                    value: '',
                    text : 'Select Teacher',
                }));
            } else {
                // Filter classes based on selected grade
                var teachersFound = false;
                @foreach ($teachers as $teacher)
                    @foreach ($teacher->userGradeClasses as $gradeClass)
                        if ('{{ $gradeClass->grade_id }}' === gradeId) {
                            $('.teacherSelect').append($('<option>', {
                                value: '{{ $teacher->id }}',
                                text : '{{ $teacher->user_name }}'
                            }));
                            teachersFound = true;
                        }
                    @endforeach
                @endforeach

                $('#selectBoxError2').text('');
                $('#selectBoxError3').text('');

                if (!teachersFound) {
                    $('.teacherSelect').append($('<option>', {
                        value: '',
                        text : 'No Teachers in this grade'
                    }));
                }
            }
        });

        $('.teacherSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError2').text('First, select a grade');
                // return false; // Prevent the dropdown from opening
            } else {
                $('#selectBoxError2').text('');
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
    }


    $('#cancelBtn').click(function(){
        restoreInitialForm();
    });


});

</script>

@endsection
