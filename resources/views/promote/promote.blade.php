@extends('layouts.app')

@section('styles')
<style>
    .larger-checkbox {
        transform: scale(1.3);
    }

    td{
        text-align: center
    }

    th{
        text-align: center !important;
    }
</style>
@endsection

@section('content')

@if (count($students) != 0)
<div class="mx-5 py-5">

    <h3 class="mb-4">Select Students To Promote</h3>

    <form  method="post" id="promoteForm" action="{{route('promote.student')}}">
        @csrf

        <table id="studentsTable" class="w-100 table table-striped" >
            <thead>
                <tr>
                    <th class="col-1">
                        <input type="checkbox" name="" id="checkAll" class="larger-checkbox">
                    </th>
                    <th class="col-1">No</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Grade</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1 @endphp
                @foreach ($students as $student)
                    <div class="userList">

                    <tr>
                        <td class="col-1">
                            <input type="checkbox" name="selected_students[]" value="{{$student->user_id}}" id="" class=" checkbox larger-checkbox">
                        </td>
                        <td class="col-1 text-center">{{ $count++ }}</td>
                        <td class=" text-center">{{$student->user_id}}</td>
                        <td>{{ $student->user_name }}</td>
                        <td>{{ $student->grade_name }}</td>
                        <td>{{ $student->class_name }}</td>
                    </tr>
                </div>
                @endforeach
            </tbody>
        </table>

        {{-- <button type="submit">Promote In</button> --}}

        {{-- <button id="promoteBtn" class="btn btn-primary mr-2"> Promote In</button> --}}


        <div class="form-group mt-5 text-center">
            <button type="button" id="addSourceBtn" class="btn btn-success" data-toggle="modal" data-target="#studentPromoteModal">
                <i class="fa fa-upload" aria-hidden="true"></i>    Promote In
            </button>
            {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#studentPromoteModal">
                Launch Default Modal
            </button> --}}

            <div class="modal fade" id="studentPromoteModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Promote Selected Students In</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body py-4">
                        <div id="selectSection">
                            {{-- <h4>Update or Delete Class</h4> --}}
                                <label for="" class="form-label required float-left">Select Grade</label>
                                <select name="gradeSelect" id="gradeSelect" class="form-control">
                                    <option value="">Select Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger mt-1" id="gradeErrorMessage"></p>

                                <label for="" class="form-label required float-left">Select Class</label>
                                <select name="classSelect" id="classSelect" class="form-control">
                                    <option value="">Select Class</option>
                                </select>
                                <p class="text-danger mt-1" id="classErrorMessage"></p>

                                <div class="mt-4">
                                    <button id="promoteBtn" class="btn btn-primary mr-2"> Promote</button>
                                </div>
                            </div>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
        </div>
    </form>


</div>
@else
    <div class="text-center pt-5" >
        <h4>
            No Students Found In this class
        </h4>

        <div class="mt-5">
            {{-- <a href="{{route('curricula.create') }}"> --}}
                <button class="btn btn-primary" onclick="window.location.href = document.referrer;"> <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Back </button>
            {{-- </a> --}}
        </div>

    </div>
@endif


@endsection

@section('scripts')
<script>

    $(document).ready(function(){
        $('#studentsTable').DataTable({
            "ordering": false,
            info : false
        });

        $('#checkAll').change(function(){
            var isChecked = $(this).prop('checked');

            $('.checkbox').prop('checked', isChecked);
        });

        $('.checkbox').change(function(){
            var anyUnchecked = $('.checkbox').not(':checked').length > 0;
            $('#checkAll').prop('checked', !anyUnchecked);
        });

        $('#promoteBtn').click(function(e){

            e.preventDefault();

            if ($('#gradeSelect').val() == '' || $('#classSelect').val() == '') {
                if ($('#gradeSelect').val() == '') {
                    $('#gradeSelect').addClass('is-invalid');
                    $('#gradeErrorMessage').text('Please Select Grade To Delete');
                }
                if ($('#classSelect').val() == '') {
                    $('#classSelect').addClass('is-invalid');
                    $('#classErrorMessage').text('Please Select Class To Delete');
                }
            }
            else {
                $('#promoteForm').submit();
            }
        });


        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty(); // Clear previous options
            $('#selectBoxError1').text('');

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
