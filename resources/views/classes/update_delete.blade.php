@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">

            {{-- <div id="selectSection">
                <h4>Update or Delete Class</h4>
                <select name="" id="gradeSelect" class="form-control">
                    <option value="">Select Grade</option>
                    @foreach ($grades as $grade)
                        <option value="{{$grade->id}}" data-description="{{$grade->description}}">{{$grade->grade_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger mt-1" id="selectBoxError"></p>

                <select name="" id="gradeSelect" class="form-control">
                    <option value="">Select Class</option>
                    @foreach ($grades as $grade)
                        @foreach ($grade->classes as $class)
                            <option value="{{$class->id}}" data-description="{{$class->description}}">{{$class->class_name}}</option>
                        @endforeach
                    @endforeach
                </select>
                <p class="text-danger mt-1" id="selectBoxError"></p>

                <div class="mt-4">
                    <button id="updateBtn" class="btn btn-primary mr-2">Update</button>
                    <button id="deleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div> --}}

            <div id="selectSection">
                <h4>Update or Delete Class</h4>
                <label for="" class="form-label">Select Grade</label>
                <select name="gradeSelect" id="gradeSelect" class="form-control">
                    <option value="">Select Grade</option>
                    @foreach ($grades as $grade)
                        <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger mt-1" id="selectBoxError1"></p>

                <label for="" class="form-label">Select Class</label>
                <select name="classSelect" id="classSelect" class="form-control">
                    <option value="">Select Class</option>
                </select>
                <p class="text-danger mt-1" id="selectBoxError2"></p>

                <div class="mt-4">
                    <button id="updateBtn" class="btn btn-primary mr-2">Update</button>
                    <button id="deleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>

            <form id="updateClassForm" style="display: none">
                <div class="card-body">
                  <div class="form-group">
                      <label for="" class="form-label">Select Grade</label>
                      <select name="grade_id" id="gradeSelect" class="form-control">
                          <option value="">Select Grade</option>
                          @foreach ($grades as $grade)
                              <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                          @endforeach
                      </select>
                      <p class="text-danger" id="gradeIdErrorMessage"></p>
                  </div>

                  <p class="text-danger mt-1" id="selectBoxError"></p>
                  <div class="form-group">
                      <label for="" class="form-label">Name</label>
                      <input type="text" name="name" id="classInputBox" class="form-control" placeholder="Name of Grade">
                      <p class="text-danger" id="nameErrorMessage"></p>
                  </div>
                  <div class="form-group">
                      <label for="" class="form-label">Description</label>
                      <textarea name="description" id="descInputBox" class="form-control" placeholder="Enter Description">{{ old('description') }}</textarea>
                      <p class="text-danger" id="descErrorMessage"></p>
                </div>

                <!-- /.card-body -->
                <div class="">
                  <button type="submit" class="btn btn-info mr-2">Save</button>
                  <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
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
                $('#selectBoxError1').text('');

                $('#classSelect').removeClass('is-invalid');
                $('#selectBoxError2').text('');
            }

            $('#gradeSelect').change(function() {
                clearError();
            });

            $('#updateBtn').click(function() {

                if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '') {
                    var selectedGradeId = $('#gradeSelect').val();
                    var selectedGradeName = $('#gradeSelect option:selected').text();
                    // var selectedGradeDescription = $('#gradeSelect option:selected').data('description');

                    $('#gradeId').val(selectedGradeId);
                    $('#gradeInputBox').val(selectedGradeName);
                    // $('#descInputBox').val(selectedGradeDescription);

                    var selectedClassId = $('#classSelect').val();
                    var selectedClassName = $('#classSelect option:selected').text();
                    var selectedClassDescription = $('#classSelect option:selected').data('description');

                    $('#classId').val(selectedClassId);
                    $('#classInputBox').val(selectedClassName);
                    $('#descInputBox').val(selectedClassDescription);


                    $('#selectSection').hide();
                    $('#updateClassForm').show();
                } else {
                    if ($('#gradeSelect').val() == '') {
                        $('#gradeSelect').addClass('is-invalid');
                        $('#selectBoxError1').text('Please Select Grade To Update');
                    }
                    if ($('#classSelect').val() == '') {
                        $('#classSelect').addClass('is-invalid');
                        $('#selectBoxError2').text('Please Select Class To Update');
                    }
                }
                });


            $('#deleteBtn').click(function(){
                if($('#gradeSelect').val() != ''){
                    var selectedGradeId = $('#gradeSelect').val();

                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('grades.destroy', ['grade' => ':grade']) }}'.replace(':grade', selectedGradeId),
                        data: $(this).serialize(),
                        success: function (response) {
                            if(response == 'success'){
                                window.location.href = '{{ route('grades.index') }}';
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
                }else{
                    $('#gradeSelect').addClass('is-invalid');
                    $('#selectBoxError').text('Please Select Grade To Delete');
                }
            });

            $('#cancelBtn').click(function() {
                $('#selectSection').show();
                $('#updateClassForm').hide();
            });

            $('#updateGradeForm').submit(function (e) {
                // alert('hello');
                e.preventDefault();

                var gradeId = $('#gradeId').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('grades.update', ['grade' => ':grade']) }}'.replace(':grade', gradeId),
                    data: $(this).serialize(),
                    success: function (response) {
                        // alert('hello');
                        if(response == 'success'){
                            window.location.href = '{{ route('grades.index') }}';
                        }
                        },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        var response = JSON.parse(xhr.responseText);
                            console.log(response);
                        let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                        let descErrorMessage = response.errors.description ? response.errors.description[0] : '';

                        // $('#nameErrorMessage').html(nameErrorMessage);
                        $('#descErrorMessage').html(descErrorMessage);

                        if (nameErrorMessage) {
                            $('#nameErrorMessage').html(nameErrorMessage);
                            $('#gradeInputBox').addClass('is-invalid');
                        } else {
                            $('#nameErrorMessage').html('');
                            $('#gradeInputBox').removeClass('is-invalid');
                        }

                        if (descErrorMessage) {
                            $('#descErrorMessage').html(descErrorMessage);
                            $('#descInputBox').addClass('is-invalid');
                        } else {
                            $('#descErrorMessage').html('');
                            $('#descInputBox').removeClass('is-invalid');
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

                // var selectedGrade = $(this).val();
                // if (selectedGrade !== '') {
                //     $('#classSelect').prop('disabled', false);
                //     $('#selectBoxError1').text('');
                // } else {
                //     $('#classSelect').prop('disabled', true);
                //     $('#selectBoxError1').text('Please select a grade first');
                //     $('#selectBoxError2').text('');
                // }

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
