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
              <h3 class="card-title">Add New Curriculum</h3>
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


                <div class="form-group">
                    <label for="" class="form-label required">Curriculum Name</label>
                    <input type="text" name="curriculum_name" id="nameInputBox" class="form-control" placeholder="Enter Curriculum Name">
                    <p class="text-danger" id="nameErrorMessage"></p>
                </div>

                <div class="form-group">
                    <label for="" class="form-label required">Select Teacher</label>
                    <select name="teacher_id" id="teacherSelect" class="form-control">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{$teacher->user_id}}">{{$teacher->user_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="teacherSelectBoxError"></p>
                </div>

                <div class="form-group">
                    <button class="btn btn-success"><i class="fa fa-plus"></i> Add More</button>
                    <button class="btn btn-danger"> <i class="fa fa-minus"></i> Remove</button>
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

    $('#descInputBox').on('input', function () {
        clearDescInputBoxError();
    });

    function clearNameInputBoxError() {
        $('#nameInputBox').removeClass('is-invalid');
        $('#nameErrorMessage').text('');
    }

    function clearDescInputBoxError() {
        $('#descInputBox').removeClass('is-invalid');
        $('#descErrorMessage').text('');
    }

    // Event handler for input fields to clear error message and remove 'is-invalid' class



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
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);
                    // console.log(response);
                let gradeSelectBoxError = response.errors.grade_id ? response.errors.grade_id[0] : '';
                let nameErrorMessage = response.errors.curriculum_name ? response.errors.curriculum_name[0] : '';
                let teacherSelectBoxError = response.errors.teacher_id ? response.errors.teacher_id[0] : '';

                if (gradeSelectBoxError) {
                    $('#gradeSelectBoxError').html(gradeSelectBoxError);
                    $('#gradeSelect').addClass('is-invalid');
                } else {
                    $('#gradeSelectBoxError').html('');
                    $('#gradeSelect').removeClass('is-invalid');
                }

                if (nameErrorMessage) {
                    $('#nameErrorMessage').html(nameErrorMessage);
                    $('#nameInputBox').addClass('is-invalid');
                } else {
                    $('#nameErrorMessage').html('');
                    $('#nameInputBox').removeClass('is-invalid');
                }

                if (teacherSelectBoxError) {
                    $('#teacherSelectBoxError').html(teacherSelectBoxError);
                    $('#teacherSelect').addClass('is-invalid');
                } else {
                    $('#teacherSelectBoxError').html('');
                    $('#teacherSelect').removeClass('is-invalid');
                }

            },
            failure: function (response) {
                console.log('faliure');
            }
        });
    });

    $('#cancelBtn').click(function(){
        $('#gradeSelect').val('');
        $('#nameInputBox').val('');
        $('#descInputBox').val('');
    });


});

</script>

@endsection
