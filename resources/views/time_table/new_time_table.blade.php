@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <!-- left column -->
        <div class="col-md-5 mt-5">
            <div class="card card-primary">
                <div class="card-header">
                    <div>
                    <h3 class="card-title">Add New TimeTable</h3>
                    </div>
                </div>

                <div class="card-body">
                    <form id="attendanceSearchForm" action="{{route('timetable.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                            <label for="" class="form-label required">Browse File</label>
                            <input type="file" name="file" id="" class="form-control">
                            <p class="text-danger mt-1" id="fileInputBoxError"></p>
                        </div> --}}

                        <div class="form-group">
                            <label for="exampleInputFile" class="mt-2">File</label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" id="inputFileLabel"  for="exampleInputFile"> Choose File
                                    {{-- {{ $student->userGradeClasses[0]->examMarks[0]->file ?? 'Choose File' }} --}}
                                </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-info mr-2">Save</button>
                            <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                        </div>
                    </form>
               </div>
            </div>
        </div>
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
              var filename = $(this).val().split('\\').pop(); // Get filename from path
              $(this).next('.custom-file-label').html(filename);
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

        $('#cancelBtn').click(function(){
            $('#gradeSelect').val('');
            $('#classSelect').val('');
            $('#inputFileLabel').html('Choose File');
        });

    });
</script>
@endsection
