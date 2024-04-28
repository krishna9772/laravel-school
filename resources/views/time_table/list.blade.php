@extends('layouts.app')


@section('content')

    @if (count($timetables) != 0)
        <div class="pt-5 d-flex justify-content-between mx-5">
            <h4 class="text-center" id="listTitle">Time Table</h4>
        </div>


        <div class="py-5 mx-5">

            <table id="timetableTable" class="w-100 my-3 table table-striped" >
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Grade Name</th>
                        <th class="text-center">Class Name</th>
                        <th class="text-center">Timetable File</th>
                        {{-- <th>Grade</th>
                        <th>Class</th>
                        <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1 @endphp
                    @foreach ($timetables as $timetable)
                        <div class="userList">
                        <tr>
                            <td class="text-center">{{$count}}</td>
                            <td class="text-center">{{$timetable->grade_name}}</td>
                            <td class="text-center">{{$timetable->class_name}}</td>
                            <td class="text-center">
                                <a href="{{asset('storage/timetable_files/'. $timetable->file)}}" download>
                                    <span class="badge badge-success"><i class="fas fa-file-download fa-2x"></i></span>
                                </a>
                            </td>
                        </tr>
                    </div>
                    @php $count++ @endphp
                    @endforeach
                </tbody>
            </table>

        </div>
    @else

    <div class="text-center pt-5" >
        <h4>
            No TimeTables Created Yet
        </h4>

        @can('manage timetable')
            <div class="mt-5">
                <a href="{{route('timetables.new') }}">
                    <button class="btn btn-primary"> <i class="fa fa-plus"></i> New Timetable</button>
                </a>
            </div>
        @endcan
    </div>

    @endif


@endsection

@section('scripts')

<script>

        $('#timetableTable').DataTable();

</script>

@endsection
