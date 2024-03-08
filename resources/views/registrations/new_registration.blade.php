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


  </style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- left column -->
        <form id="newRegistrationForm">
            <div class="row justify-content-center">
                <div class="col-md-5 mt-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">School Information</h3>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="" class="form-label required">Name</label>
                                <input type="text" name="user_name" id="userNameInputBox" class="form-control" placeholder="Enter User Name">
                                <p class="text-danger" id="userNameErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="required">Select User Type</label>
                                <select name="user_type" id="typeSelect" class="form-control">
                                    <option value="">Select User Type</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                                <p class="text-danger" id="userTypeErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label required">Select Grade</label>
                                <select name="grade_select" id="gradeSelect" class="form-control">
                                    <option value="">Select Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger mt-1" id="selectBoxError1"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label required">Select Class</label>
                                <select name="class_select" id="classSelect" class="form-control">
                                    <option value="">Select Class</option>
                                </select>
                                <p class="text-danger mt-1" id="selectBoxError2"></p>
                            </div>

                            <div class="form-group">
                                <label for="datepicker">Admission Date:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control custom-placeholder changeInputStyle" name="admission_date"  id="adm-datepicker" placeholder="Enter Admission Date">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="adm-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-5">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Other Informations</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Date Of Birth</label>
                                <div class="input-group">
                                  <input type="text" class="form-control custom-placeholder changeInputStyle" name="date_of_birth" id="dob-datepicker" placeholder="Enter Date Of Birth">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="dob-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                                <p class="text-danger" id="dobErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" id="genderSelect" class="form-control">
                                    <option value="">Select User Gender</option>
                                    <option value="male">Male</option>
                                    <option value="femal">Female</option>
                                </select>
                                <p class="text-danger" id="gradeIdErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" id="phoneNumberInpuBox" class="form-control" placeholder="Enter Phone Number">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="addressInputBox" placeholder="Enter Adress"></textarea>
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">NRC</label>
                                <input type="text" name="nrc" id="nrcInputBox" class="form-control" placeholder="Enter User NRC">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Father Name</label>
                                <input type="text" name="father_name" id="fatherNameInputBox" class="form-control" placeholder="Enter User Name">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Mother Name</label>
                                <input type="text" name="mother_name" id="motherNameInputBox" class="form-control" placeholder="Enter Mother Name">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Transfered School</label>
                                <input type="text" name="father_name" id="transferedSchoolInputBox" class="form-control" placeholder="Enter User Name">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-info mr-2">Submit</button>
                                <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
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

        $('#dob-datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        });

        $('#adm-datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        });

        // Trigger Datepicker on icon click
        $('#adm-datepicker-icon').click(function() {
          $('#adm-datepicker').datepicker('show');
        });

        $('#dob-datepicker-icon').click(function() {
          $('#dob-datepicker').datepicker('show');
        });


        $('#typeSelect').change(function() {
            var userType = $(this).val();
            if (userType === 'teacher') {

                $('#fatherNameInputBox').closest('.form-group').hide();
                $('#motherNameInputBox').closest('.form-group').hide();
                $('#transferedSchoolInputBox').closest('.form-group').hide();
            } else {

                $('#fatherNameInputBox').closest('.form-group').show();
                $('#motherNameInputBox').closest('.form-group').show();
                $('#transferedSchoolInputBox').closest('.form-group').show();
            }
        });



        function clearError() {
            $('#gradeSelect').removeClass('is-invalid');
            $('#selectBoxError1').text('');

            $('#classSelect').removeClass('is-invalid');
            $('#selectBoxError2').text('');
        }

        $('#gradeSelect').change(function() {
            clearError();
        });



        $('#cancelBtn').click(function() {
            // $('#selectSection').show();
            // $('#updateClassForm').hide();
        });

        $('#newRegistrationForm').submit(function (e) {
            // alert('hello');
            e.preventDefault();

            // var classId = $('#classId').val();
            // console.log(classId);

            $.ajax({
                type: 'POST',
                url: '{{ route('users.store')}}',
                data: $(this).serialize(),
                success: function (response) {
                    // alert('hello');
                    if(response == 'success'){
                        window.location.href = '{{ route('users.index') }}';
                    }
                    },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var response = JSON.parse(xhr.responseText);
                        console.log(response);
                    let userNameErrorMessage = response.errors.user_name ? response.errors.user_name[0] : '';
                    let userTypeErrorMessage = response.errors.user_type ? response.errors.user_type[0] : '';
                    let gradeSelectErrorMessage = response.errors.grade_select ? response.errors.grade_select[0] : '';
                    let classSelectErrorMessage = response.errors.class_select ? response.errors.class_select[0] : '';
                    let dobErrorMessage = response.errors.date_of_birth ? response.errors.date_of_birth[0] : '';

                    if (userNameErrorMessage) {
                        $('#userNameErrorMessage').html(userNameErrorMessage);
                        $('#userNameInputBox').addClass('is-invalid');
                    } else {
                        $('#userNameErrorMessage').html('');
                        $('#userNameInputBox').removeClass('is-invalid');
                    }


                    if (userTypeErrorMessage) {
                        $('#userTypeErrorMessage').html(userTypeErrorMessage);
                        $('#typeSelect').addClass('is-invalid');
                    } else {
                        $('#userTypeErrorMessage').html('');
                        $('#typeSelect').removeClass('is-invalid');
                    }

                    if(gradeSelectErrorMessage){
                        $('#selectBoxError1').html(gradeSelectErrorMessage);
                        $('#gradeSelect').addClass('is-invalid');
                    }else{
                        $('#selectBoxError1').html('');
                        $('#gradeSelect').removeClass('is-invalid');
                    }

                    if(classSelectErrorMessage){
                        $('#selectBoxError2').html(classSelectErrorMessage);
                        $('#classSelect').addClass('is-invalid');
                    }else{
                        $('#selectBoxError2').html('');
                        $('#classSelect').removeClass('is-invalid');
                    }

                    if(dobErrorMessage){
                        $('#dobErrorMessage').html(dobErrorMessage);
                        $('#dob-datepicker').addClass('is-invalid');
                    }else{
                        $('#dobErrorMessage').html('');
                        $('#dob-datepicker').removeClass('is-invalid');
                    }

                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
        });


        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty(); // Clear previous options
            $('#selectBoxError1').text('');

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
            } else {
                // Filter classes based on selected grade
                var classesFound = false;
                @foreach ($grades as $grade)
                    if ('{{$grade->id}}' === gradeId) {
                        @foreach ($grade->classes as $class)
                            $('#classSelect').append($('<option>', {
                                value: '{{$class->id}}',
                                text : '{{$class->class_name}}'
                            }).attr('data-description', '{{$class->description}}'));
                            classesFound = true;
                        @endforeach
                    }
                @endforeach

                $('#selectBoxError2').text('');

                if (!classesFound) {
                    $('#classSelect').append($('<option>', {
                        value: '',
                        text : 'No Classes in this grade'
                    }));
                }
            }
        });

        $('#classSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError2').text('First select a grade to modify a class');
                // return false; // Prevent the dropdown from opening
            } else {
                $('#selectBoxError2').text('');
            }
        });

    });
</script>

@endsection
