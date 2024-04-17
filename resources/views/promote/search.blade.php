@extends('layouts.app')

@section('styles')
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">

            <form method="post" id="searchGradeClassForm" action="{{route('promote.search.results')}}">
                @csrf
                <div id="selectSection">
                {{-- <h4>Update or Delete Class</h4> --}}
                    <label for="" class="form-label required">Select Grade</label>
                    <select name="gradeSelect" id="gradeSelect" class="form-control">
                        <option value="">Select Grade</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger mt-1" id="gradeErrorMessage"></p>

                    <label for="" class="form-label required">Select Class</label>
                    <select name="classSelect" id="classSelect" class="form-control">
                        <option value="">Select Class</option>
                    </select>
                    <p class="text-danger mt-1" id="classErrorMessage"></p>

                    <div class="mt-4">
                        <button id="searchBtn" class="btn btn-primary mr-2"> <i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
                $('#gradeErrorMessage').text('');

                $('#classSelect').removeClass('is-invalid');
                $('#classErrorMessage').text('');
            }

            $('#gradeSelect').change(function() {
                clearError();
            });

            $('#cancelBtn').click(function() {
                $('#selectSection').show();
                $('#updateClassForm').hide();

                $('#nameErrorMessage').html('');
                $('#classInputBox').removeClass('is-invalid');

                $('#gradeErrorMessage').html('');
                $('#grade_id').removeClass('is-invalid');

            });

            $('#searchBtn').click(function(e){

                e.preventDefault();

                if ($('#gradeSelect').val() == '' || $('#classSelect').val() == '') {
                    if ($('#gradeSelect').val() == '') {
                        $('#gradeSelect').addClass('is-invalid');
                        $('#gradeErrorMessage').text('Please Select Grade');
                    }
                    if ($('#classSelect').val() == '') {
                        $('#classSelect').addClass('is-invalid');
                        $('#classErrorMessage').text('Please Select Class');
                    }
                }
                else {
                    $('#searchGradeClassForm').submit();
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
