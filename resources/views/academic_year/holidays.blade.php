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
              <h3 class="card-title">Add New Holidays</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addHolidaysForm">

              <input type="hidden" name="academic_id" value="{{$academicYear->id}}">

              <div class="card-body">

                <div id="dynamicRows">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Name</label>
                            <input type="text" name="name[]" class="form-control" placeholder="Enter Holiday Name">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Date</label>
                            <input type="date" name="date[]" class="form-control" id="" placeholder="Enter Holiday Date">
                            <p class="text-danger mt-1 date-error"></p>
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

    var initialFormHTML = $('#addHolidaysForm').html();

    function restoreInitialForm() {
        $('#addHolidaysForm').html(initialFormHTML);
        inputFieldCount = $("input[name='curriculum_name[]']").length;

        attachEventHandlers();
    }

    attachEventHandlers();

    function attachEventHandlers(){


        $('#nameInputBox').on('input', function () {
            clearNameInputBoxError();
        });


        function clearNameInputBoxError() {
            $('#nameInputBox').removeClass('is-invalid');
            $('#nameErrorMessage').text('');
        }


        $('#addHolidaysForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route('holidays.store') }}',
                data: $(this).serialize(),
                success: function (response) {
                    if(response == 'success'){
                        window.location.href = '{{ route('holidays.index') }}';
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    console.log(response);



                    $('.curriculum-name-error').text('');
                    $('.teacher-id-error').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            var errorMessage = value[0];

                            var [fieldName, index] = key.split('.');

                            var $row = $('[name="' + fieldName + '[]"]').eq(index).closest('.row');

                            if (fieldName === 'curriculum_name') {
                                $row.find('.name-error').text('Holiday Name is required');
                                $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                            } else if (fieldName === 'teacher_id') {
                                $row.find('.date-error').text('Date field is required');
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

        // function toggleButtons() {
        //     if (inputFieldCount >= 5) {
        //         $("#addMoreBtn").prop("disabled", true);
        //     } else {
        //         $("#addMoreBtn").prop("disabled", false);
        //     }
        // }

        $("#addMoreBtn").click(function() {
            // if (inputFieldCount < 5) {
                var newRow = `
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Name</label>
                            <input type="text" name="name[]" class="form-control" placeholder="Enter Holiday Name">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="form-label required">Date</label>
                            <input type="date" name="date[]" class="form-control" id="" placeholder="Enter Holiday Date">
                            <p class="text-danger mt-1 date-error"></p>
                        </div>
                    </div>
                `;



                $("#dynamicRows").append(newRow);
                inputFieldCount++;
            //     toggleButtons();
            // }
        });


        $("#removeBtn").click(function () {
            if (inputFieldCount > 1) {
                $("#dynamicRows .row:last-child").remove();
                inputFieldCount--;
                // toggleButtons();
            }
        });

        // toggleButtons();

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
