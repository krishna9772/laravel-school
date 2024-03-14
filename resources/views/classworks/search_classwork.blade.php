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
                    <h3 class="card-title">Search Classwork</h3>
                    </div>
                </div>

                <div class="card-body">
                    <form id="classworkSearchForm">
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

        $('#classworkSearchForm').submit(function (e) {
            e.preventDefault();

            // var classId = $('#classId').val();
            // console.log(classId);

            $.ajax({
                type: 'POST',
                url: '{{route('classworks.search_results')}}',
                data: $(this).serialize(),
                success: function (response) {

                    console.log('success');

                    if(response == 'success'){
                        // window.location.href = '{{ route('classworks.index') }}';
                    }
                    },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var response = JSON.parse(xhr.responseText);
                        console.log(response);

                    let gradeSelectBoxError = response.errors.grade_select ? response.errors.grade_select[0] : '';
                    let classSelectBoxError = response.errors.class_select ? response.errors.class_select[0] : '';

                    if (gradeSelectBoxError) {
                        $('#gradeSelectBoxError').html(gradeSelectBoxError);
                        $('#gradeSelect').addClass('is-invalid');
                    } else {
                        $('#gradeSelectBoxError').html('');
                        $('#gradeSelect').removeClass('is-invalid');
                    }

                    if (classSelectBoxError) {
                        $('#classSelectBoxError').html(classSelectBoxError);
                        $('#classSelect').addClass('is-invalid');
                    } else {
                        $('#classSelectBoxError').html('');
                        $('#classSelect').removeClass('is-invalid');
                    }

                },
                failure: function (response) {
                    console.log('faliure');
                }
            });
        });


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
