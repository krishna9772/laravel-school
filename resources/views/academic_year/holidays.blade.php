@extends("layouts.app")

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card m-3 p-2">
            <div class="card-header">

                <div class="container-fluid">
                    <div class="mb-2">
                        <h3 class="m-0">Holidays</h3>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2">

                <div class="row">
                    <div class="col-md-8 p-2">

                        <table class="table table-striped text-nowrap" id="holidaysTable">
                            <thead>
                                <tr>
                                    <th style="width: 10px" class="text-center">No</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center" style="width: 40px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $key => $holiday)
                                <tr>
                                    <input type="hidden" id="academic_{{$holiday->id}}" value="{{$holiday->academic_id}}">
                                    <td class="text-center">{{$key += 1}}</td>
                                    <td class="text-center">
                                        @php
                                        foreach ($academicYears as $academicYear){
                                            if ($holiday->academic_id == $academicYear->id){
                                                echo $academicYear->academic_year;
                                            }
                                        }
                                        @endphp
                                    </td>
                                    <td class="text-center" id="name_{{$holiday->id}}">{{$holiday->name}}</td>
                                    <td class="text-center" id="date_{{$holiday->id}}">{{$holiday->date}}</td>
                                    {{-- <td>{{$holiday->date}}</td> --}}
                                    {{-- <td id="type_{{$level->id}}">{{$level->type}}</td>
                                    <td id="name_{{$level->id}}">{{$level->name}}</td>
                                    <td id="min_amount_{{$level->id}}">{{$level->min_amount}} </td>
                                    <td id="max_amount_{{$level->id}}">{{$level->max_amount}}</td>
                                    <td id="percentage_{{$level->id}}">{{$level->percentage}}</td>
                                    <input type="hidden" id="level-id" value="{{$level->id}}"> --}}
                                    <td class="text-center"><button class="btn btn-info btn-sm" onclick="editHoliday({{$holiday->id}})"> Edit </button>
                                        {{-- <button class="btn btn-danger btn-sm" id="holiday_delete_{{$holiday->id}}" attr-holiday-id="{{$holiday->id}}" onclick="deleteHoliday({{$holiday->id}})"> Delete </button> --}}

                                        <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteHolidayModal_{{$holiday->id}}">
                                            Delete
                                        </a>

                                        <div class="modal fade" id="deleteHolidayModal_{{$holiday->id}}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class='modal-header'>
                                                    <p class='col-12 modal-title text-center'>
                                                    <span class="ml-5" style="font-size: 17px">Are you sure to delete this holiday?</span>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                    </p>
                                                </div>
                                                <div class="modal-body py-4">

                                                    {{-- <input type="text" class="form-control" value="{{ $user->user_name }}" disabled> --}}
                                                    <p class="text-center" style="font-size: 19px; font-weight:bold">
                                                        {{ $holiday->name }}

                                                    </p>
                                                    <p class="text-center" style="font-size: 17px; font-weight:bold">
                                                        {{ $holiday->date }}

                                                    </p>
                                                </div>
                                                <div class="modal-footer  justify-content-center ">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="deleteHoliday({{$holiday->id}})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-4">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title" id="cardTitle">New Holiday</h3>
                                <div class="card-tools">

                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <form>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>


                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="type">Academic Year</label>

                                        <select name="academic_id"  id="academicId" class="form-control">
                                            <option value="">Select Academic Year</option>

                                            @foreach ($academicYears as $academicYear)
                                                <option value="{{$academicYear->id}}">{{$academicYear->academic_year}}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger" id="academicIdErrorMessage"></p>
                                    </div>
                                    <input type="hidden" id="holiday_id">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Holiday Name">
                                        <p class="text-danger" id="nameErrorMessage"></p>
                                    </div>

                                    {{-- <label for="name">Date</label>
                                    <input type="text" class="form-control" id="date"> --}}
                                    <div class="form-group" id="newCalendar">
                                        <label for="datepicker" class="required"> Date</label>
                                        <div class="input-group">
                                          <input type="text" id="newDate" class="newDateInput form-control custom-placeholder changeInputStyle admissionDateClass" placeholder="Enter Holiday Date">
                                          <div class="input-group-append">
                                            <span class="input-group-text newDatepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                          </div>
                                        </div>
                                        <p class="text-danger" id="dateErrorMessage"></p>
                                    </div>

                                    <div class="form-group" id="editCalendar" style="display: none;">
                                        <label for="datepicker" class="required"> Date</label>
                                        <div class="input-group">
                                          <input type="text" id="editDate" class="editDateInput form-control custom-placeholder changeInputStyle admissionDateClass" placeholder="Enter Holiday Date">
                                          <div class="input-group-append">
                                            <span class="input-group-text editDatepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                          </div>
                                        </div>
                                        <p class="text-danger" id="dateErrorMessage"></p>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn btn-primary" id="holiday-store">Save</button>
                                    <button class="btn btn-primary d-none" id="holiday-edit">Update</button>
                                    <button class="btn btn-danger d-none" id="holiday-cancel">Cancel</button>

                                </div>
                            </form>

                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('scripts')
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#newDate').focus(function(event){
        console.log('hello world ');
        if( $('#academicId').val() == ''){
            $('#dateErrorMessage').html('First, select academic year');
            $('#date').addClass('is-invalid');
        }
    });

    $('#newDate').blur(function(event){
        // console.log('hello world ');
        if( $('#academicId').val() != ''){
            $('#dateErrorMessage').html('');
            $('#date').removeClass('is-invalid');
        }
    });



    $('#academicId').change(function(event){
        event.preventDefault();

        if( $('#academicId').val() != ''){
            $('#dateErrorMessage').html('');
            $('#newDate').removeClass('is-invalid');
        }

        var academic_id = $(this).val();

        if(academic_id != ''){
            $.ajax({
                method: 'GET',
                url: '{{ route("academic-years.get.calendar.info", ["id" => ":id"]) }}'.replace(':id', academic_id),
                success: function(response){
                    console.log(response);
                    console.log('startDate is ' + response.start_date);

                    var startDate = response.start_date;
                    var endDate = response.end_date;


                    var holidays = {!! $holidays->pluck('date') !!};

                    console.log(holidays);

                    var disabledDates = holidays.map(function(date) {
                        return new Date(date);
                    });

                    $('.newDateInput').each(function() {
                        $(this).datepicker({
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
                    });

                    $('.newDatepicker-icon').click(function() {
                        $(this).closest('.form-group').find('.newDateInput').datepicker('show');
                    });
                }
            });
        }

    })

    $('#holidaysTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        // "columnDefs": [
        //     { "targets": "_all", "className": "text-center" }
        // ]
    });

    // $('.dateInput').each(function() {
    //     $(this).datepicker({
    //         format: 'yyyy-mm-dd',
    //         autoclose: true,
    //     });
    // });

    // $('.datepicker-icon').click(function() {
    //     $(this).closest('.form-group').find('.dateInput').datepicker('show');
    // });

    $("#holiday-store").click(function(e) {

        e.preventDefault();

        var name = $("#name").val();

        var date = $("#newDate").val();

        var academic_id = $('#academicId').val();
        console.log('academic year is' + academic_id);

        $.ajax({
            type: 'POST',
            url: "{{ route('holidays.store') }}",
            data: {
                name: name,
                date: date,
                academic_id: academic_id,
            },
            success: function(response) {
                if(response == 'success'){

                    window.location.reload();

                    // $('#holiday-store').closest('form').find("input[type=text],select").val("");

                    // $("#holidaysTable").load(window.location + " #holidaysTable");
                    // toastr.options.timeOut = 5000;
                    // toastr.success('Successfully added!');
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);

                let academicIdErrorMessage = response.errors.academic_id ? response.errors.academic_id[0] : '';
                let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                let dateErrorMessage = response.errors.date ? response.errors.date[0] : '';

                if (academicIdErrorMessage) {
                    $('#academicIdErrorMessage').html(academicIdErrorMessage);
                    $('#academicId').addClass('is-invalid');
                } else {
                    $('#academicIdErrorMessage').html('');
                    $('#academicId').removeClass('is-invalid');
                }

                if (nameErrorMessage) {
                    $('#nameErrorMessage').html(nameErrorMessage);
                    $('#name').addClass('is-invalid');
                } else {
                    $('#nameErrorMessage').html('');
                    $('#name').removeClass('is-invalid');
                }

                if (dateErrorMessage) {
                    $('#dateErrorMessage').html(dateErrorMessage);
                    $('#date').addClass('is-invalid');
                } else {
                    $('#dateErrorMessage').html('');
                    $('#date').removeClass('is-invalid');
                }

            },
        });

    });

    $("#holiday-edit").click(function(e) {

        e.preventDefault();

        // var startDate = response.start_date;
        // var endDate = response.end_date;

        var academic_id = $('#academicId').val();
        console.log('academic id is ' + academic_id);
        var name = $("#name").val();
        var id = $("#holiday_id").val();
        var date = $("#editDate").val();


        $.ajax({
            type: 'POST',
            url: '{{route('holidays.edit')}}',
            data: {
                id: id,
                academic_id: academic_id,
                name: name,
                date: date,
            },

            success: function(response) {

                    if(response == 'success'){

                        window.location.reload();

                        // $('#holiday-edit').closest('form').find("input[type=text],select").val("");

                        // $("#holiday-store").removeClass('d-none');
                        // $("#holiday-edit").addClass('d-none');
                        // $("#holiday-cancel").addClass('d-none');

                        // $('#cardTitle').text('New Holiday');

                        // $("#holidaysTable").load(window.location + " #holidaysTable");
                        // toastr.options.timeOut = 5000;
                        // toastr.success('Successfully updated!');



                    }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);

                let academicIdErrorMessage = response.errors.academic_id ? response.errors.academic_id[0] : '';
                let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                let dateErrorMessage = response.errors.date ? response.errors.date[0] : '';

                if (academicIdErrorMessage) {
                    $('#academicIdErrorMessage').html(academicIdErrorMessage);
                    $('#academicId').addClass('is-invalid');
                } else {
                    $('#academicIdErrorMessage').html('');
                    $('#academicId').removeClass('is-invalid');
                }

                if (nameErrorMessage) {
                    $('#nameErrorMessage').html(nameErrorMessage);
                    $('#name').addClass('is-invalid');
                } else {
                    $('#nameErrorMessage').html('');
                    $('#name').removeClass('is-invalid');
                }

                if (dateErrorMessage) {
                    $('#dateErrorMessage').html(dateErrorMessage);
                    $('#date').addClass('is-invalid');
                } else {
                    $('#dateErrorMessage').html('');
                    $('#date').removeClass('is-invalid');
                }

            },
        });
    });

    function deleteHoliday(id) {

        $.ajax({
            type: 'GET',
            url: '{{ route("holidays.destroy", ["id" => ":id"]) }}'.replace(':id', id),
            success: function(response) {
                if (response == 'success') {
                    $("#holidaysTable").load(window.location + " #holidaysTable");
                    toastr.options.timeOut = 5000;
                    toastr.success('Successfully deleted!');
                }

            }
        });

}


    $("#holiday-cancel").click(function(e) {

        e.preventDefault();

        // window.location.reload();

        $(this).closest('form').find("input[type=text],select, textarea").val("");

        $("#holiday-edit").addClass('d-none');
        $("#holiday-cancel").addClass('d-none');
        $("#holiday-store").removeClass('d-none');

        $('#cardTitle').text('New Holiday');
        $('#newCalendar').show();
        $('#editCalendar').hide();


    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    function editHoliday(id) {

        $('#newCalendar').hide();
        $('#editCalendar').show();

        var holidays = {!! $holidays->pluck('date') !!};

        console.log(holidays);

        var selectedDate = $('#date_' + id).text();
        var selectedDateObj = new Date(selectedDate);

        var disabledDates = holidays.map(function(date) {
            return new Date(date);
        });

        disabledDates = disabledDates.filter(function(date) {
            // Return true for dates that are not equal to the selected date
            return !isSameDate(date, selectedDateObj);
        });

        function isSameDate(date1, date2) {
            return date1.getFullYear() === date2.getFullYear() &&
                date1.getMonth() === date2.getMonth() &&
                date1.getDate() === date2.getDate();
        }

        $('.editDateInput').each(function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                // startDate: startDate,
                // endDate: endDate,
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
        });

        $('.editDatepicker-icon').click(function() {
            $(this).closest('.form-group').find('.editDateInput').datepicker('show');
        });


        // var type = $("#type_"+id).text();
        var name = $("#name_" + id).text();
        var date = $('#date_' + id).text();
        var academic_id = $('#academic_' + id).val();
        console.log('academic_id is dms,f ' + academic_id);

        $('#cardTitle').text('Edit Holiday');


        $("#name").val(name);
        $('#editDate').val(date);
        $('#academicId').val(academic_id);
        $("#holiday_id").val(id);

        $("#holiday-store").addClass('d-none');
        $("#holiday-edit").removeClass('d-none');
        $("#holiday-cancel").removeClass('d-none');
    }


</script>
@endsection
