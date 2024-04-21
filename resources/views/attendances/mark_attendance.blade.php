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

      input[type="radio"] {
        display: none;
    }
  </style>
@endsection

@section('content')

<div class="mx-5 py-5">

        <input type="hidden" name="grade_select" id="gradeIdInputBox" value="{{$gradeId}}">
        <input type="hidden" name="class_select" id="classIdInputBox" value="{{$classId}}">

        <input type="hidden" id="startDate" value="{{$startDate}}">
        <input type="hidden" id="endDate" value="{{$endDate}}">

         <div class="d-flex justify-content-between mb-4">
             <h3 class="text-capitalize">{{$gradeName}} / {{$className}} / Mark Attendance</h3>

             {{-- <input type="date" class=" form-control" style="width: 12%" id="dateInput" value="{{$dateToShow}}"> --}}

             <div class="form-group">
                {{-- <label for="datepicker" class="required">Start Date:</label> --}}
                <div class="input-group">
                  <input type="text" class="form-control custom-placeholder changeInputStyle admissionDateClass" name="date" style="width: 12%" id="dateInput" value="{{$dateToShow}}">
                  <div class="input-group-append">
                    <span class="input-group-text" id="datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                  </div>
                </div>
            </div>
             {{-- <input type="date" class=" form-control" style="width: 12%" id="dateInput" value="{{$dateToShow}}"> --}}

         </div>


         <div class="">


                @csrf
                <table id="studentsTable" class="w-100 my-3 table table-striped" >
                    <thead>
                        <tr>
                            <th class="text-center col-1">No</th>
                            <th class="text-center">Student ID</th>
                            <th class="text-center">Student Name</th>
                            <th class="text-center">Father Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Reason</th>
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
                                <td class="text-center">{{$student->father_name ?? '-'}}</td>
                                <td class="text-center">
                                    <input type="hidden" name="student_id" value="{{$student->user_id}}">
                                    <input type="hidden" name="user_grade_class_id" value="{{$student->userGradeClasses[0]->id}}">

                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn

                                        @if (isset($student->userGradeClasses[0]) && isset($student->userGradeClasses[0]->attendances[0]))
                                        @if($student->userGradeClasses[0]->attendances[0]->status == 'present')
                                            btn-success
                                        @else
                                            btn-white
                                        @endif
                                    @endif
                                            mr-1 border border-secondary active ">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="present" autocomplete="off" checked> P
                                        </label>

                                        <label class="btn
                                            @if (isset($student->userGradeClasses[0]) && isset($student->userGradeClasses[0]->attendances[0]))
                                                @if ($student->userGradeClasses[0]->attendances[0]->status == 'absent' )
                                                    btn-warning
                                                @else ($student->userGradeClasses[0]->attendances[0]->status == 'leave')
                                                    btn-white
                                                @endif
                                            @endif
                                            mr-1 border border-secondary">
                                            <input type="radio" name="status[{{ $student->user_id }}]" value="absent" autocomplete="off"> A
                                        </label>

                                        <label class="btn

                                        @if (isset($student->userGradeClasses[0]) && isset($student->userGradeClasses[0]->attendances[0]))
                                            @if ($student->userGradeClasses[0]->attendances[0]->status == 'leave')
                                                btn-danger
                                            @else ($student->userGradeClasses[0]->attendances[0]->status == 'leave')
                                                btn-white
                                            @endif
                                        @endif

                                        border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="leave" autocomplete="off"> L
                                        </label>
                                      </div>

                                </td>
                                <td class="text-center col-3">

                                    @if (isset($student->userGradeClasses[0]) && isset($student->userGradeClasses[0]->attendances[0]))
                                        @if ($student->userGradeClasses[0]->attendances[0]->reason == null || $student->userGradeClasses[0]->attendances[0]->reason == '' )
                                            <button type="button" class="btn btn-primary" id="reasonButton"><i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason </button>
                                        @else
                                        <div class="d-flex">
                                            <input type="text" class="reasonInput form-control mr-2" placeholder="Enter Reason" value="{{$student->userGradeClasses[0]->attendances[0]->reason}}">
                                            <button type="button" id="" class="saveButton btn btn-success mr-1">Save</button>
                                            <button type="button" class="btn btn-sm btn-danger" id="cancelBtn">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-primary" id="reasonButton"><i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason </button>
                                    @endif
                                </td>
                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>
        </div>

</div>

@endsection

@section('scripts')
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>

      $(document).ready(function() {

        $('#studentsTable').dataTable();

        $(document).on("click", "#reasonButton", function() {

            var buttonContainer = $(this).parent();

            $(this).hide();

            var reasonInput = $(`<div class="d-flex">
                <input type="text" id="" class="reasonInput form-control mr-2" placeholder="Enter Reason">
                <button type="button" id="" class="saveButton btn btn-success mr-1">Save</button>
                <button type="button" class="btn btn-sm btn-danger" id="cancelBtn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>`);

            buttonContainer.append(reasonInput);


            reasonInput.show('slow');
        });

        // $(document).off("click", ".btn-/group-toggle label");
        $(document).on("click", ".btn-group-toggle label", function(event) {

            event.preventDefault();

            console.log('hello world testing');

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

            var reason = '';

            var studentId = $(this).closest('tr').find('[name^="student_id"]').val();
            // var status = $(this).closest('tr').find('[name^="status"]').val();
            var user_grade_class_id = $(this).closest('tr').find('[name^="user_grade_class_id"]').val();

            console.log('student id is ' + studentId);
            console.log('reason is ' + reason);
            console.log('user grade class id is ' + user_grade_class_id);

            var selectedDate = $('#dateInput').val();

            // saveReason(studentId, user_grade_class_id, reason);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: '{{route('attendances.update.reason.on.cancel.btn')}}',
                data : {
                    student_id : studentId,
                    reason : reason,
                    user_grade_class_id : user_grade_class_id,
                    selectedDate: selectedDate,
                },
                success: function(response){
                    if(response == 'success'){
                        console.log(response);
                    }
                }
            });


            // $(".reasonInput").val("");
            $(this).closest('tr').find('[class^="resonInput"]').val('');
            $(this).closest('.d-flex').replaceWith(`
                <button type="button" class="btn btn-primary" id="reasonButton">
                    <i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason
                </button>
            `);

        });

        $(document).on("click", ".saveButton", function() {

            // console.log();

            // var reason = $(".reasonInput").val();

            var reason = $(this).closest('tr').find('.reasonInput').val();

            if(reason == ''){
                $(this).closest('tr').find('.reasonInput').addClass('is-invalid');
                return;
            }

            console.log('reason is ' + reason);
            console.log('Reason is ' + reason);
            var studentId = $(this).closest('tr').find('[name^="student_id"]').val();
            var status = $(this).closest('tr').find('[name^="status"]').val();
            var user_grade_class_id = $(this).closest('tr').find('[name^="user_grade_class_id"]').val();

            saveReason(studentId, user_grade_class_id, reason);

            $(this).closest('tr').find('.reasonInput').blur();
        });

        function saveStatus(studentId, status, user_grade_class_id) {

            console.log('hello world lab');

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
                   if(response == 'success'){
                        toastr.options.timeOut = 5000;
                        toastr.success('Successfully added!');
                   }
                },
                error: function(xhr, status, error) {
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
                    // console.log(response);
                    if(response == 'success'){
                        // window.location.reload();
                        toastr.options.timeOut = 5000;
                        toastr.success('Successfully added!');
                    }

                },
                error: function(xhr, status, error) {

                }
            });
        }

        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        var holidays = {!! $holidays->pluck('date') !!};

        console.log(holidays);

        var disabledDates = holidays.map(function(date) {
            return new Date(date);
        });

        console.log('disabled  dates are ' + disabledDates);

        $('#dateInput').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: startDate,
            endDate: endDate,
            beforeShowDay: function(date) {

                var dateString = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                var isHoliday = disabledDates.find(function(holidayDate) {
                    return holidayDate.toISOString().split('T')[0] === dateString;
                });

                var isWeekend = date.getDay() === 0 || date.getDay() === 6;

                return {
                    enabled: !isHoliday && !isWeekend
                };
            }
        });

        $('#datepicker-icon').click(function() {
          $('#dateInput').datepicker('show');
        });

        $('#dateInput').change(function() {

            var selectedDate = $(this).val();

            var grade_select = $('#gradeIdInputBox').val();
            var class_select = $('#classIdInputBox').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('attendances.getByDate.in.mark.attendance') }}',
                method: "GET",
                data: {
                    'grade_select' : grade_select,
                    'class_select' :  class_select,
                    'selected_date': selectedDate
                },
                success: function(response) {

                    console.log(response);

                    var dataTable =$('#studentsTable').DataTable()

                    dataTable.clear().destroy();

                    var newTableHtml = `<thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Student Id</th>
                                                <th class="text-center">Student Name </th>
                                                <th class="text-center">Father Name</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                    var counter = 1;
                    for (var i = 0; i < response.length; i++) {
                        var student = response[i];
                        var status = student.user_grade_classes && student.user_grade_classes.length > 0 && student.user_grade_classes[0].attendances && student.user_grade_classes[0].attendances.length > 0 ? student.user_grade_classes[0].attendances[0].status : 'No Status Assigned';

                        var presentClass = status === 'present' ? 'btn-success active' : 'btn-white';
                        var absentClass = status === 'absent' ? 'btn-warning active' : 'btn-white';
                        var leaveClass = status === 'leave' ? 'btn-danger active' : 'btn-white';

                        var badgeHtml = `
                            <input type="hidden" name="student_id" value="${student.user_id}">
                            <input type="hidden" name="user_grade_class_id" value="${student.user_grade_classes[0].id}">

                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn ${presentClass} mr-1 border border-secondary">
                                    <input type="radio" name="status[${student.user_id}]" value="present" autocomplete="off" ${status === 'present' ? 'checked' : ''}>
                                    P
                                </label>

                                <label class="btn ${absentClass} mr-1 border border-secondary">
                                    <input type="radio" name="status[${student.user_id}]" value="absent" autocomplete="off" ${status === 'absent' ? 'checked' : ''}>
                                    A
                                </label>

                                <label class="btn ${leaveClass} border border-secondary">
                                    <input type="radio" name="status[${student.user_id}]" value="leave" autocomplete="off" ${status === 'leave' ? 'checked' : ''}>
                                    L
                                </label>
                            </div>
                        `;

                        newTableHtml += `<tr>
                            <td class="text-center">${counter}</td>
                            <td class="text-center">${student.user_id}</td>
                            <td class="text-center">${student.user_name}</td>
                            <td class="text-center">${student.father_name ?? '-'}</td>
                            <td class="text-center">${badgeHtml}</td>
                            <td class="text-center col-3">`;

                        var reason = student.user_grade_classes && student.user_grade_classes.length > 0 && student.user_grade_classes[0].attendances && student.user_grade_classes[0].attendances.length > 0 ? student.user_grade_classes[0].attendances[0].reason : '';

                        if(reason == null || reason == ''){
                            newTableHtml += `<button type="button" class="btn btn-primary" id="reasonButton"><i class="fa fa-edit mr-2" aria-hidden="true"></i>Reason </button>`;
                        }else{
                            newTableHtml += `<div class="d-flex">
                                <input type="text" class="form-control mr-2" placeholder="Enter Reason" value="${reason}">
                                <button type="button" class="btn btn-success mr-1">Save</button>
                                <button type="button" class="btn btn-sm btn-danger" id="cancelBtn">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            `;
                        }

                        newTableHtml += `</td></tr>`;

                        counter++;
                    }

                    newTableHtml += '</tbody>';
                    $('#studentsTable').html(newTableHtml);

                    $('#studentsTable').DataTable();
                },
                error: function(xhr, status, error) {

                }
            });
        });

    });

</script>
@endsection
