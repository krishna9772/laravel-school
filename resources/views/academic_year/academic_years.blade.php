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
                        <h3 class="m-0">Academic Years</h3>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2">

                <div class="row">
                    <div class="col-md-8 p-2">

                        <table class="table table-striped text-nowrap" id="academicYearsTable">
                            <thead>
                                <tr>
                                    <th style="width: 10px" class="text-center">No</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center" style="width: 40px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($academicYears as $key => $academicYear)
                                <tr>
                                    <input type="hidden" id="academic_{{$academicYear->id}}" value="{{$academicYear->id}}">
                                    <td class="text-center">{{$key += 1}}</td>
                                    <td class="text-center" id="academicYear_{{$academicYear->id}}" >{{$academicYear->academic_year}}</td>
                                    <td class="text-center" id="startDate_{{$academicYear->id}}">{{$academicYear->start_date}}</td>
                                    <td class="text-center" id="endDate_{{$academicYear->id}}">{{$academicYear->end_date}}</td>
                                    {{-- <td>{{$academicYear->date}}</td> --}}
                                    {{-- <td id="type_{{$level->id}}">{{$level->type}}</td>
                                    <td id="name_{{$level->id}}">{{$level->name}}</td>
                                    <td id="min_amount_{{$level->id}}">{{$level->min_amount}} </td>
                                    <td id="max_amount_{{$level->id}}">{{$level->max_amount}}</td>
                                    <td id="percentage_{{$level->id}}">{{$level->percentage}}</td>
                                    <input type="hidden" id="level-id" value="{{$level->id}}"> --}}
                                    <td class="text-center"><button class="btn btn-info btn-sm" onclick="editAcademicYear({{$academicYear->id}})"> Edit </button>
                                        {{-- <button class="btn btn-danger btn-sm" id="academicYear_delete_{{$academicYear->id}}" attr-academicYear-id="{{$academicYear->id}}" onclick="deleteacademicYear({{$academicYear->id}})"> Delete </button> --}}

                                        <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAcademicYearModal_{{$academicYear->id}}">
                                            Delete
                                        </a>

                                        <div class="modal fade" id="deleteAcademicYearModal_{{$academicYear->id}}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class='modal-header'>
                                                    <p class='col-12 modal-title text-center'>
                                                    <span class="ml-5" style="font-size: 17px">Are you sure to delete this academic year?</span>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                    </p>
                                                </div>
                                                <div class="modal-body py-4">

                                                    {{-- <input type="text" class="form-control" value="{{ $user->user_name }}" disabled> --}}
                                                    <p class="text-center" style="font-size: 19px; font-weight:bold">
                                                        {{ $academicYear->academic_year }}

                                                    </p>
                                                    <p class="text-center" style="font-size: 17px; font-weight:bold">
                                                        {{ $academicYear->start_date }} to {{ $academicYear->end_date }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer  justify-content-center ">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="deleteAcademicYear({{$academicYear->id}})" class="btn btn-danger">Delete</button>
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
                                <h3 class="card-title" id="cardTitle">New Academic Year</h3>
                                <div class="card-tools">
                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                    <!-- Here is a label for example -->
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <form>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="" class="form-label required">Select Academic Year</label>
                                    <select name="academic_id" id="academicYearInputBox" class="form-control">
                                        <option value="">Select Academic Year</option>

                                        @foreach ($academicYears as $academicYear)
                                            <option value="{{$academicYear->id}}">{{$academicYear->academic_year}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger mt-1" id="academicYearError"></p>
                                </div> --}}

                                <div class="card-body">
                                    <div class="form-group">
                                        {{-- <label for="type">Academic Year</label> --}}

                                        <div class="form-group">
                                            <label for="" class="form-label required">Academic Year</label>
                                            <input type="text" name="academic_year" id="academicYear" class="form-control " placeholder="Enter Academic Year" autocomplete="false">
                                            <p class="text-danger" id="academicYearErrorMessage"></p>
                                        </div>

                                        {{-- <select name="academic_id"  id="academicId" class="form-control">
                                            <option value="">Select Academic Year</option>

                                            @foreach ($academicYears as $academicYear)
                                                <option value="{{$academicYear->id}}">{{$academicYear->academic_year}}</option>
                                            @endforeach
                                        </select> --}}
                                        {{-- <p class="text-danger" id="academicYearErrorMessage"></p> --}}
                                    </div>
                                    <input type="hidden" id="academicYear_id">

                                    <div class="form-group">
                                        <label for="datepicker" class="required">Start Date</label>
                                        <div class="input-group">
                                          <input type="text" id="startDate" class="dateInput form-control custom-placeholder changeInputStyle admissionDateClass" placeholder="Enter Start Date">
                                          <div class="input-group-append">
                                            <span class="input-group-text datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                          </div>
                                        </div>
                                        <p class="text-danger" id="startDateErrorMessage"></p>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter academicYear Name">
                                        <p class="text-danger" id="startDateErrorMessage"></p>
                                    </div> --}}

                                    {{-- <label for="name">Date</label>
                                    <input type="text" class="form-control" id="date"> --}}
                                    <div class="form-group">
                                        <label for="datepicker" class="required">End Date</label>
                                        <div class="input-group">
                                          <input type="text" id="endDate" class="dateInput form-control custom-placeholder changeInputStyle admissionDateClass" placeholder="Enter End Date">
                                          <div class="input-group-append">
                                            <span class="input-group-text datepicker-icon" style="cursor: pointer"><i class="fas fa-calendar-alt"></i></span>
                                          </div>
                                        </div>
                                        <p class="text-danger" id="endDateErrorMessage"></p>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn btn-primary" id="academicYear-store">Save</button>
                                    <button class="btn btn-primary d-none" id="academicYear-edit">Update</button>
                                    <button class="btn btn-danger d-none" id="academicYear-cancel">Cancel</button>

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

    $('#academicYearsTable').DataTable({
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

    $('.dateInput').each(function() {
        $(this).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });

    $('.datepicker-icon').click(function() {
        $(this).closest('.form-group').find('.dateInput').datepicker('show');
    });

    $("#academicYear-store").click(function(e) {

        e.preventDefault();

        var academic_year = $("#academicYear").val();
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();

        // var date = $("#date").val();

        // var academic_id = $('#academicId').val();
        // console.log('academic year is' + academic_id);

        $.ajax({
            type: 'POST',
            url: "{{ route('academic-years.store') }}",
            data: {
                academic_year: academic_year,
                start_date: start_date,
                end_date: end_date,
            },
            success: function(response) {
                if(response == 'success'){

                    $('#academicYear-store').closest('form').find("input[type=text],select").val("");

                    $("#academicYearsTable").load(window.location + " #academicYearsTable");
                    toastr.options.timeOut = 5000;
                    toastr.success('Successfully added!');
                    
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);

                let academicYearErrorMessage = response.errors.academic_year ? response.errors.academic_year[0] : '';
                let startDateErrorMessage = response.errors.start_date ? response.errors.start_date[0] : '';
                let endDateErrorMessage = response.errors.end_date ? response.errors.end_date[0] : '';

                if (academicYearErrorMessage) {
                    $('#academicYearErrorMessage').html(academicYearErrorMessage);
                    $('#academicId').addClass('is-invalid');
                } else {
                    $('#academicYearErrorMessage').html('');
                    $('#academicId').removeClass('is-invalid');
                }

                if (startDateErrorMessage) {
                    $('#startDateErrorMessage').html(startDateErrorMessage);
                    $('#startDate').addClass('is-invalid');
                } else {
                    $('#startDateErrorMessage').html('');
                    $('#startDate').removeClass('is-invalid');
                }

                if (endDateErrorMessage) {
                    $('#endDateErrorMessage').html(endDateErrorMessage);
                    $('#endDate').addClass('is-invalid');
                } else {
                    $('#endDateErrorMessage').html('');
                    $('#endDate').removeClass('is-invalid');
                }

            },
        });

    });

    $("#academicYear-edit").click(function(e) {

        e.preventDefault();

        // var academic_id = $('#academicId').val();
        // console.log('academic id is ' + academic_id);
        var academicYear = $('#academicYear').val();
        var start_date = $("#startDate").val();
        var id = $("#academicYear_id").val();
        var end_date = $("#endDate").val();


        $.ajax({
            type: 'POST',
            url: '{{route('academic-years.edit')}}',
            data: {
                id: id,
                academic_year: academicYear,
                start_date: start_date,
                end_date: end_date,
            },

            success: function(response) {

                    if(response == 'success'){

                        $('#academicYear-edit').closest('form').find("input[type=text],select").val("");

                        $('#cardTitle').text('New Academic Year');

                        $("#academicYear-store").removeClass('d-none');
                        $("#academicYear-edit").addClass('d-none');
                        $("#academicYear-cancel").addClass('d-none');

                        $("#academicYearsTable").load(window.location + " #academicYearsTable");
                        toastr.options.timeOut = 5000;
                        toastr.success('Successfully updated!');


                    }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);

                let academicYearErrorMessage = response.errors.academic_year ? response.errors.academic_year[0] : '';
                let startDateErrorMessage = response.errors.start_date ? response.errors.start_date[0] : '';
                let endDateErrorMessage = response.errors.end_date ? response.errors.end_date[0] : '';

                if (academicYearErrorMessage) {
                    $('#academicYearErrorMessage').html(academicYearErrorMessage);
                    $('#academicYear').addClass('is-invalid');
                } else {
                    $('#academicYearErrorMessage').html('');
                    $('#academicYear').removeClass('is-invalid');
                }

                if (startDateErrorMessage) {
                    $('#startDateErrorMessage').html(startDateErrorMessage);
                    $('#startDate').addClass('is-invalid');
                } else {
                    $('#startDateErrorMessage').html('');
                    $('#startDate').removeClass('is-invalid');
                }

                if (endDateErrorMessage) {
                    $('#endDateErrorMessage').html(endDateErrorMessage);
                    $('#endDate').addClass('is-invalid');
                } else {
                    $('#endDateErrorMessage').html('');
                    $('#endDate').removeClass('is-invalid');
                }

            },
        });
    });

    function deleteAcademicYear(id) {

        $.ajax({
            type: 'GET',
            url: '{{ route("academic-years.destroy", ["id" => ":id"]) }}'.replace(':id', id),
            success: function(response) {
                if (response == 'success') {
                    $("#academicYearsTable").load(window.location + " #academicYearsTable");
                    toastr.options.timeOut = 5000;
                    toastr.success('Successfully deleted!');
                }

            }
        });

}


    $("#academicYear-cancel").click(function(e) {

        e.preventDefault();

        $(this).closest('form').find("input[type=text],select, textarea").val("");

        $('#cardTitle').text('New Academic Year');


        $("#academicYear-edit").addClass('d-none');
        $("#academicYear-cancel").addClass('d-none');
        $("#academicYear-store").removeClass('d-none');

    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    function editAcademicYear(id) {
        // var type = $("#type_"+id).text();
        var academic_year = $('#academicYear_' + id).text();
        var start_date = $("#startDate_" + id).text();
        var end_date = $('#endDate_' + id).text();
        var academic_id = $('#academic_' + id).val();
        console.log('start date is ' + start_date);
        console.log('end date is ' + end_date);
        console.log('academic_id is ' + academic_id);

        $('#cardTitle').text('Edit Academic Year');


        $('#academicYear').val(academic_year);
        $("#startDate").val(start_date);
        $('#endDate').val(end_date);
        // $('#academicId').val(academic_id);
        $("#academicYear_id").val(academic_id);

        $("#academicYear-store").addClass('d-none');
        $("#academicYear-edit").removeClass('d-none');
        $("#academicYear-cancel").removeClass('d-none');
    }


</script>
@endsection
