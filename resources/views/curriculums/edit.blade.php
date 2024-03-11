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
                <h3 class="card-title">Edit {{$gradeName}} Curricula</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="updateCurriculumForm">

                    <input type="hidden" name="grade_id" id="gradeIdInputBox" value="{{$gradeId}}">

                <div class="card-body">

                    <div id="dynamicRows">

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="" class="form-label required">Curriculum Name</label>
                            </div>
                            <div class="form-group col-6">
                                <label for="" class="form-label required">Select Teacher</label>
                            </div>
                        </div>

                        @foreach ($curriculums as $curriculum)

                            <div class="row">
                                <input type="hidden" name="curriculum_id[]" value="{{$curriculum->id}}" data-curriculum-id="{{$curriculum->id}}">
                                <div class="form-group col-5">
                                    <input type="text" name="curriculum_name[]" value="{{$curriculum->curriculum_name}}" class="form-control" placeholder="Enter Curriculum Name">
                                    <p class="text-danger curriculum-name-error"></p>
                                </div>
                                <div class="form-group col-5">
                                    <select name="teacher_id[]" class="form-control">
                                        <option value="">Select Teacher</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->user_id}}" @if($teacher->user_id == $curriculum->user_id) selected @endif>{{$teacher->user_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger mt-1 teacher-id-error"></p>
                                </div>
                                <div class="col-2 mt-2 pr-2 deleteBtn" data-curriculum-id="{{$curriculum->id}}">
                                    <button type="button" class="btn-danger" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button type="button" id="addMoreBtn" class="btn btn-success"><i class="fa fa-plus"></i> Add More</button>
                        {{-- <button type="button" id="removeBtn" class="btn btn-danger"> <i class="fa fa-minus"></i> Remove</button> --}}
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-info mr-2">Save</button>
                        <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
                    </div>
                </div>
                </form>
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

        var initialFormHTML = $('#updateCurriculumForm').html();

        // Restores the saved initial HTML content of the form
        function restoreInitialForm() {
            $('#updateCurriculumForm').html(initialFormHTML);
            inputFieldCount = $("input[name='curriculum_name[]']").length;

            $.ajax({
                type: 'POST',
                url: '{{ route('curricula.updateData')}}',
                data: $('#updateCurriculumForm').serialize(),
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
                var curriculumId = $(this).data('curriculum-id');
                var row = $(this).closest('.row');
                row.remove();

                --inputFieldCount;
                toggleButtons();

                console.log('input field count' + inputFieldCount);

                console.log('curriculum id is ' + curriculumId);

                $.ajax({
                    type: 'DELETE',
                    url: '{{route('curricula.destroy',['curriculum' => ':curriculum']) }}'.replace(':curriculum', curriculumId),
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

            $('#updateCurriculumForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('curricula.updateData')}}',
                    data: $(this).serialize(),
                    success: function(response) {

                        if (response == 'success') {
                            window.location.href = '{{ route('curricula.index') }}';
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON;
                        console.log(response);


                        $('.curriculum-name-error').text('');
                        $('.teacher-id-error').text('');
                        $('.form-control').removeClass('is-invalid');

                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                var errorMessage = value[0];


                                var [fieldName, index] = key.split('.');


                                var $row = $('[name="' + fieldName + '[]"]').eq(index).closest('.row');


                                if (fieldName === 'curriculum_name') {
                                    $row.find('.curriculum-name-error').text('Curriculum name is required');
                                    $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                                } else if (fieldName === 'teacher_id') {
                                    $row.find('.teacher-id-error').text('Teacher field is required');
                                    $row.find('[name="' + fieldName + '[]"]').addClass('is-invalid');
                                }
                            });
                        }
                    },
                });
            });


            var inputFieldCount = $("input[name='curriculum_name[]']").length;
            console.log('input field count' + inputFieldCount);

            function toggleButtons() {
                if (inputFieldCount >= 5) {
                    $("#addMoreBtn").prop("disabled", true);
                } else {
                    $("#addMoreBtn").prop("disabled", false);
                }
            }

            function checkInputFieldCount() {
                var curriculumNames = $("input[name='curriculum_name[]']").length;
                var teacherIds = $("select[name='teacher_id[]']").length;
                if (curriculumNames >= 5 && teacherIds >= 5) {
                    $("#addMoreBtn").prop("disabled", true);
                } else {
                    toggleButtons();
                }
            }

            $("#addMoreBtn").click(function() {

                console.log('input field count' + inputFieldCount);

                if (inputFieldCount < 5) {
                    $.ajax({
                        url: "{{ route('curricula.getMaxId') }}",
                        method: 'GET',
                        success: function(response) {
                            var maxId = parseInt(response) + 1;
                            addNewRow(maxId);
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to fetch maximum ID:', error);
                            // Handle error
                        }
                    });
                }
            });

            function addNewRow(curriculumId) {
                $("#dynamicRows").append(`
                    <div class="row">
                        <input type="hidden" name="curriculum_id[]" value="${curriculumId}">
                        <div class="form-group col-5">
                            <input type="text" name="curriculum_name[]" class="form-control" placeholder="Enter Curriculum Name">
                            <p class="text-danger curriculum-name-error"></p>
                        </div>
                        <div class="form-group col-5">
                            <select name="teacher_id[]" class="form-control">
                                <option value="">Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->user_id}}">{{$teacher->user_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger mt-1 teacher-id-error"></p>
                        </div>
                        <div class="col-2 mt-2 pr-2 deleteBtn" data-curriculum-id="${curriculumId}">
                            <button type="button" class="btn-danger" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </div>
                `);
                inputFieldCount++;
                toggleButtons();
                checkInputFieldCount();
            }

            $("#removeBtn").click(function () {
                if (inputFieldCount > 1) {
                    $("#dynamicRows .row:last-child").remove();
                    inputFieldCount--;
                    toggleButtons();
                }
            });

            toggleButtons();

            console.log(inputFieldCount);

            $('#cancelBtn').click(function () {
                restoreInitialForm();
            });
        }


        $('#cancelBtn').click(function () {
            restoreInitialForm();
        });
    });

    </script>

    @endsection
