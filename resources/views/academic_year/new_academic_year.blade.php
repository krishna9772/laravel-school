@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }

    .datepicker {
    font-size: 14px; /* Change font size */
    }
    .datepicker-dropdown:after, .datepicker-dropdown:before {
        display: none !important;
    }

    .custom-placeholder::placeholder {
      font-size: 16px;
    }

    #changeInputStyle {
        text-indent: 8px;
        font-size: 16px;
    }

    #combinedValue:focus {
        outline: none;
        border: none;
    }


  </style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- left column -->
        <form method="POST" action="{{route('academic-years.store')}}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-5 mt-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">New Academic Year</h3>
                        </div>

                        <div class="card-body">

                            <input type="hidden" name="academic_id" value="{{$academicYear ? $academicYear->id : ''}}">

                            <div class="form-group">
                                <label for="" class="form-label required">Academic Year</label>
                                <input type="text" name="academic_year" id="userNameInputBox" value="{{ $academicYear ? $academicYear->academic_year : old('academic_year') }}" class="form-control @error('academic_year') is-invalid @enderror " placeholder="eg. 2024-2025" autocomplete="false">
                                @error('academic_year')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="datepicker" class="required">Start Date:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control custom-placeholder changeInputStyle admissionDateClass" name="start_date"  id="startDate-datepicker" placeholder="Enter Academic Start Date" value="{{ $academicYear ? $academicYear->start_date : old('start_date') }}">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="startDate-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="datepicker" class="required">End Date:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control custom-placeholder changeInputStyle admissionDateClass" name="end_date"  id="endDate-datepicker" placeholder="Enter Academic End Date" value="{{ $academicYear ? $academicYear->end_date : old('end_date') }}">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="endDate-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-primary">
                                <button type="button" class="btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection

@section('scripts')

<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var initialFormHTML = $('#newRegistrationForm').html();

        // Restores the saved initial HTML content of the form
        function restoreInitialForm() {
            $('#newRegistrationForm').html(initialFormHTML);

            attachEventHandlers();
        }

        attachEventHandlers();

        function attachEventHandlers(){

            // var maxDate = new Date();
            // maxDate.setFullYear(maxDate.getFullYear() - 5);

            $('#startDate-datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                // endDate: maxDate
            });

            $('#endDate-datepicker').datepicker({
              format: 'yyyy-mm-dd',
              autoclose: true,
            //   endDate: new Date()
            });


            $('#startDate-datepicker').click(function() {
              $('#startDate-datepicker').datepicker('show');
            });

            $('#endDate-datepicker').click(function() {
              $('#endDate-datepicker').datepicker('show');
            });

            $('#startDate-datepicker-icon').click(function() {
              $('#startDate-datepicker').datepicker('show');
            });

            $('#endDate-datepicker-icon').click(function() {
              $('#endDate-datepicker').datepicker('show');
            });

            function clearError() {

            }
        }
    });



</script>

@endsection
