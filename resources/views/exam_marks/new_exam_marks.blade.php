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

            <form id="markAttendanceForm" method="POST">
                @csrf
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
                                <td class="col-3">

                                    <?php
                                        // dd($student->userGradeClasses[0]->examMarks[0]->file);
                                    ?>

                                    <div class="form-group d-flex">
                                        
                                        {{-- <div class="input-group ml-3"> --}}
                                            {{-- <div class="custom-file"> --}}
                                            {{-- <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">
                                                {{ $student->userGradeClasses[0]->examMarks[0]->file ?? 'Choose File' }}
                                            </label> --}}
                                          
                                            {{-- </div> --}}
                                        {{-- </div> --}}
                                      
                                       
                                          
                                    </div>
                                    <a type="button" class="nav-link border-0 bg-white" data-toggle="modal" data-target="#subject_marks">
                                        {{-- <i class="nav-icon fas fa-sign-out-alt "></i> Logout --}}
                                        {{-- <label for="examMarks">Exam Marks</label> --}}
                                        {{-- <input type="number" id="examMarks" name="examMarks" placeholder=""> --}}

                                        <label class="badge badge-success text-white"><i class="fas fa-plus"></i> Add</label>
                                    </a>               

                                    <div class="modal fade" id="subject_marks">
                                        <form action="{{route('logout')}}" method="post" id="form_logout">
                                          @csrf
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
                                              <div class="modal-body py-4">
                        
                                                  {{-- <input type="text" class="form-control" value="{{ $user->user_name }}" disabled> --}}
                                                  {{-- <p class="text-center" style="font-size: 19px; font-weight:bold">
                                                      <small>Are you sure that you want to <span class="text-bold">log out ?<span></small>
                                                  </p> --}}
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="eg: English">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                                                <label class="btn btn-white mr-1 p-0">
                                                                    <input type="radio" name="marks" value="40" autocomplete="off" onclick="addExamMarks(40)" id="mark_check_40"> <span class="badge badge-primary" id="badge_40">40</span>
                                                                </label>
                                                                <label class="btn btn-white mr-1 p-0">
                                                                    <input type="radio" name="marks" value="55" autocomplete="off" onclick="addExamMarks(55)" id="mark_check_55"> <span class="badge badge-primary" id="badge_55">55</span>
                                                                </label>
                                                                <label class="btn btn-white mr-1 p-0">
                                                                    <input type="radio" name="marks" value="75" autocomplete="off" onclick="addExamMarks(75)" id="mark_check_75"> <span class="badge badge-primary" id="badge_75">75</span>
                                                                </label> 
                                                                <label class="btn btn-white mr-1 p-0">
                                                                    <input type="radio" name="marks" value="90" autocomplete="off" onclick="addExamMarks(90)" id="mark_check_90"> <span class="badge badge-primary" id="badge_90">90</span>
                                                                </label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="subject" id="marks" placeholder="eg: 80" onkeypress='validate(event)'>
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="modal-footer  justify-content-center ">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                              <button type="button" class="btn btn-danger" onclick="logout()">Save</a>
                                              </div>
                                          </div>
                                          <!-- /.modal-content -->
                                          </div>
                                          <!-- /.modal-dialog -->
                                        </form>
                        
                                      </div>
                                    

                                    {{-- <input type="file" name="" id="" class="form-control" style="width: 60%"> --}}
                                </td>
                                {{-- <td class="text-center">
                                    <input type="hidden" name="student_id" value="{{$student->user_id}}">
                                    <input type="hidden" name="user_grade_class_id" value="{{$student->userGradeClasses[0]->id}}">



                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-white mr-1 border border-secondary active ">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="present" autocomplete="off" checked> P
                                        </label>


                                        <label class="btn btn-white mr-1 border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="absent" autocomplete="off"> A
                                        </label>

                                        <label class="btn btn-white border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="leave" autocomplete="off"> L
                                        </label>
                                      </div>
                                </td> --}}

                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}


            </form>


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

                    console.log('File uploaded successfully');
                },
                error: function(xhr, status, error) {

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
    });

    function addExamMarks(id)
    {
        var ids = [40,55,90,75];

        if($("#mark_check_"+id).prop('checked',true))
        {

            $("#badge_"+id).css('background-color', 'green');
            $("#marks").val($("#mark_check_"+id).val());
            var selectedValue = $('input[name=marks]:checked').length;
            array = filterValueFromArray(id, ids);
  
            for(var i = 0; i < array.length; i++) {
                $("#badge_" + array[i]).css('background-color', '#007bff');
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

    }

    function filterValueFromArray(value, arr) {
        return $.grep(arr, function(elem, index) {
        return elem !== value;
        });
    }

</script>
@endsection
