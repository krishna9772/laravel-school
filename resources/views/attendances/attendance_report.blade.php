@extends('layouts.app')

@section('styles')
<style>


  </style>
@endsection

@section('content')

<div class="mx-5 py-5  custom-container" id="">

    <form id="filterMonthsForm">
        <input type="hidden" name="grade_select" id="grade_select" value="{{$gradeSelectedId}}">
        <input type="hidden" name="class_select" id="class_select" value="{{$classSelectedId}}">


         <div class="d-flex justify-content-between mb-4" id="titleInfo">
             <h3>{{$gradeName}} / {{$className}} - Attendance Report </h3>

             <div>
                <select id="filter" name="filter" class="form-control">
                    {{-- <option value="all">All</option> --}}
                    <option value="monthly">Monthly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>

         </div>

         <div id="monthlyAttendance">
            {{-- twelve months label section --}}
            <div id="twelve-months-section" class="my-3">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="1" autocomplete="off"> <span class="badge badge-primary">January</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="2" autocomplete="off"> <span class="badge badge-primary">February</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="3" autocomplete="off"> <span class="badge badge-primary">March</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="4" autocomplete="off" @if($thisMonth == '4') checked @endif> <span class="badge @if($thisMonth == '4') badge-success @else badge-primary @endif">April</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="5" autocomplete="off"> <span class="badge @if($thisMonth == '5') badge-success @else badge-primary @endif"">May</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="6" autocomplete="off"> <span class="badge badge-primary">June</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="7" autocomplete="off"> <span class="badge badge-primary">July</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="8" autocomplete="off"> <span class="badge badge-primary">August</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="9" autocomplete="off"> <span class="badge badge-primary">September</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="10" autocomplete="off"> <span class="badge badge-primary">October</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="11" autocomplete="off"> <span class="badge badge-primary">November</span>
                    </label>
                    <label class="btn btn-white mr-1 p-0">
                        <input type="radio" name="month" value="12" autocomplete="off"> <span class="badge badge-primary">December</span>
                    </label>
                </div>
             </div>

                <div class="">
                    <table id="studentsTable" class="w-100 my-3 table table-striped" >
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Student ID</th>
                                <th class="text-center">Student Name</th>
                                <th class="text-center">Father Name</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1 @endphp
                            @foreach ($students as $student)
                                <div class="userList">
                                <tr>
                                    <td class="col-1">{{ $count++ }}</td>
                                    <td class="text-center">{{$student->user_id}}</td>
                                    <td class="text-center">{{ $student->user_name }}</td>
                                    <td class="text-center">{{$student->father_name}}</td>
                                    <td class="text-center">

                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active bg-success" role="progressbar"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$student->percentage}}%; ">
                                            {{$student->percentage}}%
                                            </div>
                                          </div>

                                        {{-- <div class="progress">
                                            <div class="progress-bar progress-bar-success active border " role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$student->percentage}}%">
                                                {{$student->percentage}}%
                                            </div>
                                        </div> --}}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="view-details-link" data-user-id="{{ $student->user_id }}" data-percentage="{{ $student->percentage }}"> View Details</a>
                                    </td>
                                </tr>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
         </div>



        <div id="dailyAttendance" style="display: none">
             {{-- daily attendance section --}}
             <div id="date-input-section" style=" width: 20%;" class="my-3">
                <input type="date" name="" id="" value="{{ $todayDate->format('Y-m-d') }}" class="form-control">
             </div>


            <div style="">
                <table id="studentsDailyTable" class="w-100 my-3 table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Student ID</th>
                            <th class="text-center">Student Name</th>
                            <th class="text-center">Father Name</th>
                            <th class="text-center">Status</th>
                            {{-- <th class="text-center">Details</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1 @endphp
                        @foreach ($students as $student)
                            <div class="userList">
                            <tr>
                                <td class="col-1">{{ $count++ }}</td>
                                <td class="text-center">{{$student->user_id}}</td>
                                <td class="text-center">{{ $student->user_name }}</td>
                                <td class="text-center">{{$student->father_name}}</td>
                                <td class="text-center">

                                    @php
                                        $status = $student->userGradeClasses[0]->attendances[0]->status;
                                        $badgeClass = '';

                                        switch ($status) {
                                            case 'present':
                                                $badgeClass = 'badge-success';
                                                break;
                                            case 'absent':
                                                $badgeClass = 'badge-warning';
                                                break;
                                            case 'leave':
                                                $badgeClass = 'badge-danger';
                                                break;
                                            default:
                                                $badgeClass = 'badge-primary';
                                                break;
                                        }
                                    @endphp

                                    <span class="badge {{$badgeClass}}">

                                        {{$student->userGradeClasses[0]->attendances[0]->status}}</td>
                                    </span>


                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </form>
</div>

@endsection

@section('scripts')
<script>

      $(document).ready(function() {

        $('#studentsTable').dataTable(
            // 'bInfo': false;
            // "dom": 'rtip'
        );

        $('#studentsDailyTable').dataTable();


        $('#filter').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption === 'monthly') {
                $('#monthlyAttendance').show();
                $('#dailyAttendance').hide();
            } else if (selectedOption === 'daily') {
                $('#monthlyAttendance').hide();
                $('#dailyAttendance').show();
            }
        });


        $('.btn-group-toggle label').click(function() {
            $('.btn-group-toggle label span').removeClass('badge-success');
            $('.btn-group-toggle label span').addClass('badge-primary');


            $(this).find('span').addClass('badge-success');


            var month = $(this).find('input').val();

            $grade_select = $('#grade_select').val();
            $class_select = $('#class_select').val();

            // $('#filterMonthsForm').submit(function(e){
                // e.preventDefault();
                $.ajax({
                    type: 'GET',
                    data: {
                        'grade_select' : $grade_select,
                        'class_select' : $class_select
                    },
                    url: '{{route('attendances.view-report.per.month',['month' => ':month']) }}'.replace(':month', month),
                    success: function(response){
                        console.log(response);

                        var dataTable = $('#studentsTable').DataTable();
                        dataTable.rows().remove().draw();

                        for (var i = 0; i < response.length; i++) {
                            var student = response[i];
                            var rowData = [
                                '<div class="w-100 text-center">' + i + 1 + '</div>' ,
                                '<div class="w-100 text-center">' + student.user_id + '</div>' ,
                                '<div class="w-100 text-center">' + student.user_name + '</div>' ,
                                '<div class="w-100 text-center">' + (student.father_name ? student.father_name : '') + '</div>' ,
                                '<div class="progress w-100 text-center"><div class="progress-bar progress-bar-striped active bg-success" role="progressbar" aria-valuenow="' + student.percentage + '" aria-valuemin="0" aria-valuemax="100" style="width:' + student.percentage + '%">' + student.percentage + '%</div></div>',
                                '<div class="w-100 text-center"><a href="#" class="view-details-link" data-user-id="{{ $student->user_id }}" data-percentage="{{ $student->percentage }}">View Details</a></div>'
                            ];

                            dataTable.row.add(rowData).draw();
                        }

                    },

                })
            // });



        });

        $('#studentsTable').on('click', '.view-details-link', function(event) {
            event.preventDefault();

            var userId = $(this).data('user-id');
            var month = $('input[name="month"]:checked').val();
            var percentage = $(this).data('percentage');

            console.log('percentage is ' + percentage);


            // console.log('month is ' + month);

            $.ajax({
                type: 'GET',
                url: '{{ route('attendances.details') }}',
                data: {
                    'user_id': userId,
                    'month': month,
                    'percentage' : percentage,
                },
                success: function(response) {

                    var attendanceStatus = response.attendanceStatus;
                    var monthName = response.monthName;
                    var studentName = response.studentName;
                    var dayOfWeek = response.dayOfWeek;
                    var percentage = response.percentage;
                    console.log('day of week is:',dayOfWeek);

                    $('.custom-container').addClass('w-50 mx-auto');
                    $('#titleInfo').removeClass('d-flex');
                    $('#titleInfo').addClass('text-center');
                    $('#titleInfo').html(
                    `<h3>${studentName}'s ${monthName} Attendance</h3>
                    <h3>${percentage}%</h3>
                    `);

                    $('#twelve-months-section').hide();

                    console.log("Student Name:" , studentName);
                    console.log("Attendance status:", attendanceStatus);
                    console.log("Month name:", monthName);


                    var dataTable = $('#studentsTable').DataTable();

                    dataTable.clear().destroy();

                    var newTableHtml = `<thead><tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Day</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                      </tr></thead><tbody>`;


                    var count = Object.keys(attendanceStatus).length;
                    // console.log('count is ' + count);
                    var counter = 1;

                    for (var date in attendanceStatus) {
                        if (attendanceStatus.hasOwnProperty(date)) {
                            console.log('date is ' + date);

                            var status = attendanceStatus[date];
                            var day = dayOfWeek[date];

                            var badgeClass;
                            if (status == 'present') {
                                badgeClass = 'badge-success';
                            } else if (status == 'absent') {
                                badgeClass = 'badge-warning';
                            } else if (status == 'leave') {
                                badgeClass = 'badge-danger';
                            } else {
                                badgeClass = 'badge-secondary';
                            }

                            // console.log('day of week is ' + day);
                            newTableHtml += `<tr>
                                                <td class="text-center">  ${counter}  </td>
                                                <td class="text-center">  ${day}  </td>
                                                <td class="text-center">  ${date}  </td>
                                                <td class="text-center"> <span class="badge ${badgeClass}"> ${status} </span> </td>
                                            </tr>`;

                        }
                        counter++;
                    }



                    newTableHtml += '</tbody>';
                    $('#studentsTable').html(newTableHtml);


                    $('#studentsTable').DataTable();
                    $('#studentsTable').removeClass('w-100');


                },
                error: function(xhr, status, error) {

                    console.error(xhr.responseText);
                }
            });
        });


        $('#date-input-section input[type="date"]').on('change', function() {
            var selectedDate = $(this).val();

            $grade_select = $('#grade_select').val();
            $class_select = $('#class_select').val();


            $.ajax({
                type: 'GET',
                url: '{{ route('attendances.get-by-date') }}',
                data: {
                    'grade_select' : $grade_select,
                    'class_select' :  $class_select,
                    'selected_date': selectedDate
                },
                success: function(response) {

                    console.log(response);


                      var dataTable = $('#studentsDailyTable').DataTable();

                      dataTable.clear().destroy();

                    var newTableHtml = `<thead><tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Student Id</th>
                                        <th class="text-center">Student Name </th>
                                        <th class="text-center">Father Name</th>
                                        <th class="text-center">Status</th>
                                    </tr></thead><tbody>`;


                      var counter = 1;
                      for (var i = 0; i < response.length; i++) {
                        var student = response[i];
                        if (student.user_grade_classes && student.user_grade_classes.length > 0 && student.user_grade_classes[0].attendances && student.user_grade_classes[0].attendances.length > 0) {
                            status = student.user_grade_classes[0].attendances[0].status;
                        }else{
                            status = 'No Status Assigned';
                        }

                        var statusClass = '';
                        switch (status) {
                          case 'present':
                            statusClass = 'badge-success';
                            break;
                          case 'absent':
                            statusClass = 'badge-warning';
                            break;
                          case 'leave':
                            statusClass = 'badge-danger';
                            break;
                          default:
                            statusClass = 'badge-primary';
                            break;
                        }


                        newTableHtml += `<tr>
                                                <td class="text-center">  ${counter}  </td>
                                                <td class="text-center">  ${student.user_id}  </td>
                                                <td class="text-center">  ${student.user_name}  </td>
                                                <td class="text-center">  ${student.father_name ?? '' }  </td>

                                                <td class="text-center"> <span class="badge ${statusClass}"> ${status} </span> </td>
                                            </tr>`;

                                            counter++;
                    }



                    newTableHtml += '</tbody>';
                    $('#studentsDailyTable').html(newTableHtml);

                    $('#studentsDailyTable').DataTable();


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


      });

</script>
@endsection
