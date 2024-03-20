@extends('layouts.app')

@section('styles')
<style>
    .required:after {
      content:" *";
      color: rgba(255, 0, 0, 0.765);
    }


    .upload-icon {
        cursor: pointer;
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background-size: cover;
      }


      .file-input-container {
        position: relative;
        width: 200px;
      }

      .file-input {
        width: 100%;
        padding-right: 25px;
        box-sizing: border-box;
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
              <h3 class="card-title">Edit Classwork</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="updateClassworkForm" method="POST" action="{{route('classworks.updateData')}}" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name=""> --}}
                {{-- <input type="hidden" name="grade_id" value="{{$classwork[0]}}" > --}}

              <div class="card-body">

                <div class="form-group">
                    <label for="" class="form-label required">Select Grade</label>
                    <select name="gradeSelect" id="gradeSelect" class="form-control">
                        <option value="">Select Grade</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}" @if($classworks[0]->grade_id == $grade->id) selected @endif >{{$grade->grade_name}}</option>
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
                    <label for="" class="form-label">Select Class</label>
                    <select name="classSelect" id="classSelect" class="form-control">
                        <option value="">Select Class</option>
                    </select>
                    <p class="text-danger mt-1" id="classSelectError"></p>
                </div>

                <div class="form-group">
                    <label for="" class="form-label">Select Curriculum</label>
                    <select name="curriculumSelect" id="curriculumSelect" class="form-control">
                        <option value="">Select Curriculum</option>
                    </select>
                    <p class="text-danger mt-1" id="curriculumSelectError"></p>
                </div>

                <div class="form-group">
                    <label for="" class="form-label required">Main Topic Name</label>
                    <input type="text" name="topic_name" id="topicNameInputBox" value="{{$classworks[0]->topic_name}}" class="form-control" placeholder="Enter Main Topic Name">
                    <p class="text-danger" id="topicNameError"></p>
                </div>

                <div id="dynamicRows">


                    @foreach ($classworks as $classwork)

                    <div class="newAddedRows">

                        <input type="hidden" name="classwork_id[]" value="{{$classwork->id}}">

                        <div class="form-group">
                            <label for="">Sub Topic Name</label>
                            <input type="text" name="sub_topic_name[]" id="" value="{{$classwork->sub_topic_name}}" class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">Source Title</label>
                                <input type="text" name="source_title[]" id="" value="{{$classwork->source_title}}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                @if ($classwork->url != null)
                                    <input type="hidden" name="file[]" value="">
                                    <input type="hidden" name="source_type[]" value="url">
                                    <label for="">URL</label>
                                    <input type="text" name="url[]" id="" class="form-control" value="{{$classwork->url}}">
                                @endif

                                <div style="position: relative;">
                                    @if($classwork->file != null)
                                        <input type="hidden" name="url[]" value="">
                                        <input type="hidden" name="source_type[]" value="file">
                                        {{-- <span>{{$classwork->file}}</span> --}}
                                        <label for="">File</label>
                                        <input type="file" class="form-control" name="file[]" id="fileInput">
                                        <p>{{$classwork->file}}</p>

                                    @endif

                                </div>


                            </div>

                            {{-- input text or file  --}}
                        </div>

                    </div>

                    @endforeach
                </div>

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


          {{-- error modal  --}}
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



document.addEventListener("DOMContentLoaded", function() {

  const fileInput = document.getElementById('fileInput');
  const fileNameInput = document.getElementById('fileName');
  const uploadIcon = document.getElementById('uploadIcon');


  uploadIcon.addEventListener('click', function() {

    fileInput.click();
  });


  fileInput.addEventListener('change', function() {

    fileNameInput.value = fileInput.files[0].name;
  });
});

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var initialFormHTML = $('#updateClassworkForm').html();

    function restoreInitialForm() {
        $('#updateClassworkForm').html(initialFormHTML);
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

            if (inputFieldCount < 5) {
                $.ajax({
                    url: "{{ route('classworks.getMaxId') }}",
                    method: 'GET',
                    success: function(response) {
                        var maxId = parseInt(response) + 1;
                        addNewUrlRow(maxId);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch maximum ID:', error);
                        // Handle error
                    }
                });
            }

        });

        $('#dynamicRows').on('click', '#uploadIcon', function() {
            const fileInput = $(this).closest('.file-input-container').find('input[type="file"]');
            fileInput.click(); // Trigger click on file input
          });


          $('#dynamicRows').on('change', 'input[type="file"]', function() {
            console.log('hleo');
            const fileNameInput = $(this).closest('.file-input-container').find('.file-input');
            // Use either technique to update filename display (explained earlier)
            fileNameInput.textContent = this.files[0].name;
            // Or
            const tempElement = document.createElement('span');
            tempElement.textContent = this.files[0].name;
            fileNameInput.textContent = tempElement.textContent;
          });


        function addNewUrlRow(classworkId){
            $('#newClassworkModal').modal('hide');

            // Check if labels have been added
            if (!labelsAdded) {

                var newRowWithLabels = `
                                    <div class="newAddedRows">
                                        <input type="hidden" name="source_type[]" value="url">
                                            <input type="hidden" name="classwork_id[]" value="${classworkId}"
                                            <input type="hidden" name="file[]" value="">
                                            <div class="form-group">

                                                <input type="text" name="sub_topic_name[]" id="" class="form-control" placeholder="Enter Sub Topic Name">
                                            </div>
                                            <div class="row">
                                            <div class="form-group col-6">

                                                <input type="text" name="source_title[]" class="form-control" placeholder="Enter Source Title">
                                                <p class="text-danger curriculum-name-error"></p>
                                            </div>
                                            <div class="form-group col-6">

                                                <input type="text" name="url[]" class="form-control" placeholder="Enter URL">
                                            </div>
                                        </div>
                                        </div>`;

                $('#dynamicRows').append(newRowWithLabels);

                // Set labelsAdded to true
                labelsAdded = true;
            } else {
                // Add input fields without labels
                var newRowWithoutLabels = `<div class="newAddedRows">
                <input type="hidden" name="source_type[]" value="url">
                        <input type="hidden" name="classwork_id[]" value="${classworkId}"
                        <input type="hidden" name="file[]" value="">
                        <div class="form-group">
                            <input type="text" name="sub_topic_name[]" id="" class="form-control" placeholder="Enter Sub Topic Name">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="text" name="source_title[]" class="form-control" placeholder="Enter Source Title">
                                <p class="text-danger curriculum-name-error"></p>
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="url[]" class="form-control" placeholder="Enter URL">
                            </div>
                        </div>
                        </div>`;

                $('#dynamicRows').append(newRowWithoutLabels);
            }

            inputFieldCount++;
            toggleButtons();


        }


        // var labelAdded = false;

        $('#fileBtn').click(function(){
            $('#newClassworkModal').modal('hide');

            // Check if labels have been added
            if (!labelsAdded) {
                // Add labels for the first time
                var newRowWithLabels = `<div class="newAddedRows">
                                        <input type="hidden" name="source_type[]" value="file">
                                        <input type="hidden" name="url[]" value="">
                                        <div class="form-group">
                                            <input type="text" name="sub_topic_name[]" id="" class="form-control" placeholder="Enter Sub Topic Name">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <input type="text" name="source_title[]" class="form-control" placeholder="Enter Source Title">
                                                <p class="text-danger curriculum-name-error"></p>
                                            </div>
                                            <div class="form-group col-6">
                                                <input type="file" name="file[]" class="form-control">
                                            </div>
                                        </div>
                                        </div>`;

                labelsAdded = true;
            }else{
                var newRowWithoutLabels = `
                <div class="newAddedRows">
                    <input type="hidden" name="source_type[]" value="file">
                    <input type="hidden" name="url[]" value="">
                    <div class="form-group">
                        <input type="text" name="sub_topic_name[]" id="" class="form-control" placeholder="Enter Sub Topic Name">
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <input type="text" name="source_title[]" class="form-control" placeholder="Enter Source Title">
                            <p class="text-danger curriculum-name-error"></p>
                        </div>
                        <div class="form-group col-6">
                            <input type="file" name="file[]" class="form-control" placeholder="Browse File">
                        </div>
                    </div>
                </div>`;

                $('#dynamicRows').append(newRowWithoutLabels);
            }


            inputFieldCount++;
            toggleButtons();
        });

        $('#removeBtn').click(function(){
            inputFieldCount = $("input[name='source_title[]']").length;
            console.log(inputFieldCount);

            if(inputFieldCount > 1){
                $("#dynamicRows .newAddedRows:last-child").remove();
            }
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


        $('#gradeSelect').change(function () {
            validateField($('#gradeSelect'), $('#gradeSelectError'), 'Grade select field is required');
        });

        $('#classSelect').change(function () {
            validateField($('#classSelect'), $('#classSelectError'), 'Class select field is required');
        });

        $('#curriculumSelect').change(function () {
            validateField($('#curriculumSelect'), $('#curriculumSelectError'), 'Curriculum select field is required');
        });

        $('#topicNameInputBox').on('input', function () {
            validateField($('#topicNameInputBox'), $('#topicNameError'), 'Topic Name field is required');
        });

        function validateFileType(fileInput) {
            var fileName = fileInput.val();

            if(fileName == ''){
                return true;
            }

            var validExtensions = ['doc', 'docx', 'pdf'];
            var fileExtension = fileName.split('.').pop().toLowerCase();

            // Check if file extension is valid
            if ($.inArray(fileExtension, validExtensions) == -1) {
                // Show error message
                $('#errorMessage').text('Please select a valid file format (doc, docx, or pdf).');
                $('#errorModal').modal('show');

                fileInput.val('');

                return false;
            }

            return true;
        }

        $('#updateClassworkForm').submit(function (e) {
            e.preventDefault();


            validateField($('#gradeSelect'), $('#gradeSelectError'), 'Grade select field is required');
            validateField($('#classSelect'), $('#classSelectError'), 'Class select field is required');
            validateField($('#curriculumSelect'), $('#curriculumSelectError'), 'Curriculum select field is required');
            validateField($('#topicNameInputBox'), $('#topicNameError'), 'Topic Name field is required');

            var sourceTitles = $("input[name='source_title[]']");
            var sourceTitleProvided = false;

            sourceTitles.each(function() {
                if ($(this).val() !== '') {
                    sourceTitleProvided = true;
                    return false;
                }
            });

            if (!sourceTitleProvided) {

                $('#errorMessage').text('Please add at least one source.');
                $('#errorModal').modal('show');
                return;
            }

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



            if ($('#gradeSelect').val() != '' && $('#classSelect').val() != '' && $('#curriculumSelect').val() != '' && $('#topicNameInputBox').val() != '') {

                this.submit();
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


        var initialGradeId = $('#gradeSelect').val();
        var initialClassId = "{{ $classworks[0]->class_id }}";
        var initialCurriculumId = "{{ $classworks[0]->curriculum_id }}";
        // console.log('initial class id is ' + initialClassId);
        updateClassOptions(initialGradeId, initialClassId,initialCurriculumId);

        $('#gradeSelect').change(function() {
            var gradeId = $(this).val();
            updateClassOptions(gradeId, '','');
        });

        function updateClassOptions(gradeId, selectedClassId,selectedCurriculumId) {
            $('#classSelect').empty();
            $('#curriculumSelect').empty();

            if (gradeId === '') {
                $('#classSelect').append($('<option>', {
                    value: '',
                    text: 'Select Class',
                }));

                $('#curriculumSelect').append($('<option>', {
                    value: '',
                    text: 'Select Curriculum',
                }));
                return;
            }

            @foreach ($grades as $grade)
            if ('{{$grade->id}}' === gradeId) {
                @foreach ($grade->classes as $class)
                    // console.log({{$class->id}});

                var selected = selectedClassId == '{{$class->id}}';
                console.log(selectedClassId);
                $('#classSelect').append($('<option>', {
                    value: '{{$class->id}}',
                    text: '{{$class->class_name}}',
                    selected: selected
                }));
                @endforeach
            }
            @endforeach

            if ($('#classSelect option').length === 0) {
                $('#classSelect').append($('<option>', {
                    value: '',
                    text: 'No Classes in this grade'
                }));
            }

            @foreach ($grades as $grade)
            if ('{{$grade->id}}' === gradeId) {
                @foreach ($grade->curricula as $curriculum)
                    // console.log({{$class->id}});

                var selected = selectedCurriculumId == '{{$curriculum->id}}';
                console.log(selectedCurriculumId);
                $('#curriculumSelect').append($('<option>', {
                    value: '{{$curriculum->id}}',
                    text: '{{$curriculum->curriculum_name}}',
                    selected: selected
                }));
                @endforeach
            }
            @endforeach

            if ($('#curriculumSelect option').length === 0) {
                $('#curriculumSelect').append($('<option>', {
                    value: '',
                    text: 'No Curricula in this grade'
                }));
            }
        }


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
