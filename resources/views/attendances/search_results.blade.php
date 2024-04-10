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

         <h3>{{$gradeName}} / {{$className}} - Mark Attendance</h3>

         <div class="">

            <form action="" id="markAttendance Form">
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
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-white mr-1 border border-secondary">
                                          <input type="radio" name="status" value="P" autocomplete="off"> P
                                        </label>
                                        <label class="btn btn-white mr-1 border border-secondary">
                                          <input type="radio" name="status" value="A" autocomplete="off"> A
                                        </label>
                                        <label class="btn btn-white border border-secondary">
                                          <input type="radio" name="status" value="L" autocomplete="off"> L
                                        </label>
                                      </div>
                                </td>
                                <td>
                                    <input type="text" name="reason" class="form-control" id="">
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
            return $(this).find('input').val() === 'P' ? 'badge-green' :
                   $(this).find('input').val() === 'A' ? 'badge-red' : 'badge-yellow';
          });
        });
      });

    function submitForm(card) {
        $(card).find('.classwork-form').submit();
    }
</script>
@endsection
