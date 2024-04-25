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
                @if ($gradeIdParameter == null)
                    <h3 class="card-title">Add A New Class</h3>
                @else
                    <h3 class="card-title">Add New Class In {{$gradeName}} </h3>
                @endif

            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addNewGradeForm">
              <div class="card-body">
                @if ($gradeIdParameter == null)
                    <div class="form-group">
                        <label for="" class="form-label required">Select Grade</label>
                        <select name="grade_id" id="gradeSelect" class="form-control">
                            <option value="">Select Grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                            @endforeach
                        </select>
                        <p class="text-danger" id="gradeIdErrorMessage"></p>
                    </div>
                @else
                    <input type="hidden" name="grade_id" value="{{$gradeIdParameter}}">
                @endif

                {{-- =============== --}}

                <p class="text-danger mt-1" id="selectBoxError"></p>
                <div class="form-group">
                    <label for="" class="form-label required">Name</label>
                    <input type="text" name="name" id="nameInputBox" class="form-control" placeholder="Enter Class Name">
                    <p class="text-danger" id="nameErrorMessage"></p>
                    <p class="text-danger" id="uniqueClassNameErrorMessage"></p>
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Description</label>
                    <textarea name="description" id="descInputBox" class="form-control" placeholder="Enter Description">{{ old('description') }}</textarea>
                    <p class="text-danger" id="descErrorMessage"></p>
              </div>

              <!-- /.card-body -->
              <div class="">
                <button type="submit" class="btn btn-info mr-2">Save</button>
                <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
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

    $('#addNewGradeForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ route('classes.store') }}',
            data: $(this).serialize(),
            success: function (response) {
                if(response == 'success'){
                    window.location.href = '{{ route('classes.index') }}';
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);

                console.log(response);

                var uniqueClassNameErrorMessage = xhr.responseJSON.error;
                // alert(errorMessage);
                // classNameUniqueErroMessage
                if(uniqueClassNameErrorMessage){
                    $('#nameErrorMessage').html(uniqueClassNameErrorMessage);
                    $('#nameInputBox').addClass('is-invalid');
                }else{
                    $('#nameErrorMessage').html('');
                    $('#nameInputBox').removeClass('is-invalid');
                }

                let gradeIdErrorMessage = response.errors.grade_id ? response.errors.grade_id[0] : '';
                let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                let descErrorMessage = response.errors.description ? response.errors.description[0] : '';

                if (gradeIdErrorMessage) {
                    $('#gradeIdErrorMessage').html(gradeIdErrorMessage);
                    $('#gradeSelect').addClass('is-invalid');
                } else {
                    $('#gradeIdErrorMessage').html('');
                    $('#gradeSelect').removeClass('is-invalid');
                }

                if (nameErrorMessage) {
                    $('#nameErrorMessage').html(nameErrorMessage);
                    $('#nameInputBox').addClass('is-invalid');
                } else {
                    $('#nameErrorMessage').html('');
                    $('#nameInputBox').removeClass('is-invalid');
                }

                if (descErrorMessage) {
                    $('#descErrorMessage').html(descErrorMessage);
                    $('#descInputBox').addClass('is-invalid');
                } else {
                    $('#descErrorMessage').html('');
                    $('#descInputBox').removeClass('is-invalid');
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
