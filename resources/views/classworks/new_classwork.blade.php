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

<section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <!-- left column -->
        <div class="col-md-5 mt-5">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New Classwork</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="addClassworkForm" method="POST" action="{{route('classworks.store')}}" enctype="multipart/form-data">
                @csrf

              <div class="card-body">

                @if (Auth::user()->user_type != 'teacher' && Auth::user()->user_type != 'student')
                    <div class="form-group">
                        <label for="" class="form-label required">Grade</label>
                        <select name="gradeSelect" id="gradeSelect" class="form-control">
                            <option value="">Select Grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                            @endforeach
                        </select>
                        <p class="text-danger mt-1" id="gradeSelectError"></p>
                    </div>

                    {{-- <div class="form-group">
                        <label for="" class="form-label">Curriculu select Grade</label>
                        <select name="" id="" class="form-control">
                            <option value="">Select Curr</option>
                            @foreach ($grades as $grade)
                                @foreach ($grade->curricula as $curriculum)
                                <option value="{{$curriculum->id}}">{{$curriculum->curriculum_name}}</option>
                                @endforeach

                            @endforeach
                        </select>
                        <p class="text-danger mt-1" id="selectBoxError1"></p>
                    </div> --}}


                    <div class="form-group">
                        <label for="" class="form-label required">Class</label>
                        <select name="classSelect" id="classSelect" class="form-control">
                            <option value="">Select Class</option>
                        </select>
                        <p class="text-danger mt-1" id="classSelectError"></p>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label required">Subjects</label>
                        <select name="curriculumSelect" id="curriculumSelect" class="form-control">
                            <option value="">Select Subject</option>
                        </select>
                        <p class="text-danger mt-1" id="curriculumSelectError"></p>
                    </div>

                @elseif (Auth::user()->user_type == 'teacher')

                    <input type="hidden" name="gradeSelect" value="{{$teacherGradeClass->userGradeClasses[0]->grade_id}}">
                    <input type="hidden" name="classSelect" value="{{$teacherGradeClass->userGradeClasses[0]->class_id}}">

                    <div class="form-group">
                        <label for="" class="form-label required">Subjects</label>
                        <select name="curriculumSelect" id="curriculumSelect" class="form-control">
                            <option value="">Select Subject</option>
                            @foreach ($curriculums as $curriculum)
                                <option value="{{$curriculum->id}}">{{$curriculum->curriculum_name}}</option>
                            @endforeach
                        </select>
                        <p class="text-danger mt-1" id="curriculumSelectError"></p>
                    </div>

                @endif




                <div class="form-group">
                    <label for="" class="form-label required">Main Topic Name</label>
                    <input type="text" name="topic_name" id="topicNameInputBox" class="form-control" placeholder="Enter Main Topic Name">
                    <p class="text-danger" id="topicNameError"></p>
                </div>

                <div id="dynamicRows"></div>

                <div class="form-group">
                    <button type="button" id="addSourceBtn" class="btn btn-success" data-toggle="modal" data-target="#newClassworkModal"><i class="fa fa-plus"></i> Add Source</button>
                    {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newClassworkModal">
                        Launch Default Modal
                    </button> --}}

                    <div class="modal fade" id="newClassworkModal">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Source Type</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body py-4">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="mx-3 border-0 bg-white" id="urlBtn">
                                        <img src="{{asset('images/menu_icons/url image.jpg')}}" width="70px">
                                        <p class="mt-2">URL</p>
                                    </button>
                                    <button type="button" class="mx-3 border-0 bg-white" id="fileBtn">
                                        <img src="{{asset('images/menu_icons/files (1).png')}}" width="70px">
                                        <p class="mt-2">File</p>
                                    </button>
                                </div>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->

                    <button type="button" id="removeBtn" class="btn btn-danger"> <i class="fa fa-minus"></i> Remove</button>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-info mr-2">Save</button>
                    <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                </div>
              </div>
            </form>
          </div>

          <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="errorModalLabel">Error</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
</section>

@endsection

@section('scripts')

<script>


$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var initialFormHTML = $('#addClassworkForm').html();

    function restoreInitialForm() {
        $('#addClassworkForm').html(initialFormHTML);
        inputFieldCount = $("input[name='curriculum_name[]']").length;

        attachEventHandlers();
    }

    attachEventHandlers();

    function attachEventHandlers(){
        function clearGradeIdInputBoxError() {
            $('#gradeSelect').removeClass('is-invalid');
            $('#gradeIdErrorMessage').text('');
        }

        $('#gradeSelect').change(function() {
            clearGradeIdInputBoxError();
        });

        $('#nameInputBox').on('input', function () {
            clearNameInputBoxError();
        });


        function clearNameInputBoxError() {
            $('#nameInputBox').removeClass('is-invalid');
            $('#nameErrorMessage').text('');
        }

        var labelsAdded = false;

        $('#urlBtn').click(function(){
            console.log('hello wro dl');
            $('#newClassworkModal').modal('hide');

            if (!labelsAdded) {

                var newRowWithLabels = `<div class='newAddedRows'>
                                            <input type="hidden" name="source_type[]" value="url">
                                            <input type="hidden" name="file[]" value="" class="fileInputBox">
                                                <div class="form-group">
                                                    <label for="" class="form-label required">Sub Topic Name</label>
                                                    <input type="text" name="sub_topic_name[]" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                                                    <p class="text-danger subTopicNameError"></p>
                                                </div>
                                                <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="" class="form-label required">Source Title</label>
                                                    <input type="text" name="source_title[]" class="form-control sourceTitleInputBox" placeholder="Enter Source Title">
                                                    <p class="text-danger sourceTitleError"></p>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="" class="form-label required">URL Link/Browse File</label>
                                                    <input type="text" name="url[]" class="form-control urlInputBox" placeholder="Enter URL">
                                                    <p class="text-danger urlError"></p>
                                                </div>
                                            </div>
                                        </div>`;

                $('#dynamicRows').append(newRowWithLabels);


                labelsAdded = true;
            } else {

                var newRowWithoutLabels = `<div class='newAddedRows'>
                <input type="hidden" name="source_type[]" value="url">
                <input type="hidden" name="file[]" value="" class="fileInputBox">
                        <div class="form-group">
                            <input type="text" name="sub_topic_name[]" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                            <p class="text-danger subTopicNameError"></p>
                            </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="text" name="source_title[]" class="form-control sourceTitleInputBox" placeholder="Enter Source Title">
                                <p class="text-danger sourceTitleError"></p>
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="url[]" class="form-control urlInputBox" placeholder="Enter URL">
                                <p class="text-danger urlError"></p>
                            </div>
                        </div>
                        </div>`;

                $('#dynamicRows').append(newRowWithoutLabels);
            }

            inputFieldCount++;
            toggleButtons();

        });

        // var labelAdded = false;

        $('#fileBtn').click(function(){
            $('#newClassworkModal').modal('hide');


            if (!labelsAdded) {


                $(document).ready(function() {
                  var newRowWithLabels = `
                  <div class='newAddedRows'>
                      <input type="hidden" name="source_type[]" value="file">
                      <input type="hidden" name="url[]" value="" class="urlInputBox">
                      <div class="form-group">
                          <label for="" class="form-label required">Sub Topic Name</label>
                          <input type="text" name="sub_topic_name[]" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                          <p class="text-danger subTopicNameError"></p>
                      </div>
                      <div class="row">
                          <div class="form-group col-6">
                              <label for="" class="form-label required">Source Title</label>
                              <input type="text" name="source_title[]" class="form-control sourceTitleInputBox" placeholder="Enter Source Title">
                              <p class="text-danger sourceTitleError"></p>
                          </div>
                          <div class="form-group col-6 file-upload-wrapper">
                              <label for="" class="form-label required">URL Link/Browse file</label>
                              <div class="custom-file">
                                  <input type="file" name="file[]" class="custom-file-input fileInputBox" id="customFile">
                                  <label for="customFile" class="custom-file-label">No file chosen</label>
                              </div>
                              <p class="text-danger fileError"></p>
                          </div>
                      </div>
                  </div>`;

                  $('#dynamicRows').append(newRowWithLabels);


                  $('.custom-file-input').change(function() {
                      var filename = $(this).val().split('\\').pop();
                      $(this).next('.custom-file-label').html(filename);
                  });

                });


                labelsAdded = true;
            }else{
                var newRowWithoutLabels = `<div class='newAddedRows'>

                    <input type="hidden" name="source_type[]" value="file">
                    <input type="hidden" name="url[]" value="" class="urlInputBox">
                <div class="form-group">
                    <input type="text" name="sub_topic_name[]" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                    <p class="text-danger subTopicNameError"></p>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <input type="text" name="source_title[]" class="form-control sourceTitleInputBox" placeholder="Enter Source Title">
                        <p class="text-danger sourceTitleError"></p>
                    </div>
                    <div class="form-group col-6 file-upload-wrapper">
                          <div class="custom-file">
                              <input type="file" name="file[]" class="custom-file-input fileInputBox" id="customFile">
                              <label for="customFile" class="custom-file-label">No file chosen</label>
                          </div>
                        <p class="text-danger fileError"></p>
                      </div>
                </div>
            </div>`;

                $('#dynamicRows').append(newRowWithoutLabels);


                $('.custom-file-input').change(function() {
                      var filename = $(this).val().split('\\').pop();
                      $(this).next('.custom-file-label').html(filename);
                  });
            }


            inputFieldCount++;
            toggleButtons();
        });

        $('#removeBtn').click(function(){
            inputFieldCount = $("input[name='source_title[]']").length;
            console.log(inputFieldCount);

            // if(inputFieldCount > 1){
                $("#dynamicRows .newAddedRows:last-child").remove();

            // }
            inputFieldCount--;

            // console.log('input field count is ' + inputFieldCount);
            toggleButtons();

        });

        function removeClassCurriculumErrors() {
            $('#classSelect').removeClass('is-invalid');
            $('#classSelectError').html('');
            $('#curriculumSelect').removeClass('is-invalid');
            $('#curriculumSelectError').html('');
        }

        $('#gradeSelect').change(function () {
            removeClassCurriculumErrors();
        });

        function removeError(field, errorElement) {
            field.removeClass('is-invalid');
            errorElement.html('');
        }

        function validateField(field, errorElement, errorMessage) {
            if (field.val() === '') {
                field.addClass('is-invalid');
                errorElement.html(errorMessage);
            } else {
                removeError(field, errorElement);
            }
        }

        function validateFileType(fileInput) {
            var fileName = fileInput.val();
            var validExtensions = ['doc', 'docx', 'pdf'];
            var fileExtension = fileName.split('.').pop().toLowerCase();

            if ($.inArray(fileExtension, validExtensions) == -1) {
                $('#errorMessage').text('Please select a valid file format (doc, docx, or pdf).');
                $('#errorModal').modal('show');

                fileInput.val('');

                return false;
            }

            return true;
        }


        $('#addClassworkForm').submit(function (e) {
            e.preventDefault();
            // console.log('hello worl d');




            validateField($('#gradeSelect'), $('#gradeSelectError'), 'Grade select field is required');
            validateField($('#classSelect'), $('#classSelectError'), 'Class select field is required');
            validateField($('#curriculumSelect'), $('#curriculumSelectError'), 'Curriculum select field is required');
            validateField($('#topicNameInputBox'), $('#topicNameError'), 'Topic Name field is required');
            // validateField($('.subTopicNameInputBox'),$('.subTopicNameError'), 'Sub Topic Name field is required');
            // validateField($('.sourceTitleInputBox'),$('.sourceTitleError'), 'Source Title field is required');
            // validateField($('.fileInputBox'),$('.fileError'), 'File field is required');
            // validateField($('.urlInputBox'),$('.urlError'), 'Url field is required');

            // function validateNewField(field, errorElement, errorMessage) {
            //     if (field.val() === '') { // Check if field is empty after trimming whitespace
            //         if (!field.hasClass('is-invalid')) { // Check if error is not already shown
            //             field.addClass('is-invalid');
            //             errorElement.html(errorMessage);
            //         }
            //     } else {
            //         removeError(field, errorElement);
            //     }
            // }


            var sourceTitles = $("input[name='source_title[]']");
            // console.log('source titles are ' + sourceTitles);
            var sourceTitleProvided = false;

            sourceTitles.each(function() {
                if ($(this).val() !== '') {

                    // $(this).addClass('is-invalid');
                    // $(this).next('.sourceTitleError').html('Source Title field is required');
                    sourceTitleProvided = true;
                    return false;
                }
            });

            if (!sourceTitleProvided) {
                $('#errorMessage').text('Please add at least one source.');
                $('#errorModal').modal('show');
                return;
            }

            var subTopicNames = $("input[name='sub_topic_name[]']");
            // console.log('sub topic names are ' + subTopicNames);

            subTopicNames.each(function() {
                // console.log("Value of input:", $(this).val());
                if ($(this).val() == '') {
                    console.log('hello world');
                    $(this).addClass('is-invalid');
                    $(this).next('.subTopicNameError').html('Sub Topic Name field is required');
                }
            });

            var urls = $("input[name='url[]']");
            urls.each(function() {
                // console.log("Value of input:", $(this).val());
                if ($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).next('.urlError').html('Url field is required');
                }
            });

            var files = $("input[name='file[]']");
            urls.each(function() {
                // console.log("Value of input:", $(this).val());
                if ($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).next('.fileError').html('File field is required');
                }
            });

            // if(!subTopicNameProvided){
            //     $('.subTopicNameInputBox').addClass('is-invalid');
            //     $('.sub')
            // }


            var fileInputs = $('input[type="file"]');
            var isValid = true;

            fileInputs.each(function() {
                if (!validateFileType($(this))) {
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) {

                return;
            }


            if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '' && $('#curriculumSelect').val() != '' && $('#topicNameInputBox').val() != '' && $('.subTopicNameInputBox').val() != '') {
                // $('input[type="hidden"][name="file[]"]').each(function() {
                //
                //     $(this).val('../');

                // var formData = new FormData();
                // var index = 0; // Initialize index for tracking array indices


                // var form = new FormData();
                // for (var i = 0; i < $('.fileInputBox').get(0).files.length; ++i) {
                //     form.append('userfiles[]', $(this).get(0).files[i]);
                // }

                // $('input[name=file[]').change(function() {

                //     $('input[name=userfiles]').change(function() {
                //     var names = [];
                //     for (var i = 0; i < $(this).get(0).files.length; ++i) {
                //         names.push($(this).get(0).files[i].name);
                //         console.log(names[i]);
                //     }
                //  });
                // });


                // $('input[name="source_type[]"]').each(function() {
                //     var sourceType = $(this).val();
                //     var urlValue = $('.urlInputBox').eq(index).val();
                //     var fileInput = $('.fileInputBox').eq(index)[0].files;
                //     // var fileInput = $('.fileInputBox').files;

                //     console.log('file input is ' + fileInput);
                //     console.log('url input is ' + urlValue);

                //     // var fileValue = fileInput.prop('files') ?? null;

                //     var subTopicName = $('.subTopicNameInputBox').eq(index).val();

                //     if (sourceType === 'url') {
                //         formData.append('url[]', urlValue);
                //         formData.append('file[]', null);
                //         formData.append('subTopicName[]', subTopicName);
                //     } else if (sourceType === 'file') {
                //         formData.append('file[]', fileInput);
                //         formData.append('url[]', null);
                //         formData.append('subTopicName[]', subTopicName);
                //     }

                //     index++; /
                // });

                var formData = new FormData();
                var index = 0;

                $('input[name="source_type[]"]').each(function() {
                    var source_type = $(this).val();
                    var urlValue = $('.urlInputBox').eq(index).files();
                    // var fileInput = $('.fileInputBox').eq(index).files;

                    var fileInput = $('.fileInputBox').eq(index).files;
                    if (fileInput.length > 0) {
                        for (var i = 0; i < fileInput.length; i++) {
                            var file = fileInput[i];
                            console.log("File name:", file.name);
                            console.log("File size:", file.size);

                        }
                    }



                    console.log('file input is ' + fileInput);

                    var source_title = $('.sourceTitleInputBox').eq(index).val();
                    formData.append('source_title[]',source_title);

                    formData.append('source_type[]',source_type);

                    console.log('file Input is ' + fileInput);

                    var subTopicName = $('.subTopicNameInputBox').eq(index).val();
                    formData.append('sub_topic_name[]', subTopicName);

                    if (fileInput && fileInput.length > 0) {

                        var reader = new FileReader();

                        reader.onload = function(event) {
                            var data = event.target.result;
                            var blob = new Blob([data], { type: fileInput[0].type });

                            formData.append('file[]', blob);
                            formData.append('url[]', null);
                        };

                        reader.readAsDataURL(fileInput[0]);
                    } else {
                        formData.append('url[]', urlValue);
                        formData.append('file[]', null);
                    }
                    index++;
                });


                formData.append('gradeSelect', $('#gradeSelect').val());
                formData.append('classSelect', $('#classSelect').val());
                formData.append('curriculumSelect', $('#curriculumSelect').val());
                formData.append('topic_name', $('#topicNameInputBox').val());




                // $(this).find('input,select').each(function(index, element) {
                //   var $element = $(element);
                //   var name = $element.attr('name');
                //   var value = $element.val();

                //   if (name == 'source_type[]' && value == 'url') {
                //
                //     formData.append('file[]', null);
                //   } else {
                //     formData.append(name, value);
                //   }
                // });

                // $(this).find('input').each(function(index, element) {
                //     var $element = $(element);
                //     var name = $element.attr('name');
                //     var value = $element.val();

                //     console.log('value is ' + value);

                //     console.log(formData);

                //
                //     if (name == 'source_type[]' && value == 'url[]') {
                //
                //         formData.append('file[]', null);

                //     }
                //     // else {
                //     //
                //     //     formData.append(name, value);
                //     // }
                // });


                // $(this).find('input[type="file"]').each(function(index, element) {
                //     var $element = $(element);
                //     var name = $element.attr('name');
                //     var file = $element[0].files[0];

                //     if (file) {
                //         formData.append(name, file);
                //     }
                // });

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        console.log('Form submitted successfully');
                        console.log(response);

                        if(response == 'success'){
                            window.location.href = '{{route('classworks.index')}}';
                        }
                    },
                    error: function(xhr, status, error) {

                        console.log(error);
                        console.error('Error submitting form:', error);
                    }
                });




                // var files = $('input[type="file"]');

                // files.each(function() {
                //     var fileInput = $(this)[0];
                //     var file = fileInput.files[0];

                //
                //     formData.push({ name: fileInput.name, value: file });
                // });
                // var formData = new FormData


                // formData.forEach(function(item, index) {
                //     if (item.name == 'source_type[]' && item.value == 'url') {
                //
                //         formData.splice(index + 1, 0, {name: 'file[]', value: null});
                //     }
                // });


                // $.ajax({
                //     url: $(this).attr('action'),
                //     method: $(this).attr('method'),
                //     // data: $.param(formData),
                //     data: formData,
                //     processData: false,
                //     contentType: false,
                //     success: function(response) {
                //

                //         alert('success');

                //         console.log('Form submitted successfully');
                //         console.log(response);
                //     },
                //     error: function(xhr, status, error) {
                //
                //         // For example, display error message
                //         console.error('Error submitting form:', error);
                //     }
                // });


            }
        });

        var inputFieldCount = 0;

        function toggleButtons() {
            if (inputFieldCount >= 5) {
                $("#addSourceBtn").prop("disabled", true);
            } else {
                $("#addSourceBtn").prop("disabled", false);
            }
        }

        toggleButtons();

        $('#cancelBtn').click(function(){
            restoreInitialForm();
        });


        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            $('#classSelect').empty();
            $('#selectBoxError1').text('');
            $('#curriculumSelect').empty();


            if (gradeId === '') {

                $('#classSelect').append($('<option>', {
                    value: '',
                    text : 'Select Class',
                }));

                $('#curriculumSelect').append($('<option>', {
                    value: '',
                    text : 'Select Curriculum',
                }));

            } else {

                var classesFound = false;
                var curriculumFound = false;
                @foreach ($grades as $grade)
                    if ('{{$grade->id}}' === gradeId) {
                        @foreach ($grade->classes as $class)
                            $('#classSelect').append($('<option>', {
                                value: '{{$class->id}}',
                                text : '{{$class->class_name}}'
                            }).attr('data-description', '{{$class->description}}'));
                            classesFound = true;
                        @endforeach

                        @foreach ($grade->curricula as $curriculum)
                            $('#curriculumSelect').append($('<option>', {
                                value: '{{$curriculum->id}}',
                                text : '{{$curriculum->curriculum_name}}'
                            }));
                            curriculumFound = true;
                        @endforeach
                    }
                @endforeach

                $('#selectBoxError2').text('');
                $('#selectBoxError3').text('');

                if (!classesFound) {
                    $('#classSelect').append($('<option>', {
                        value: '',
                        text : 'No Classes in this grade'
                    }));
                }

                if (!curriculumFound) {
                    $('#curriculumSelect').append($('<option>', {
                        value: '',
                        text : 'No Subject in this grade'
                    }));
                }
            }
        });

        $('#classSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError2').text('First, select a grade');

            } else {
                $('#selectBoxError2').text('');
            }
        });

        $('#curriculumSelect').click(function() {
            var selectedGrade = $('#gradeSelect').val();
            if (selectedGrade === '') {
                $('#selectBoxError3').text('First, select a grade');

            } else {
                $('#selectBoxError3').text('');
            }
        });

    }


    $('#cancelBtn').click(function(){
        restoreInitialForm();
    });


});

</script>

@endsection
