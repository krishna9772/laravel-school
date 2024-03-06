@extends('layouts.app')

@section('content')

    <div class="pt-5 d-flex justify-content-between mx-5">
        <h4 class="text-center" id="listTitle">All Registrations</h4>
        <div>
            <label for="">Filter:</label>
            <select id="filter" name="filter" class="form-select">
                <option value="all">All</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
        </div>
    </div>


    <div class="py-5 mx-5">

        <table id="usersTable" class="w-100 my-3 table table-striped" >
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
                @php $count = 1 @endphp
                @foreach ($users as $user)
                    <div class="userList">


                    <tr>
                        <td class="col-1">{{ $count++ }}</td>
                        <td>{{$user->user_id}}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{$user->user_type}}</td>
                        @if ($user->userGradeClasses->isNotEmpty())
                            <td>{{ $user->userGradeClasses[0]->grade->grade_name }}</td>
                            <td>{{ $user->userGradeClasses[0]->class->class_name }}</td>
                        @else
                            <td>No grade assigned</td>
                            <td>No class assigned</td>
                        @endif

                        <td>
                            <a href="{{route('users.edit',$user->user_id)}}" title="Edit" class="mr-3 text-decoration-none">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a onclick="deleteUser({{$user->id}})" title="Delete" class="mr-3 text-decoration-none" style="cursor: pointer">
                                <i class="fa fa-trash"></i>
                            </a>
                    </td>
                    </tr>
                </div>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@section('scripts')

<script>
    // $(document).ready(function(){
        $('#usersTable').DataTable();

        // $('[data-bs-toggle="tooltip"]').tooltip();

        $('#filter').change(function() {
            var filterType = $(this).val();

            if (filterType === 'student') {
                $('#listTitle').html('Students List');
            } else if (filterType === 'teacher') {
                $('#listTitle').html('Teachers List');
            } else {
                $('#listTitle').html('All Registrations');
            }

            $.ajax({
                type: 'get',
                url: '{{ route("users.filter", ["user_type" => ":user_type"]) }}'.replace(':user_type', filterType),
                dataType: 'json',
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
                                console.log(gradeName);
                                console.log(className);
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
                    if (response == 'success') {
                        $("#usersTable").load(window.location + " #usersTable");
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


    // });
</script>

@endsection
