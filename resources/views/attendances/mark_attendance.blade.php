@extends('layouts.app')

@section('styles')
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
  </style>
@endsection

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

         <div class="d-flex justify-content-between mb-4">
             <h3>{{$gradeName}} / {{$className}} - Mark Attendance</h3>

             <input type="date" class=" form-control" style="width: 12%" id="dateInput" value="{{$todayDate}}">

         </div>


         <div class="">

            <form  id="markAttendanceForm">
                @csrf
                <table id="studentsTable" class="w-100 my-3 table table-striped" >
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Student ID</th>
                            <th class="text-center">Student Name</th>
                            <th class="text-center">Father Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1 @endphp
                        @foreach ($students as $student)
                            <?php
                                // dd('status is ' . $student->userGradeClasses[0]->attendances[0]->status);
                            ?>
                            <div class="userList">
                            <tr>
                                <td class="text-center col-1">{{ $count++ }}</td>
                                <td class="text-center">{{$student->user_id}}</td>
                                <td class="text-center">{{ $student->user_name }}</td>
                                <td class="text-center">{{$student->father_name}}</td>
                                <td class="text-center">
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
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" id="reasonButton"><i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason </button>
                                    {{-- <input type="text" name="reason[]" class="form-control" id=""> --}}
                                </td>
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
<script>

      $(document).ready(function() {




        $('#studentsTable').dataTable(

        );

        $(document).on("click", "#reasonButton", function() {

            var buttonContainer = $(this).parent();


            $(this).hide();


            var reasonInput = $(`<div class="d-flex">
                <input type="text" id="reasonInput" class="form-control mr-2" placeholder="Enter Reason">
                <button type="button" id="saveButton" class="btn btn-success mr-1">Save</button>
                <button type="button" class="btn btn-sm btn-danger" id="cancelBtn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>`);


            buttonContainer.append(reasonInput);


            reasonInput.show('slow');
        });


        $('.btn-group-toggle label').click(function() {

            $(this).closest('td').find('div label').removeClass('btn-danger btn-success btn-warning');


          $(this).parent().find('.btn').removeClass('badge-success badge-danger badge-warning border-1');
          $(this).addClass(function() {
            return $(this).find('input').val() === 'present' ? 'badge-success' :
                   $(this).find('input').val() === 'absent' ? 'badge-warning' : 'badge-danger';
          });

          var studentId = $(this).closest('tr').find('[name^="student_id"]').val();
            var status = $(this).find('input').val();
            var user_grade_class_id = $(this).closest('tr').find('[name^="user_grade_class_id"]').val();

            saveStatus(studentId, status, user_grade_class_id);

        });

        $(document).on("click", "#cancelBtn", function() {

            $("#reasonInput").val("");
            $(this).closest('.d-flex').replaceWith(`
                <button type="button" class="btn btn-primary" id="reasonButton">
                    <i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason
                </button>
            `);

        });

        $(document).on("click", "#saveButton", function() {

            // console.log();

            var reason = $("#reasonInput").val();
            console.log('Reason is ' + reason);
            var studentId = $(this).closest('tr').find('[name^="student_id"]').val();
            var status = $(this).closest('tr').find('[name^="status"]').val();
            var user_grade_class_id = $(this).closest('tr').find('[name^="user_grade_class_id"]').val();

            saveReason(studentId, user_grade_class_id, reason);
        });

        function saveStatus(studentId, status, user_grade_class_id) {

            var selectedDate = $('#dateInput').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('attendances.store') }}",
                method: "POST",
                data: {
                    student_id: studentId,
                    status: status,
                    selectedDate : selectedDate,
                    user_grade_class_id : user_grade_class_id
                },
                success: function(response) {
                   console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                }
            });
        }

        function saveReason(studentId, user_grade_class_id, reason) {

            var selectedDate = $('#dateInput').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('attendances.store') }}",
                method: "POST",
                data: {
                    student_id: studentId,
                    selectedDate : selectedDate,
                    user_grade_class_id : user_grade_class_id,
                    reason : reason
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {

                }
            });
            }

    });

</script>
@endsection
