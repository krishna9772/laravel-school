
@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-5">

                <div id="selectSection">
                    <h4>Update or Delete User</h4>

                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input id="searchInput" type="search" class="form-control form-control-lg" placeholder="Search User ID Or Name" >
                            <div class="input-group-append">
                                <button type="button" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div>
        <div class="mx-5">
            <table id="usersTable" class="table table-striped d-none" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Grade</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script>

            $('#usersTable').DataTable({
                "paging": false,
                "searching": false,
                "info" : '',
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#searchInput').on('input', function() {

                var query = $(this).val().trim();

                if (query !== '') {
                    $('#usersTable').removeClass('d-none');
                } else {
                    $('#usersTable').addClass('d-none');
                }

                // Send AJAX request to search for users
                $.ajax({
                    url: "{{route('users.search')}}",
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        console.log(response);

                        var dataTable = $('#usersTable').DataTable();
                        dataTable.rows().remove().draw();

                        for (var i = 0; i < response.length; i++) {
                                var user = response[i];
                                var gradeName = '';
                                var className = '';

                                // Check if user_grade_classes exists and is not empty before accessing it
                                if (user.user_grade_classes && user.user_grade_classes.length > 0) {
                                    gradeName = user.user_grade_classes[0].grade ? user.user_grade_classes[0].grade.grade_name : 'No grade assigned';
                                    className = user.user_grade_classes[0].class ? user.user_grade_classes[0].class.class_name : 'No class assigned';
                                } else {
                                    gradeName = 'No grade assigned';
                                    className = 'No class assigned';
                                }

                                var showUrl = "{{ route('users.show', ':userId') }}".replace(':userId', user.user_id);
                                var editUrl = "{{ route('users.edit', ':userId') }}".replace(':userId', user.user_id);

                                dataTable.row.add([
                                    i + 1,
                                    user.user_id,
                                    user.user_name,
                                    user.user_type,
                                    gradeName,
                                    className,
                                    '<a href="' + editUrl + '" title="Edit" class="mr-3 text-decoration-none"><i class="fa fa-edit"></i></a>' +
                                    '<a onclick="deleteUser(' + user.id + ')" title="Delete" class="mr-3 text-decoration-none" style="cursor: pointer"><i class="fa fa-trash"></i></a>'
                            ]).draw();
                        }


                    }
                    // error: function(xhr, status, error) {
                    //     console.error(error);
                    // }
                });
            });

            function deleteUser(id) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("users.destroy", ["user" => ":user"]) }}'.replace(':user', id),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response == 'success'){
                            window.location.href = '{{ route('users.modify') }}';
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
            }

    </script>
@endsection
