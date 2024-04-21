@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }

    /* .scrollable-card {
        max-height: 400px;
        overflow-y: auto;
    } */
  </style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <!-- left column -->
        <div class="col-md-5 mt-5">
          <!-- general form elements -->
          <div class="card card-primary ">
            <div class="card-header">
              <h3 class="card-title">Add New Holidays</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addHolidaysForm">

              {{-- <input type="hidden" name="academic_id" value="{{$academicYear->id}}"> --}}

              <div class="card-body">

                <div class="form-group">
                    <label for="" class="form-label required">Select Academic Year</label>
                    <select name="academic_id" id="academicYearInputBox" class="form-control">
                        <option value="">Select Academic Year</option>

                        @foreach ($academicYears as $academicYear)
                            <option value="{{$academicYear->id}}">{{$academicYear->academic_year}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="academicYearError"></p>
                </div>


                <div id="dynamicRows">
                    <div class="row">

                        <div class="col-6">
                            <label class="form-label">Name <span class="required"></span></label>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Date<span class="required"></span></label>
                        </div>

                        @foreach ($holidays as $holiday)
                        <input type="hidden" name="holiday_id[]" value="{{$holiday->id}}">
                        <div class="form-group col-6">
                            {{-- <label for="" class="form-label required">Name</label> --}}
                            <input type="text" name="name[]" class="form-control" placeholder="Enter Holiday Name" value="{{$holiday->name}}">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            {{-- <label for="datepicker" class="required">Start Date:</label> --}}
                            <div class="input-group">
                              <input type="text" class="dateInput form-control custom-placeholder changeInputStyle admissionDateClass" name="date[]" value="{{$holiday->date}}">
                              <div class="input-group-append">
                                <span class="input-group-text datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                              </div>
                            </div>
                        </div>
                        @endforeach


                        <div class="form-group col-6">
                            {{-- <label for="" class="form-label required">Name</label> --}}
                            <input type="text" name="name[]" class="form-control" placeholder="Enter Holiday Name">
                            <p class="text-danger name-error"></p>
                        </div>

                        <div class="form-group col-6">
                            {{-- <label for="datepicker" class="required">Start Date:</label> --}}
                            <div class="input-group">
                              <input type="text" class="dateInput form-control custom-placeholder changeInputStyle admissionDateClass" name="date[]"  placeholder="Enter Holiday Date">
                              <div class="input-group-append">
                                <span class="input-group-text datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                              </div>
                            </div>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // inputFieldCount = $("input[name='name[]']").length;
    // console.log(inputFieldCount);

    $('.dateInput').each(function() {
        $(this).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });

    $('.datepicker-icon').click(function() {
        $(this).closest('.form-group').find('.dateInput').datepicker('show');
    });

    var initialFormHTML = $('#addHolidaysForm').html();

    function restoreInitialForm() {
        $('#addHolidaysForm').html(initialFormHTML);
        inputFieldCount = $("input[name='name[]']").length;

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
                        // window.location.href = '{{ route('holidays.index') }}';
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    console.log(response);


                    // var err = eval("(" + xhr.responseText + ")");
                    // var response = JSON.parse(xhr.responseText);
                        // console.log(response);
                    // let academicIdErrorMessage = response.errors.academic_id ? response.errors.academic_id[0] : '';

                    // $('#nameErrorMessage').html(nameErrorMessage);
                    $('#academicYearInputBox').addClass('is-invalid');
                    // $('#academicYearError').html(academicIdErrorMessage);


                    // $('.curriculum-name-error').text('');
                    // $('.teacher-id-error').text('');
                    // $('.form-control').removeClass('is-invalid');

                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            var errorMessage = value[0];

                            var [fieldName, index] = key.split('.');

                            var $row = $('[name="' + fieldName + '[]"]').eq(index).closest('.row');

                            if (fieldName === 'name') {
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
                            <input type="text" name="name[]" class="form-control" placeholder="Enter Holiday Name">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            {{-- <label for="datepicker" class="required">Start Date:</label> --}}
                            <div class="input-group">
                              <input type="text" class="dateInput form-control custom-placeholder changeInputStyle admissionDateClass" name="date[]" placeholder="Enter Holiday Date">
                              <div class="input-group-append">
                                <span class="input-group-text datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                              </div>
                            </div>
                        </div>
                    </div>
                `;



                $("#dynamicRows").append(newRow);
                inputFieldCount++;
                console.log(inputFieldCount);
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
