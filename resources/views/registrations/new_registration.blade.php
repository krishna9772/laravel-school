@extends('layouts.app')

@section('styles')
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.549);
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
                                <label for="" class="form-label">Admission Date</label>
                                <input type="date" name="admission_date" id="" class="form-control">
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
                                <label for="" class="form-label">Date Of Birth</label>
                                <input type="date" name="date_of_birth" id="" class="form-control">
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
                                {{-- <input type="text" name="user_name" id="nameInputBox" class="form-control" placeholder="Enter User Name"> --}}
                                <p class="text-danger" id=""></p>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">NRC</label>
                                {{-- <textarea name="address" id="" cols="30" rows="10" placeholder="Enter Adress"></textarea> --}}
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

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[id="reservationdate"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
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
