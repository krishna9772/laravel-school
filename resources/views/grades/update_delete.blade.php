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
                {{-- <h4>Update or Delete Grade</h4> --}}
                <h4>Update Grade</h4>
                <select name="" id="gradeSelect" class="form-control">
                    <option value="">Select Grade</option>
                    @foreach ($grades as $grade)
                        <option value="{{$grade->id}}" data-description="{{$grade->description}}">{{$grade->grade_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger mt-1" id="selectBoxError"></p>

                <div class="mt-4">
                    <button id="updateBtn" class="btn btn-primary mr-2">Update</button>
                    {{-- <button id="deleteBtn" class="btn btn-danger" >Delete</button> --}}

                    {{-- <div class="modal fade" id="deleteGradeModal">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class='modal-header'>
                                <p class='col-12 modal-title text-center'>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button><br><br>
                                  <span class=" text-dark" style="font-size: 18px">Are you sure to delete <br>
                                    <span class=" font-weight-bold text-dark" style="font-size: 19px" id="gradeNameInsideModal">  </span>
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
                    </div> --}}

                </div>
            </div>

            <form id="updateGradeForm" style="display: none;" >
                @csrf
                @method('PATCH')

                <h4>Update Grade</h4>

                <input type="hidden" id="idInputBox" name="id" value="">
                <div class="form-group">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" id="nameInputBox" class="form-control" placeholder="Name of Grade" readonly>
                    <p class="text-danger" id="nameErrorMessage"></p>
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Description</label>
                    <textarea name="description" id="descInputBox" class="form-control" placeholder="Enter Description">{{ old('description') }}</textarea>
                    <p class="text-danger" id="descErrorMessage"></p>
                </div>

                <div>
                    <button type="submit" class="btn btn-info mr-2">Save</button>
                    <button type="button" id="cancelBtn" class="btn btn-default">Cancel</button>
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
                $('#selectBoxError').text('');
            }

            $('#gradeSelect').change(function() {
                clearError();
            });

            $('#updateBtn').click(function() {

                if($('#gradeSelect').val() != ''){
                    var selectedGradeId = $('#gradeSelect').val();
                    var selectedGradeName = $('#gradeSelect option:selected').text();
                    var selectedGradeDescription = $('#gradeSelect option:selected').data('description');

                    $('#idInputBox').val(selectedGradeId);
                    $('#nameInputBox').val(selectedGradeName);
                    $('#descInputBox').val(selectedGradeDescription);


                    $('#selectSection').hide();
                    $('#updateGradeForm').show();
                }else{
                    $('#gradeSelect').addClass('is-invalid');
                    $('#selectBoxError').text('Please Select Grade To Update');
                }
            });

            $('#deleteBtn').click(function(){
                if($('#gradeSelect').val() != ''){

                    var selectedGradeId = $('#gradeSelect').val();

                    var selectedGradeName = $('#gradeSelect option:selected').text();

                    $('#deleteGradeModal').modal('show');

                    $('#gradeNameInsideModal').text(selectedGradeName + '?');

                    $('#deleteBtnInsideModal').click(function(){
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
                    });
                }else{
                    $('#gradeSelect').addClass('is-invalid');
                    $('#selectBoxError').text('Please Select Grade To Delete');
                }
            });

            $('#cancelBtn').click(function() {
                $('#selectSection').show();
                $('#updateGradeForm').hide();

                $('#nameErrorMessage').html('');
                $('#nameInputBox').removeClass('is-invalid');

            });

            $('#updateGradeForm').submit(function (e) {
                // alert('hello');
                e.preventDefault();

                var gradeId = $('#idInputBox').val();

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
                            $('#nameInputBox').addClass('is-invalid');
                        } else {
                            $('#nameErrorMessage').html('');
                            $('#nameInputBox').removeClass('is-invalid');
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
        });
    </script>
@endsection
