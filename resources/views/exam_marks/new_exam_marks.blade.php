@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

<style>
    .badge {
        cursor: pointer;
      }
      .badge-green {
        background-color: green !important;
      }
      .badge-red {
        background-color: red !important;
      }
      .badge-yellow {
        background-color: yellow !important;
      }

      .input-container {
        position: relative;
        margin-bottom: 1.5rem;
        }

        .input-container input {
        width: 80%;
        padding: 0.5rem;
        border: 2px solid #888;
        border-radius: 5px;
        font-size: 1rem;
        }

        .input-container label {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #888;
        transition: all 0.3s ease;
        pointer-events: none;

        }

        .input-container input:focus + label,
        .input-container input:not(:placeholder-shown) + label {
            font-size: 0.75rem;
            top: 0;
            color: #333;
        }

        .badge-success:hover{
            cursor: pointer;
        }

        .error{
        outline: 1px solid red;
    }

  </style>
@endsection

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

         <div class="d-flex justify-content-between mb-4">
             <h3 class="text-capitalize">{{$gradeName}} / {{$className}} - Exam Marks</h3>

             {{-- <input type="date" class=" form-control" style="width: 12%" id="dateInput" value="{{today()}}"> --}}
             <label for="exampleInputFile" class="mt-2" id="date-exam">


                <input type="month" id="time" data-value= {{ date('Y-m', strtotime(today())) }} class="text-sm" value="{{ date('Y-m', strtotime(today())) }}"/>

                {{-- <small id="month-value">{{ date('Y-m', strtotime(today())) }}</small> --}}
            </label>

         </div>


         <div class="">

                <table id="studentsTable" class="w-100 my-3 table table-striped" >
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Student ID</th>
                            <th class="text-center">Student Name</th>
                            <th class="text-center">Father Name</th>
                            <th class="">Exam Marks</th>
                            {{-- <th class="text-center"></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1 @endphp
                        @foreach ($students as $student)
                            <?php
                                // dd('user grade class id is ' . $student->userGradeClasses[0]->id);
                            ?>
                            <div class="userList">
                            <tr>
                                <input type="hidden" name="user_grade_class_id" value="{{$student->userGradeClasses[0]->id}}">
                                <td class="text-center col-1">{{ $count++ }}</td>
                                <td class="text-center">{{$student->user_id}}</td>
                                <td class="text-center">{{ $student->user_name }}</td>
                                <td class="text-center">{{$student->father_name}}</td>
                                <td class="col-3 text-center">

                                    <?php
                                        // dd($student->userGradeClasses[0]->examMarks[0]->file);
                                    ?>

                                    <div class="form-group d-flex-column ">

                                        <div class="input-group ml-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">
                                                    {{ $student->userGradeClasses[0]->examMarks[0]->file ?? 'Choose File' }}
                                                </label>

                                            </div>

                                        </div>
                                        {{-- <a type="button" class="nav-link border-0" data-toggle="modal" data-target="#subject_marks">
                                            <label class="badge badge-success text-white"><i class="fas fa-plus"></i> Add</label>

                                        </a>

                                        <a type="button" class="nav-link border-0" data-toggle="modal" data-target="#subject_marks" id="subjectmark" hidden>

                                            <label for="exam-result" class="badge badge-success"><i class="fas fa-calendar"></i>  Results</label>

                                        </a> --}}
                                        @if($student->userGradeClasses[0]->examMarks[0]->file != '')
                                            {{-- <iframe src="{{ asset('storage/app/public/exam_marks_files/') }}/{{ $student->userGradeClasses[0]->examMarks[0]->file }}"  width="50" height="50"></iframe> --}}
                                                <a class="nav-icon" href="{{asset('storage/exam_marks_files/'. $student->userGradeClasses[0]->examMarks[0]->file)}}" download>
                                                    <span class="badge badge-success"><i class="fas fa-file-download fa-2x"></i></span>
                                                </a>
                                            @else

                                            @endif
                                    </div>




                                    {{-- <input type="file" name="" id="" class="form-control" style="width: 60%"> --}}
                                </td>

                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>

                    <div class="modal fade" id="subject_marks">
                      <div class="modal-dialog">
                        <div class="modal-content">
                                <div class='modal-header'>
                                    <p class='col-12 modal-title text-center'>
                                    <span class="ml-5" style="font-size: 17px">Subject Marks</span>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                    </p>
                                </div>
                                <form id="subjectMarksForm">
                                    <div class="modal-body py-4">


                                        @php
                                            $count = 1;
                                            @endphp
                                    <div class="row">

                                        @foreach($gradeResult as $row)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="subjects[]" id="subjects" placeholder="eg: English" value={{$row->subject}} readonly>
                                                        <input type="hidden" name="user_grade_class_id" value="{{$student->userGradeClasses[0]->id}}">

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group required">
                                                        <input type="text" class="form-control" name="marks[]" id="marks" placeholder="eg: 80" onkeypress='validate(event)' required>
                                                    </div>
                                                </div>
                                        @endforeach
                                                                                    </div>

                                        <div class="modal-footer  justify-content-center ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" id="saveExamSubject">Save</a>
                                        </div>

                                    </div>
                                </form>



                        </div>
                      <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->

                    </div>

                {{-- <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}




        </div>

</div>

@endsection

@section('scripts')
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script>

      $(document).ready(function() {

    //    document.getElementById('month-value').textContent = document.getElementById('time').getAttribute('data-value');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // $("#SubjectMarkSave").on('click',function(){
        //     document.getElementById("subjectMarksForm").submit();

        // })

        $('#studentsTable').dataTable(

        );

        $('.custom-file-input').change(function() {
              var filename = $(this).val().split('\\').pop();
              $(this).next('.custom-file-label').html(filename);
          });

        $(document).on('change', 'input[type="file"]', function(e) {
            var file = e.target.files[0];
            // var file = $(this).closest('tr').find
            var studentId = $(this).closest('tr').find('[name^="student_id"]').val();
            var user_grade_class_id = $(this).closest('tr').find('[name^="user_grade_class_id"]').val();

            // Prepare form data
            var formData = new FormData();
            formData.append('file', file);
            formData.append('student_id', studentId);
            formData.append('user_grade_class_id', user_grade_class_id);

            $.ajax({
                url: '{{route('exam-marks.store')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    toastr.options.timeOut = 5000;
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    toastr.options.timeOut = 5000;
                    toastr.success('Error file uploading!');
                    {{Session::forget('message')}}
                    console.error('Error uploading file:', error);
                }
            });
        });


        $(document).on("click", "#cancelBtn", function() {

            $("#reasonInput").val("");
            $(this).closest('.d-flex').replaceWith(`
                <button type="button" class="btn btn-primary" id="reasonButton">
                    <i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason
                </button>
            `);

        });

        $("#date-exam").on('click',function(){
            // Get a reference to the input element
            var myDateInput = document.getElementById('time');

            // Focus on the input element to open the date picker
            myDateInput.focus();

        })

        $('#saveExamSubject').click(function (e) {
            // $("input[name=marks[]]").val();
            var isFormValid = true;

            $('#subjectMarksForm input[id="marks"]').each(function(){
                if ($.trim($(this).val()).length == 0){
                    $(this).addClass("error");
                    isFormValid = false;
                }
                else{
                    $(this).removeClass("error");
                    submitForm();

                }
            });
            if (!isFormValid) alert("Please fill in all the required fields (indicated by *)");

            return isFormValid;
        });
    });


        function submitForm()
        {
            $.ajax({
                type: 'POST',
                url: '{{ route('exam-marks.store') }}',
                data: $('#subjectMarksForm').serialize(),
                success: function (response) {
                    if(response == 'success'){
                        // window.location.href = '{{ route('exam-marks.subject') }}';
                        $('#subjectmark').removeAttr('hidden');
                        $("#subjectMarksForm").modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    console.log(response);

                    let gradeSelectBoxError = response.errors.grade_id ? response.errors.grade_id[0] : '';

                    if (gradeSelectBoxError) {
                        $('#gradeSelectBoxError').html(gradeSelectBoxError);
                        $('#gradeSelect').addClass('is-invalid');
                    } else {
                        $('#gradeSelectBoxError').html('');
                        $('#gradeSelect').removeClass('is-invalid');
                    }

                    $('.curriculum-name-error').text('');
                    $('.teacher-id-error').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            var errorMessage = value[0];

                            var [fieldName, index] = key.split('.');

                            var $row = $('[name="' + fieldName + '[]"]').eq(index).closest('.row');

                            if (fieldName === 'curriculum_name') {
                                $row.find('.curriculum-name-error').text('Subject name is required');
                                $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                            } else if (fieldName === 'teacher_id') {
                                $row.find('.teacher-id-error').text('Teacher field is required');
                                $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                            }
                        });
                    }
                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
    }



    function addExamMarks(id)
    {
        var ids = [40,55,90,75];

        if($("#mark_check_"+id).prop('checked',true))
        {

            $("#badge_"+id).css('background-color', 'green');
            $("#marks").val($("#mark_check_"+id).val());
            var selectedValue = $('input[name=marks]:checked').length;
            array = filterValueFromArray($("#mark_check_"+id).val(), ids);


            for(var i = 1; i < $('input:radio').length; i++) {

                if(i == id)
                {
                    return false;
                }
                $("#badge_" + i).css('background-color', '#007bff');
            }


        }else if($("#mark_check_"+id).prop('checked',false)){
        {
            $("#badge_"+id).css('background-color', '#007bff');
        }

     }


    }



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

        var ids = [40,55,90,75];

        for(var i = 0; i < ids.length; i++) {
            $("#badge_" + ids[i]).css('background-color', '#007bff');
        }

    }

    function filterValueFromArray(value, arr) {
        return $.grep(arr, function(elem, index) {
        return elem !== value;
        });
    }

</script>
@endsection
