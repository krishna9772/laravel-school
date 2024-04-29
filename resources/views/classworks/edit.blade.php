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

       .deleteBtn.disabled {
            opacity: 0.7;
            pointer-events: none;
            cursor: not-allowed;
        }

        .deleteBtn.disabled:hover {
            cursor: not-allowed;
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

                <input type="hidden" name="gradeSelect" value="{{$gradeId}}">
                <input type="hidden" name="classSelect" value="{{$classId}}">
                <input type="hidden" name="curriculumSelect" value="{{$curriculumId}}">

              <div class="card-body">

                <div class="form-group">
                    <label for="" class="form-label required">Main Topic Name</label>
                    <input type="text" name="topic_name" id="topicNameInputBox" value="{{$classworks[0]->topic_name}}" class="form-control" placeholder="Enter Main Topic Name">
                    <p class="text-danger" id="topicNameError"></p>
                </div>

                <div id="dynamicRows">


                    @foreach ($classworks as $classwork)

                    <div class="newAddedRows">

                        <input type="hidden" name="classwork_id[]" value="{{$classwork->id}}">

                        <div class="row">
                            <div class="form-group col-11">
                                <label for="" class="required">Sub Topic Name</label>
                                <input type="text" name="sub_topic_name[]" id="" value="{{$classwork->sub_topic_name}}" class="form-control">
                            </div>
                            <div class="col-1 pl-0" style="margin-top: 30px">
                                <div class=" mt-2 pr-2  deleteBtn" data-classwork-id="{{$classwork->id}}">
                                    <button type="button" class="btn-danger" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-6">
                                <label for="" class="required">Source Title</label>
                                <input type="text" name="source_title[]" id="" value="{{$classwork->source_title}}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                @if ($classwork->url != null)
                                    <input type="hidden" name="file[]" value="">
                                    <input type="hidden" name="source_type[]" value="url">
                                    <label for="" class="required">URL</label>
                                    <input type="text" name="url[]" id="" class="form-control" value="{{$classwork->url}}">
                                @endif

                                <div style="position: relative;">
                                    @if($classwork->file != null )

                                    <input type="hidden" name="url[]" value="">
                                    <input type="hidden" name="source_type[]" value="file">

                                    <label for="exampleInputFile" class="required">File</label>
                                    <div class="input-group">
                                      <div class="custom-file">

                                        <input type="hidden" name="old_file[]" id="" value="{{asset('storage/classwork_files/' . $classwork->file)}}">

                                        <input type="file" class="custom-file-input" name="file[]" id="exampleInputFile" value="{{asset('storage/classwork_files/' . $classwork->file)}}">
                                        <label class="custom-file-label" for="exampleInputFile">{{$classwork->file}}</label>
                                      </div>
                                    </div>
                                        {{--
                                        <input type="hidden" name="url[]" value="">
                                        <input type="hidden" name="source_type[]" value="file"> --}}
                                        {{-- <span>{{$classwork->file}}</span> --}}
                                        {{-- <label for="">File</label>
                                        <input type="file" class="form-control" name="file[]" id="fileInput">
                                        <p>{{$classwork->file}}</p> --}}

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

                    {{-- <button type="button" id="removeBtn" class="btn btn-danger"> <i class="fa fa-minus"></i> Remove</button> --}}
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


        $.ajax({
            type: 'POST',
            url: '{{ route('classworks.updateData')}}',
            data: $('#updateClassworkForm').serialize(),
            success: function(response) {
                console.log('form restores initial state');
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                var response = JSON.parse(xhr.responseText);
                    console.log(response);
            }
        });

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


        $('#dynamicRows').on('click', '.deleteBtn', function () {
            var classworkId = $(this).data('classwork-id');
            var row = $(this).closest('.newAddedRows');
            row.remove();



            // if(inputFieldCount > 1){
                // $("#dynamicRows .newAddedRows:last-child").remove();
            // }

            --inputFieldCount;
            toggleButtons();

            console.log('input field count' + inputFieldCount);

            console.log('classwork id is ' + classworkId);

            $.ajax({
                type: 'DELETE',
                url: '{{route('classworks.destroy',['classwork' => ':classwork']) }}'.replace(':classwork', classworkId),
                success: function (response) {
                    if(response == 'success'){
                        console.log('deleted successfully');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var response = JSON.parse(xhr.responseText);
                        console.log(response);
                }
            });
        });


        $('#urlBtn').click(function(){

            if (inputFieldCount < 5) {
                $.ajax({
                    url: "{{ route('classworks.getMaxId') }}",
                    method: 'GET',
                    success: function(response) {
                        var maxId = parseInt(response) + 2;
                        addNewUrlRow(maxId);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch maximum ID:', error);
                    }
                });
            }

        });

        $('#fileBtn').click(function(){
            if (inputFieldCount < 5) {
                $.ajax({
                    url: "{{ route('classworks.getMaxId') }}",
                    method: 'GET',
                    success: function(response) {
                        var maxId = parseInt(response) + 1;
                        addNewFileRow(maxId);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch maximum ID:', error);
                        // Handle error
                    }
                });
            }
        })


        function addNewUrlRow(classworkId){
            $('#newClassworkModal').modal('hide');




                var newUrlRow = `
                                    <div class="newAddedRows">
                                        <input type="hidden" name="source_type[]" value="url">
                                            <input type="hidden" name="classwork_id[]" value="${classworkId}">
                                            <input type="hidden" name="file[]" value="">
                                            <div class="row">
                                                <div class="form-group col-11">
                                                    <label for="" class="required">Sub Topic Name</label>
                                                    <input type="text" name="sub_topic_name[]" id="" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                                                    <p class="text-danger subTopicNameError"></p>
                                                    </div>
                                                <div class="col-1 pl-0" style="margin-top: 30px">
                                                    <div class=" mt-2 pr-2  deleteBtn" data-classwork-id="{{$classwork->id}}">
                                                        <button type="button" class="btn-danger" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
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

                $('#dynamicRows').append(newUrlRow);

                inputFieldCount++;
                toggleButtons();

            }

        function addNewFileRow(classworkId){
                $('#newClassworkModal').modal('hide');

                // Check if labels have been added

                    // Add labels for the first time



                    var newFileRow = `<div class="newAddedRows">
                                            <input type="hidden" name="source_type[]" value="file">
                                            <input type="hidden" name="classwork_id[]" value="${classworkId}">
                                            <input type="hidden" name="url[]" value="">
                                            <div class="row">
                                                <div class="form-group col-11 required">
                                                    <label for="">Sub Topic Name</label>
                                                    <input type="text" name="sub_topic_name[]" id="" class="form-control subTopicNameInputBox" placeholder="Enter Sub Topic Name">
                                                    <p class=" text-danger subTopicNameError"></p>
                                                    </div>
                                                <div class="col-1 pl-0" style="margin-top: 30px">
                                                    <div class=" mt-2 pr-2  deleteBtn" data-classwork-id="{{$classwork->id}}">
                                                        <button type="button" class="btn-danger" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <input type="text" name="source_title[]" class="form-control sourceTitleInpuBox" placeholder="Enter Source Title">
                                                    <p class="text-danger  sourceTitleError"></p>
                                                </div>
                                                <div class="form-group col-6">
                                                    <div class="custom-file">
                                                        <input type="file" name="file[]" class="custom-file-input fileInputBox" id="customFile">
                                                        <label for="customFile" class="custom-file-label">No file chosen</label>
                                                    </div>
                                                    <p class="text-danger fileError"></p>
                                                </div>
                                            </div>
                                            </div>`;


                    $('#dynamicRows').append(newFileRow);

                    $('.custom-file-input').change(function() {
                        var filename = $(this).val().split('\\').pop(); // Get filename from path
                        $(this).next('.custom-file-label').html(filename);
                    });

                inputFieldCount++;
                toggleButtons();
        }


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


            console.log($(this).serialize());

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

            sourceTitles.each(function() {
                if ($(this).val() == ''){
                    $(this).addClass('is-invalid');
                    $(this).next('.sourceTitleError').html('Source Title field is required');
                }
            })

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



            if ( $('#topicNameInputBox').val() != '' && $('.subTopicNameInputBox').val() != '' && $('.urlInputBox').val() != '' && $('.fileInputBox').val() != '') {

                this.submit();
            }
        });

        // var inputFieldCount = 0;

        function toggleButtons() {

            inputFieldCount = $("input[name='sub_topic_name[]']").length;
            console.log('input field count is ' + inputFieldCount);

            if (inputFieldCount >= 5) {
                $("#addSourceBtn").prop("disabled", true);
            } else {
                $("#addSourceBtn").prop("disabled", false);
            }

            if(inputFieldCount == 1){
                $('.deleteBtn').prop("disabled", true);
                $('.deleteBtn').addClass('disabled');
            }else{
                $('.deleteBtn').removeClass('disabled');
                $('.deleteBtn').prop("disabled", false);
            }

        }

        toggleButtons();

        $('#cancelBtn').click(function(){
            restoreInitialForm();
        });

    }


    $('#cancelBtn').click(function(){
        restoreInitialForm();
    });


});


// admin lte form
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self).bsCustomFileInput=t()}(this,function(){"use strict";var s={CUSTOMFILE:'.custom-file input[type="file"]',CUSTOMFILELABEL:".custom-file-label",FORM:"form",INPUT:"input"},l=function(e){if(0<e.childNodes.length)for(var t=[].slice.call(e.childNodes),n=0;n<t.length;n++){var l=t[n];if(3!==l.nodeType)return l}return e},u=function(e){var t=e.bsCustomFileInput.defaultText,n=e.parentNode.querySelector(s.CUSTOMFILELABEL);n&&(l(n).textContent=t)},n=!!window.File,r=function(e){if(e.hasAttribute("multiple")&&n)return[].slice.call(e.files).map(function(e){return e.name}).join(", ");if(-1===e.value.indexOf("fakepath"))return e.value;var t=e.value.split("\\");return t[t.length-1]};function d(){var e=this.parentNode.querySelector(s.CUSTOMFILELABEL);if(e){var t=l(e),n=r(this);n.length?t.textContent=n:u(this)}}function v(){for(var e=[].slice.call(this.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),t=0,n=e.length;t<n;t++)u(e[t])}var p="bsCustomFileInput",m="reset",h="change";return{init:function(e,t){void 0===e&&(e=s.CUSTOMFILE),void 0===t&&(t=s.FORM);for(var n,l,r=[].slice.call(document.querySelectorAll(e)),i=[].slice.call(document.querySelectorAll(t)),o=0,u=r.length;o<u;o++){var c=r[o];Object.defineProperty(c,p,{value:{defaultText:(n=void 0,n="",(l=c.parentNode.querySelector(s.CUSTOMFILELABEL))&&(n=l.textContent),n)},writable:!0}),d.call(c),c.addEventListener(h,d)}for(var f=0,a=i.length;f<a;f++)i[f].addEventListener(m,v),Object.defineProperty(i[f],p,{value:!0,writable:!0})},destroy:function(){for(var e=[].slice.call(document.querySelectorAll(s.FORM)).filter(function(e){return!!e.bsCustomFileInput}),t=[].slice.call(document.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),n=0,l=t.length;n<l;n++){var r=t[n];u(r),r[p]=void 0,r.removeEventListener(h,d)}for(var i=0,o=e.length;i<o;i++)e[i].removeEventListener(m,v),e[i][p]=void 0}}});

$(function () {
      bsCustomFileInput.init();
    });

</script>


@endsection
