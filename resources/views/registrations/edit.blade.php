@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }

    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }

    .datepicker {
    font-size: 14px;
    }
    .datepicker-dropdown:after, .datepicker-dropdown:before {
        display: none !important;
    }

    .custom-placeholder::placeholder {
      font-size: 16px;
    }
  </style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- left column -->
        <form id="updateRegistrationForm">
            @csrf
            @method('PATCH')

            <input type="hidden" name="user_id" id="idInputBox" value="{{$data->user_id}}">

            <div class="row justify-content-center">
                <div class="col-md-5 mt-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">School Information</h3>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="" class="form-label required">Name</label>
                                <input type="text" name="user_name" id="userNameInputBox" class="form-control" placeholder="Enter User Name" value="{{$data->user_name}}">
                                <p class="text-danger" id="userNameErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="required">Select User Type</label>
                                <select name="user_type" id="typeSelect" class="form-control">
                                    <option value="">Select User Type</option>
                                    <option value="student"  @if($data->user_type == 'student') selected @endif>Student</option>
                                    <option value="teacher" @if($data->user_type == 'teacher') selected @endif>Teacher</option>
                                </select>
                                <p class="text-danger" id="userTypeErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label required">Email</label>
                                <input type="email" name="email" id="emailInputBox" class="form-control" placeholder="Enter User Email">
                                <p class="text-danger" id="emailErrorMessage"></p>
                            </div>

                            <div class="row">
                                <div class="form-group col mr-1">
                                    <label for="" class="form-label required">Password</label>
                                    <input type="password" name="password" id="passwordInputBox" class="form-control" placeholder="Enter User Password">
                                    <p class="text-danger" id="passwordErrorMessage"></p>
                                </div>

                                <div class="form-group col pl-0">
                                    <label for="" class="required">Confirm Password</label>
                                    <input type="password" name="password" id="passwordInputBox" class="form-control" placeholder="Retype Password">
                                    <p class="text-danger" id="passwordErrorMessage"></p>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="" class="form-label required">Select Grade</label>
                                <select name="grade_select" id="gradeSelect" class="form-control">
                                    <option value="" >Select Grade</option>

                                    @if(count($data->userGradeClasses) == 0)
                                        @foreach ($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                                        @endforeach
                                    @else

                                        @foreach ($grades as $grade)
                                            @php
                                                $selected = '';
                                                if (!empty($data->userGradeClasses) && count($data->userGradeClasses) > 0) {
                                                    $selected = ($data->userGradeClasses[0]->grade_id == $grade->id) ? 'selected' : '';
                                                }
                                            @endphp
                                            <option value="{{$grade->id}}" {{$selected}}>{{$grade->grade_name}}</option>
                                        @endforeach
                                    @endif
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

                            <div class="form-group student-fields">
                                <label for="datepicker">Admission Date:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control custom-placeholder changeInputStyle admissionDateClass" value="{{$data->admission_date}}" name="admission_date"  id="adm-datepicker" placeholder="Enter Admission Date">
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
                                  <input type="text" class="form-control custom-placeholder changeInputStyle" value="{{$data->date_of_birth}}" name="date_of_birth" id="dob-datepicker" placeholder="Enter Date Of Birth">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="dob-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>


                            {{-- <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" id="genderSelect" class="form-control">
                                    <option value="">Select User Gender</option>
                                    <option value="male" @if($data->gender == 'male') selected @endif>Male</option>
                                    <option value="femal" @if($data->gender == 'female') selected @endif>Female</option>
                                </select>
                                <p class="text-danger" id="gradeIdErrorMessage"></p>
                            </div> --}}

                            <div class="form-group">
                                <label for="">Gender</label>
                                <div class="d-flex">
                                    <div class=" mr-5">
                                        <input type="radio" class="mr-1" name="gender" id="male" value="male"  @if($data->gender == 'male') checked @endif>
                                        <span>Male</span>
                                    </div>
                                    <div>
                                        <input type="radio" class="mr-1" name="gender" id="female" value="female"  @if($data->gender == 'female') checked @endif>
                                        <span>Female</span>
                                    </div>
                                </div>

                                <p class="text-danger" id="gradeIdErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" value="{{$data->phone_number}}" id="phoneNumberInpuBox" class="form-control" placeholder="Enter Phone Number">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="addressInputBox" placeholder="Enter Address">{{$data->address}}</textarea>
                                {{-- <input type="text" name="user_name" id="nameInputBox" class="form-control" placeholder="Enter User Name"> --}}
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">NRC</label>
                                <input type="text" name="nrc" value="{{$data->nrc}}" id="nrcInputBox" class="form-control" placeholder="Enter User NRC">
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group student-fields">
                                <label for="fatherNameInputBox" class="form-label">Father Name</label>
                                <input type="text" name="father_name" value="{{$data->father_name}}" id="fatherNameInputBox" class="form-control" placeholder="Enter Father Name">
                                <p class="text-danger" id="fatherNameError"></p>
                            </div>
                            <div class="form-group student-fields">
                                <label for="motherNameInputBox" class="form-label">Mother Name</label>
                                <input type="text" name="mother_name" value="{{$data->mother_name}}" id="motherNameInputBox" class="form-control" placeholder="Enter Mother Name">
                                <p class="text-danger" id="motherNameError"></p>
                            </div>
                            <div class="form-group student-fields">
                                <label for="transferedSchoolInputBox" class="form-label">Transferred School</label>
                                <input type="text" name="former_school" value="{{$data->former_school}}" id="transferedSchoolInputBox" class="form-control" placeholder="Enter Former School">
                                <p class="text-danger" id="transferedSchoolError"></p>
                            </div>


                            <div class="">
                                <button type="submit" class="btn btn-info mr-2">Update</button>
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

    var initialFormHTML = $('#updateRegistrationForm').html();

    // Restores the saved initial HTML content of the form
    function restoreInitialForm() {
        $('#updateRegistrationForm').html(initialFormHTML);

        attachEventHandlers();
    }

    attachEventHandlers();

    function attachEventHandlers(){
        var maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() - 5);

        $('#dob-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            endDate: maxDate // Disable selecting dates more than five years from today
        });

        $('#adm-datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          endDate: new Date()
        });

        $('#adm-datepicker-icon').click(function() {
          $('#adm-datepicker').datepicker('show');
        });

        $('#dob-datepicker-icon').click(function() {
          $('#dob-datepicker').datepicker('show');
        });


        var initialGradeId = $('#gradeSelect').val();
        var initialClassId = "{{ $data->userGradeClasses->isEmpty() ? '' : $data->userGradeClasses[0]->class_id }}";
        updateClassOptions(initialGradeId, initialClassId);

        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            updateClassOptions(gradeId, '');
        });

        function updateClassOptions(gradeId, selectedClassId) {
            $('#classSelect').empty();

            if (gradeId === '') {
                $('#classSelect').append($('<option>', {
                    value: '',
                    text: 'Select Class',
                }));
                return;
            }

            @foreach ($grades as $grade)
            if ('{{$grade->id}}' === gradeId) {
                @foreach ($grade->classes as $class)
                    // console.log({{$class->id}});

                var selected = selectedClassId == '{{$class->id}}';
                console.log(selectedClassId);
                $('#classSelect').append($('<option>', {
                    value: '{{$class->id}}',
                    text: '{{$class->class_name}}',
                    selected: selected
                }));
                @endforeach
            }
            @endforeach

            if ($('#classSelect option').length === 0) {
                $('#classSelect').append($('<option>', {
                    value: '',
                    text: 'No Classes in this grade'
                }));
            }
        }

        $('#typeSelect').change(function() {
            var userType = $(this).val();
            if (userType === 'student') {
                $('.student-fields').show();
            } else {
                $('.student-fields').hide();
            }
        });

        var userTypeFromServer = "{{ $data->user_type }}";
        if (userTypeFromServer !== 'teacher') {
            $('.student-fields').show();
        } else {
            $('.student-fields').hide();
        }


        $('#typeSelect').change(function() {
            var userType = $(this).val();
            if (userType === 'teacher') {
                $('.admissionDateClass').closest('.form-group').hide();
                $('#fatherNameInputBox').closest('.form-group').hide();
                $('#motherNameInputBox').closest('.form-group').hide();
                $('#transferedSchoolInputBox').closest('.form-group').hide();
            } else {
                $('.admissionDateClass').closest('.form-group').show();
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

        $('#updateRegistrationForm').submit(function (e) {
            // alert('hello');
            e.preventDefault();

            var userId = $('#idInputBox').val();

            // console.log(classId);

            $.ajax({
                type: 'POST',
                url: '{{ route('users.update', ['user' => ':user']) }}'.replace(':user', userId),
                data: $(this).serialize(),
                success: function (response) {
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

                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
        });

        $('#classSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError2').text('First select a grade');
            } else {
                $('#selectBoxError2').text('');
            }
        });

        $('#cancelBtn').click(function() {
            restoreInitialForm();
        });
    }

    $('#cancelBtn').click(function() {
        restoreInitialForm();
    });

});
</script>

@endsection
