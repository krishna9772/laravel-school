@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <!-- left column -->

            @if (Auth::user()->hasRole('admin'))
                <div class="col-md-5 mt-5" id="selectSection">



                    <div class="card card-primary">
                        <div class="card-header">
                            <div>
                            <h3 class="card-title">Edit Time Table</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- action="{{route('timetable.store')}}" method="POST" enctype="multipart/form-data"> --}}
                                {{-- @csrf --}}


                                <div class="form-group">
                                    <label for="" class="form-label required">Select Grade</label>
                                    <select name="grade_select" id="gradeSelect" class="form-control">
                                        <option value="">Select Grade</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger mt-1" id="gradeSelectBoxError"></p>
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label required">Select Class</label>
                                    <select name="class_select" id="classSelect" class="form-control">
                                        <option value="">Select Class</option>
                                    </select>
                                    <p class="text-danger mt-1" id="classSelectBoxError"></p>
                                </div>

                                {{-- <div class="form-group">
                                    <input type="text" name="file" id="" value="">
                                </div> --}}

                                <div class="mt-4">
                                    <button type="button" id="updateBtn" class="btn btn-primary mr-2">Update</button>
                                    <button type="button" id="deleteBtn" class="btn btn-danger">Delete</button>

                                    <div class="modal fade" id="deleteClassModal">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class='modal-header'>
                                                <p class='col-12 modal-title text-center'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button><br><br>
                                                <span class=" text-dark" style="font-size: 18px">Are you sure to delete <br>
                                                    <span class=" font-weight-bold text-dark" style="font-size: 19px" id="textInsideModal">  </span>
                                                </span>

                                                </p>
                                            </div>

                                            <div class="modal-footer  justify-content-center ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button type="button" id="deleteBtnInsideModal" class="btn btn-danger deleteBtn">Delete</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>

                    </div>
                    </div>
                </div>

                {{-- <div id="updateSection"> --}}
                <form id="updateTimeTableForm" style="display: none" class="mt-5" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="grade_select" id="gradeId" value="">
                    <input type="hidden" name="class_select" id="classId" value="">

                    <div class="card card-primary">
                        <div class="card-header">
                            <div>
                            <h3 class="card-title">Update Time Table of <span id="gradeName"></span> <span id="className"></span> </h3>
                            </div>
                        </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="fileInput" class="mt-2">File</label>
                            <span id="oldFileName"></span>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="fileInput">
                                <label class="custom-file-label" id="inputFileLabel"  for="fileInput"> Choose New File
                                    {{-- {{ $student->userGradeClasses[0]->examMarks[0]->file ?? 'Choose File' }} --}}
                                </label>
                                </div>
                            </div>
                        </div>

                    <!-- /.card-body -->
                    <div class="">
                        <button type="submit" class="btn btn-info mr-2">Save</button>
                        <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            @endif

            @if (Auth::user()->hasRole('class teacher') )
                <div class="card card-primary mt-5">
                    <div class="card-header">
                        <div>
                        <h3 class="card-title">Update TimeTable In {{$gradeName}} - {{$className}} </h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="" action="{{route('timetables.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="grade_select" id="gradeSelect" value="{{$userData->grade_id}}">
                            <input type="hidden" name="class_select" id="classSelect" value="{{$userData->class_id}}">

                            <div class="form-group">
                                <label for="exampleInputFile" class="mt-2">File</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="exampleInputFile">
                                    <label class="custom-file-label" id="inputFileLabel"  for="exampleInputFile"> Choose File
                                        {{-- {{ $student->userGradeClasses[0]->examMarks[0]->file ?? 'Choose File' }} --}}
                                    </label>
                                    </div>
                                </div>
                                @error('file')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-info mr-2">Update</button>
                                {{-- <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button> --}}
                            </div>
                        </form>
                    </div>
                </div>

            @endif


            {{-- </div> --}}
    </div>
</div>
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

        $('.custom-file-input').change(function() {
              var filename = $(this).val().split('\\').pop();
              $(this).next('.custom-file-label').html(filename);
          });

        $('#updateBtn').click(function() {


            if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '') {

                // console.log('right');

                var selectedGradeId = $('#gradeSelect').val();
                // console.log(selectedGradeId);
                var selectedGradeName = $('#gradeSelect option:selected').text();
                // var selectedGradeDescription = $('#gradeSelect option:selected').data('description');

                $('#gradeId').val(selectedGradeId);
                $('#gradeInputBox').val(selectedGradeName);

                $('#gradeName').html(selectedGradeName);

                $('#grade_id option').each(function() {

                    if ($(this).val() == selectedGradeId) {
                        $(this).prop('selected', true);
                    }
                });

                var selectedClassId = $('#classSelect').val();
                var selectedClassName = $('#classSelect option:selected').text();
                var selectedClassDescription = $('#classSelect option:selected').data('description');

                $('#classId').val(selectedClassId);
                $('#classInputBox').val(selectedClassName);
                $('#descInputBox').val(selectedClassDescription);

                $('#className').html(selectedClassName);

                $('#selectSection').hide();
                $('#updateTimeTableForm').show();

                $.ajax({
                    type: 'GET',
                    url: '{{ route('timetables.get.file.name') }}',
                    data: {
                        grade_id : selectedGradeId,
                        class_id : selectedClassId
                    },
                    success: function (response) {

                        console.log(response[0]);

                        // if(response != ''){
                            // $('#oldFileName').html(" - Old file - " + response[0]);

                            // $('#fileInput').val(response[0]);

                            $('#inputFileLabel').html(response[0]);
                        // }

                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        var response = JSON.parse(xhr.responseText);
                        console.log(response);
                    },
                    failure: function (response) {
                        console.log('faliure');
                    }
                });

            } else {

                console.log('error');

                if ($('#gradeSelect').val() == '') {
                    $('#gradeSelect').addClass('is-invalid');
                    $('#gradeSelectBoxError').text('Please Select Grade To Update');
                }
                if ($('#classSelect').val() == '') {
                    $('#classSelect').addClass('is-invalid');
                    $('#classSelectBoxError').text('Please Select Class To Update');
                }
            }

        });

        $('#deleteBtn').click(function(){
            if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '') {

                var selectedGradeName = $('#gradeSelect option:selected').text();

                var selectedGradeId = $('#gradeSelect').val();

                var selectedClassId = $('#classSelect').val();

                var selectedClassName = $('#classSelect option:selected').text();

                $('#deleteClassModal').modal('show');

                $('#textInsideModal').text('Time Table of ' + selectedGradeName + ' - ' + selectedClassName + '?');

                $('#deleteBtnInsideModal').click(function(){
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('timetables.destroy', ['gradeId' => ':gradeId', 'classId' => ':classId']) }}'.replace(':gradeId', selectedGradeId).replace(':classId', selectedClassId),
                        data: $(this).serialize(),
                        success: function (response) {

                            if(response == 'success'){
                                window.location.href = '{{ route('classes.index') }}';
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            var response = JSON.parse(xhr.responseText);
                            console.log(response);
                        },
                        failure: function (response) {
                            console.log('faliure');
                        }
                    });
                });
            }else{
                if ($('#gradeSelect').val() == '') {
                    $('#gradeSelect').addClass('is-invalid');
                    $('#selectBoxError1').text('Please Select Grade To Delete');
                }
                if ($('#classSelect').val() == '') {
                    $('#classSelect').addClass('is-invalid');
                    $('#selectBoxError2').text('Please Select Class To Delete');
                }
            }
        });

        $('#updateTimeTableForm').submit(function (e) {
            // alert('hello');
            e.preventDefault();

            // var class_select = $('#classId').val();
            // console.log(class_select);

            // var grade_select = $('#gradeId').val();
            // console.log('grade id is ' + grade_select);

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('timetables.update') }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // alert('hello');
                    if(response == 'success'){
                        console.log(response);

                        window.location.href = '{{ route('timetables.list') }}';
                    }
                    },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var response = JSON.parse(xhr.responseText);
                        console.log(response);
                    let gradeErrorMessage = response.errors.grade_id ? response.errors.grade_id[0] : '' ;
                    let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                    let descErrorMessage = response.errors.description ? response.errors.description[0] : '';

                    if(gradeErrorMessage){
                        $('#gradeErrorMessage').html(gradeErrorMessage);
                        $('#grade_id').addClass('is-invalid');
                    }else{
                        $('#gradeErrorMessage').html('');
                        $('#grade_id').removeClass('is-invalid');
                    }


                    if (nameErrorMessage) {
                        $('#nameErrorMessage').html(nameErrorMessage);
                        $('#classInputBox').addClass('is-invalid');
                    } else {
                        $('#nameErrorMessage').html('');
                        $('#classInputBox').removeClass('is-invalid');
                    }
                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
        });

        function clearError() {
            $('#gradeSelect').removeClass('is-invalid');
            $('#gradeSelectBoxError').text('');

            $('#classSelect').removeClass('is-invalid');
            $('#classSelectBoxError').text('');
        }

        $('#gradeSelect').change(function() {
            clearError();
        });

        $('#classSelect').change(function(){
            clearClassSelectBoxError();
        });

        // $('#attendanceSearchForm').submit(function(e){
        //     e.preventDefault();

        //     $.ajax({
        //         type: 'POST',

        //     })
        // });

        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty(); // Clear previous options
            $('#selectBoxError1').text('');

            if (gradeId === '') {
                $('#classSelect').append($('<option>', {
                    value: '',
                    text : 'Select Class',
                }));
            } else {
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
                $('#classSelectBoxError').text('First, Select a grade');
            } else {
                $('#classSelectBoxError').text('');
            }
        });

    });
</script>
@endsection
