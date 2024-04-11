@extends('layouts.app')

@section('styles')
<style>
    .badge {
        cursor: pointer;
      }
      .badge-green {
        background-color: green !important;
      }
      .badge-red {
        background-color: red !important;
      }
      .badge-yellow {
        background-color: yellow !important;
      }
  </style>
@endsection

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

         <div class="d-flex justify-content-between mb-4">
             <h3>{{$gradeName}} / {{$className}} - Mark Attendance</h3>

             <input type="date" class=" form-control-sm" id="" value="{{$todayDate}}">

         </div>


         <div class="">

            <form action="{{route('attendances.store')}}" id="markAttendanceForm" method="post">
                @csrf
                <table id="studentsTable" class="w-100 my-3 table table-striped" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1 @endphp
                        @foreach ($students as $student)
                            <div class="userList">
                            <tr>
                                <td class="col-1">{{ $count++ }}</td>
                                <td>{{$student->user_id}}</td>
                                <td>{{ $student->user_name }}</td>
                                <td>{{$student->father_name}}</td>
                                <td>
                                    <input type="hidden" name="student_id[]" value="{{$student->user_id}}">
                                    <input type="hidden" name="user_grade_class_id[]" value="{{$student->userGradeClasses[0]->id}}">

                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-white mr-1 border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="present" autocomplete="off"> P
                                        </label>
                                        <label class="btn btn-white mr-1 border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="absent" autocomplete="off"> A
                                        </label>
                                        <label class="btn btn-white border border-secondary">
                                          <input type="radio" name="status[{{ $student->user_id }}]" value="leave" autocomplete="off"> L
                                        </label>
                                      </div>
                                </td>
                                <td>
                                    <input type="text" name="reason[]" class="form-control" id="">
                                </td>
                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>


            </form>


        </div>

</div>

@endsection

@section('scripts')
<script>

      $(document).ready(function() {

        $('#studentsTable').dataTable(
            // 'bInfo': false;
            // "dom": 'rtip'
        );


        $('.btn-group-toggle label').click(function() {
          $(this).parent().find('.btn').removeClass('badge-green badge-red badge-yellow border-1');
          $(this).addClass(function() {
            return $(this).find('input').val() === 'present' ? 'badge-green' :
                   $(this).find('input').val() === 'absent' ? 'badge-yellow' : 'badge-red';
          });
        });
      });

    function submitForm(card) {
        $(card).find('.classwork-form').submit();
    }
</script>
@endsection
