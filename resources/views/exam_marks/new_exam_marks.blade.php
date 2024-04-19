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
                                        <div class="input-container ml-1">
                                            <input type="number" id="examMarks" name="examMarks" placeholder="">
                                            <label for="examMarks">Exam Marks</label>
                                          </div>
                                       
                                          
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

       document.getElementById('month-value').textContent = document.getElementById('time').getAttribute('data-value');


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
            // $('#time').datepicker({
            //     dateFormat: 'MM yy',
            //     changeMonth: true,
            //     changeYear: true,
            //     showButtonPanel: true,

            //     onClose: function(dateText, inst) {
            //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            //         $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
            //     }
            // });


        })
    });

</script>
@endsection
