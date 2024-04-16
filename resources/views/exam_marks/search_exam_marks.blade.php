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
                        <h3 class="card-title">Search Exam Marks</h3>
                    </div>
                </div>

                <div class="card-body">
                    <form id="attendanceSearchForm" action="{{route('exam-marks.search.results')}}" method="POST" >
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

                        <div class="mt-4">
                            <button type="submit" class="btn btn-info mr-2">Search</button>
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

        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty();
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
