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
              <h3 class="card-title">Add A New Grade</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addNewGradeForm">
              <div class="card-body">
                <div class="form-group">
                    <label for="" class="form-label required">Name</label>
                    <input type="text" name="name" id="nameInputBox" class="form-control" placeholder="Name of Grade">
                    <p class="text-danger" id="nameErrorMessage"></p>
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
            url: '{{ route('grades.store') }}',
            data: $(this).serialize(),
            success: function (response) {
                if(response == 'success'){
                    window.location.href = '{{ route('grades.index') }}';
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);
                    // console.log(response);
                let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                let descErrorMessage = response.errors.description ? response.errors.description[0] : '';

                // $('#nameErrorMessage').html(nameErrorMessage);
                $('#descErrorMessage').html(descErrorMessage);

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
        $('#nameInputBox').val('');
        $('#descInputBox').val('');
    });


});

</script>

@endsection
