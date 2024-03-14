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

            <div id="selectSection">
                <h4>Update or Delete Class</h4>
                <label for="" class="form-label required">Select Grade</label>
                <select name="gradeSelect" id="gradeSelect" class="form-control">
                    <option value="">Select Grade</option>
                    @foreach ($grades as $grade)
                        <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger mt-1" id="selectBoxError1"></p>

                <label for="" class="form-label required">Select Class</label>
                <select name="classSelect" id="classSelect" class="form-control">
                    <option value="">Select Class</option>
                </select>
                <p class="text-danger mt-1" id="selectBoxError2"></p>

                <div class="mt-4">
                    <button id="updateBtn" class="btn btn-primary mr-2">Update</button>
                    <button id="deleteBtn" class="btn btn-danger">Delete</button>

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

            <form id="updateClassForm" style="display: none">
                @csrf

                @method('PATCH')

                <input type="hidden" name="" id="classId" value="">

                <div class="card-body">
                  <div class="form-group">
                      <label for="" class="form-label required">Select Grade</label>
                      <select name="grade_id" class="form-control" id="grade_id">
                          <option value="">Select Grade</option>
                          @foreach ($grades as $grade)
                              <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                          @endforeach
                      </select>
                      <p class="text-danger" id="gradeErrorMessage"></p>
                  </div>

                  <p class="text-danger mt-1" id="selectBoxError1"></p>
                  <div class="form-group">
                      <label for="" class="form-label required">Name</label>
                      <input type="text" name="name" id="classInputBox" class="form-control" placeholder="Enter Class Name">
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
                    // console.log(selectedGradeId);
                    var selectedGradeName = $('#gradeSelect option:selected').text();
                    // var selectedGradeDescription = $('#gradeSelect option:selected').data('description');

                    // $('#gradeId').val(selectedGradeId);
                    $('#gradeInputBox').val(selectedGradeName);

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
                if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '') {

                    var selectedGradeName = $('#gradeSelect option:selected').text();

                    var selectedClassId = $('#classSelect').val();

                    var selectedClassName = $('#classSelect option:selected').text();

                    $('#deleteClassModal').modal('show');

                    $('#textInsideModal').text(selectedClassName + ' of ' + selectedGradeName + '?');

                    $('#deleteBtnInsideModal').click(function(){
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('classes.destroy', ['class' => ':class']) }}'.replace(':class', selectedClassId),
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

            $('#cancelBtn').click(function() {
                $('#selectSection').show();
                $('#updateClassForm').hide();

                $('#nameErrorMessage').html('');
                $('#classInputBox').removeClass('is-invalid');

                $('#gradeErrorMessage').html('');
                $('#grade_id').removeClass('is-invalid');

            });

            $('#updateClassForm').submit(function (e) {
                // alert('hello');
                e.preventDefault();

                var classId = $('#classId').val();
                console.log(classId);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('classes.update', ['class' => ':class']) }}'.replace(':class', classId),
                    data: $(this).serialize(),
                    success: function (response) {
                        // alert('hello');
                        if(response == 'success'){
                            window.location.href = '{{ route('classes.index') }}';
                        }
                        },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        var response = JSON.parse(xhr.responseText);
                            console.log(response);
                        let gradeErrorMessage = response.errors.grade_id ? response.errors.grade_id[0] : '' ;
                        let nameErrorMessage = response.errors.name ? response.errors.name[0] : '';
                        let descErrorMessage = response.errors.description ? response.errors.description[0] : '';

                        // $('#nameErrorMessage').html(nameErrorMessage);
                        // $('#descErrorMessage').html(descErrorMessage);

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
