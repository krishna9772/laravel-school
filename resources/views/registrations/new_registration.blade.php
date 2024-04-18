@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
{{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script> --}}

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
        <form id="newRegistrationForm">
            <div class="row justify-content-center">
                <div class="col-md-5 mt-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Personal Information</h3>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="" class="form-label required">Name</label>
                                <input type="text" name="user_name" id="userNameInputBox" class="form-control" placeholder="Enter User Name" autocomplete="false">
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
                                <label for="" class="required">Email</label>
                                <input type="email" name="email" id="emailInputBox" class="form-control" placeholder="Enter User Email">
                                <p class="text-danger" id="emailErrorMessage"></p>
                            </div>

                            <div class="row">
                                <div class="form-group col mr-1">
                                    <label for="" class="form-label required">Password</label>
                                    <input type="password" name="password" id="passwordInputBox" class="form-control" placeholder="Enter User Password" autocomplete="false">
                                    <p class="text-danger" id="passwordErrorMessage"></p>
                                </div>

                                <div class="form-group col pl-0">
                                    <label for="" class="required">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirmPasswordInputBox" class="form-control" placeholder="Retype Password">
                                    <p class="text-danger" id="confirmPasswordErrorMessage"></p>
                                </div>
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
                                  <input type="text" class="form-control custom-placeholder changeInputStyle admissionDateClass" name="admission_date"  id="adm-datepicker" placeholder="Enter Admission Date">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="adm-datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="" class="required">Select Teacher Type</label>
                                <select name="teacher_type" id="teacherTypeSelect" class="form-control">
                                    <option value="">Select Teacher Type</option>
                                    <option value="subject">Subject</option>
                                    <option value="classroom">Classroom</option>
                                </select>
                                <p class="text-danger" id="teacherTypeErrorMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-5">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Other Information</h3>
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
                                <div class="d-flex">
                                    <div class=" mr-5">
                                        <input type="radio" class="mr-1" name="gender" id="male" value="male">
                                        <span>Male</span>
                                    </div>
                                    <div>
                                        <input type="radio" class="mr-1" name="gender" id="female" value="female">
                                        <span>Female</span>
                                    </div>
                                </div>

                                <p class="text-danger" id="gradeIdErrorMessage"></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" id="phoneNumberInpuBox" class="form-control" placeholder="Enter Phone Number" onkeypress='validate(event)'>
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="addressInputBox" placeholder="Enter Address"></textarea>
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group mb-3" id="nrc_form">
                                <label for=""> NRC</label>

                                <div class="row mt-2">
                                    <div class="col">
                                        <label for="">Number</label>
                                        <select id="region" class="form-control">
                                            <option selected disabled>Options</option>
                                            {{-- <option value=1>၁</option>
                                            <option value=2>၂</option>
                                            <option value=3>၃</option>
                                            <option value=4>၄</option>
                                            <option value=5>၅</option>
                                            <option value=6>၆</option>
                                            <option value=7>၇</option>
                                            <option value=8>၈</option>
                                            <option value=9>၉</option>
                                            <option value=10>၁၀</option>
                                            <option value=11>၁၁</option>
                                            <option value=12>၁၂</option>
                                            <option value=13>၁၃</option>
                                            <option value=14>၁၄</option> --}}
                                            <option value=1>1</option>
                                            <option value=2>2</option>
                                            <option value=3>3</option>
                                            <option value=4>4</option>
                                            <option value=5>5</option>
                                            <option value=6>6</option>
                                            <option value=7>7</option>
                                            <option value=8>8</option>
                                            <option value=9>9</option>
                                            <option value=10>10</option>
                                            <option value=11>11</option>
                                            <option value=12>12</option>
                                            <option value=13>13</option>
                                            <option value=14>14</option>


                                        </select>
                                    </div>
                                    <div class="col">
                                            <label for="code" class="">
                                                {{-- မြို့နယ် --}}
                                                Township
                                            </label>
                                            <select id="code" class="form-control">
                                            </select>
                                    </div>
                                    <div class="col">
                                        <label for="number_type" class="">
                                            {{-- အမျိုးအစား --}} Type
                                        </label>
                                            <select id="number_type" class="form-control">
                                              {{-- <option value="(နိုင်)">နိုင်</option>
                                              <option value="(ဧည့်)">ဧည့်</option>
                                              <option value="(ပြု)">ပြု</option> --}}
                                              <option value="N">N</option>
                                              <option value="E">E</option>
                                              <option value="P">P</option>

                                          </select>
                                    </div>
                                    <div class="col">
                                        <div class="mb-6">
                                            <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number</label>
                                            <input type="text" id="number" maxlength="6" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-danger" id="nrcError"></p>

                                {{-- <input type="text" name="nrc" id="" class="form-control"> --}}
                            </div>

                            <input type="text" id="combinedValue" class="form-control border-0 pl-0 mb-2 bg-white" style="display: none; outline:none" readonly>
                            <input type="hidden" name="nrc" id="nrcNumber">

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
                                <button type="submit" class="btn btn-info mr-2">Register</button>
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


        var initialFormHTML = $('#newRegistrationForm').html();

        // Restores the saved initial HTML content of the form
        function restoreInitialForm() {
            $('#newRegistrationForm').html(initialFormHTML);

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

            // Trigger Datepicker on icon click
            $('#adm-datepicker-icon').click(function() {
              $('#adm-datepicker').datepicker('show');
            });

            $('#dob-datepicker-icon').click(function() {
              $('#dob-datepicker').datepicker('show');
            });

            $('#region').change(fetchNrc);

            $('#combinedValue').on('focus', function() {
                $(this).css('border', 'none');
                $(this).css('outline','none');
            });

            $('#region, #code, #number_type, #number').on('input', showNRCNumber);

            //show nrc number
            function showNRCNumber(){

                var code = $('#code').val();
                var number = $('#number').val();

                const region = $('#region').val();
                const numberType = $('#number_type').val();
                const newMMNumber = enToMM(region);
                const newSelectedCode = code ? code : '----';

                function enToMM(value) {
                    // const mmNumbers = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉", "၁၀", "၁၁", "၁၂", "၁၃", "၁၄"];
                    const mmNumbers = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14'];
                    return mmNumbers.find((mmNumber, key) => key == value);
                }

                // function getNRC(value) {
                //     return value.substring(1, 4);
                // }



                var combinedValue = newMMNumber + '/' + newSelectedCode + '( '+numberType+' )' + number;
                $('#combinedValue').show();
                $('#combinedValue').val('NRC - ' +  combinedValue);
                $('#nrcNumber').val(combinedValue);
            }


            $('#typeSelect').change(function() {
                var userType = $(this).val();
                if (userType === 'teacher') {
                    $('.admissionDateClass').closest('.form-group').hide();
                    $('#fatherNameInputBox').closest('.form-group').hide();
                    $('#motherNameInputBox').closest('.form-group').hide();
                    $('#transferedSchoolInputBox').closest('.form-group').hide();
                    $('#teacherTypeSelect').closest('.form-group').show();
                    $('#nrc_form').show();
                } else {
                    $('.admissionDateClass').closest('.form-group').show();
                    $('#fatherNameInputBox').closest('.form-group').show();
                    $('#motherNameInputBox').closest('.form-group').show();
                    $('#transferedSchoolInputBox').closest('.form-group').show();
                    $('#teacherTypeSelect').closest('.form-group').hide();
                    $('#nrc_form').hide();

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

            function fetchNrc() {
                  const selectedRegion = document.getElementById('region').value;

                      // Fetch data based on the selected region
                  fetch("https://raw.githubusercontent.com/htetoozin/Myanmar-NRC/master/nrc.json")
                  .then(response => response.json())
                  .then(({data}) => {
                      const nrcs = data.filter(region => region.nrc_code === selectedRegion)
                     // Update the second dropdown with fetched results
                      const resultsDropdown = document.getElementById('code');
                            // Clear previous options
                            resultsDropdown.innerHTML = '';

                          // Add new options based on fetched data
                          nrcs.forEach(item => {
                              const option = document.createElement('option');
                              option.value = item.name_en;
                              option.text = item.name_en;
                              resultsDropdown.add(option);
                          });
                    })
                  .catch(error => console.error('Error fetching data:', error));
              }

            $('#newRegistrationForm').submit(function (e) {

                  e.preventDefault();


                    validateAndProcessInput();

                    function validateAndProcessInput() {
                        var code = $('#code').val();
                        var number = $('#number').val();

                        // console.log(number.length);

                        // Check if any of the required fields are filled
                        if (!code && !number) {
                            // None of the required fields are filled, so return without performing any validation or processing
                            return;
                        }

                        if (!code || !number) {
                            // $('#nrcError').html('မြို့နယ်နှင့် နံပါတ်ကို ထည့်ပေးပါ');
                            $('#nrcError').html('Pleaes Select Township Code');
                            return false; // Return false to prevent form submission
                        } else {
                            $('#nrcError').html('');
                        }

                        if(number.length != 6){
                            // $('#nrcError').html('မှတ်ပုံတင်နံပါတ် မှားနေပါသည်။');
                            $('#nrcError').html('Wrong Nrc number');
                            console.log('မှတ်ပုံတင်နံပါတ် မှားနေပါသည်။');
                            return false;
                        } else{
                            $('#nrcError').html('');
                        }

                        function enToMM(value) {
                            // const mmNumbers = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉", "၁၀", "၁၁", "၁၂", "၁၃", "၁၄"];
                            const mmNumbers = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14'];

                            return mmNumbers.find((mmNumber, key) => key == value);
                        }

                        // function getNRC(value) {
                        //     return value.substring(1, 7);
                        // }

                        const region = $('#region').val();
                        const numberType = $('#number_type').val();
                        const newMMNumber = enToMM(region);
                        const newSelectedCode = code;

                        var combinedValue = newMMNumber + '/' + newSelectedCode + '( '+numberType+' )' + number;
                        $('#combinedValue').show();
                        $('#combinedValue').val('NRC - ' +  combinedValue);

                        return true; // Return true to allow form submission



                    }



                $.ajax({
                    type: 'POST',
                    url: '{{ route('users.store')}}',
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
                        let emailErrorMessage = response.errors.email ? response.errors.email[0] : '';
                        let passwordErrorMessage = response.errors.password ? response.errors.password[0] : '';
                        let confirmPasswordErrorMessage = response.errors.confirm_password ? response.errors.confirm_password[0] : '';
                        let userTypeErrorMessage = response.errors.user_type ? response.errors.user_type[0] : '';
                        let gradeSelectErrorMessage = response.errors.grade_select ? response.errors.grade_select[0] : '';
                        let classSelectErrorMessage = response.errors.class_select ? response.errors.class_select[0] : '';
                        let dobErrorMessage = response.errors.date_of_birth ? response.errors.date_of_birth[0] : '';
                        let teacherTypeErrorMessage = response.errors.teacher_type ? response.errors.teacher_type[0] : '';

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

                        if (emailErrorMessage) {
                            $('#emailErrorMessage').html(emailErrorMessage);
                            $('#emailInputBox').addClass('is-invalid');
                        } else {
                            $('#emailErrorMessage').html('');
                            $('#emailInputBox').removeClass('is-invalid');
                        }

                        if (passwordErrorMessage) {
                            $('#passwordErrorMessage').html(passwordErrorMessage);
                            $('#passwordInputBox').addClass('is-invalid');
                        } else {
                            $('#passwordErrorMessage').html('');
                            $('#passwordInputBox').removeClass('is-invalid');
                        }

                        if (confirmPasswordErrorMessage) {
                            $('#confirmPasswordErrorMessage').html(confirmPasswordErrorMessage);
                            $('#confirmPasswordInputBox').addClass('is-invalid');
                        } else {
                            $('#confirmPasswordErrorMessage').html('');
                            $('#confirmPasswordInputBox').removeClass('is-invalid');
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

                        if(teacherTypeErrorMessage){
                            $('#teacherTypeErrorMessage').html(teacherTypeErrorMessage);
                            $('#teacherTypeSelect').addClass('is-invalid');
                        }else{
                            $('#teacherTypeErrorMessage').html('');
                            $('#teacherTypeSelect').removeClass('is-invalid');
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

            $('#cancelBtn').click(function() {
                restoreInitialForm();
            });

        }

        $('#cancelBtn').click(function() {
            restoreInitialForm();
        });

    });

    
    function validate(evt) {

        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
        // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }

    }
</script>

@endsection
