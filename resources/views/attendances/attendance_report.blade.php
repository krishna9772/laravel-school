@extends('layouts.app')

@section('styles')
<style>
    /* .badge {
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
      } */
  </style>
@endsection

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

         <div class="d-flex justify-content-between mb-4">
             <h3>{{$gradeName}} / {{$className}} - Attendance Report </h3>

             <div>
                <select id="filter" name="filter" class="form-control">
                    {{-- <option value="all">All</option> --}}
                    <option value="monthly">Monthly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>

         </div>


         <div class="month-selector">
             <label><input type="radio" name="month" value="January"><span class="badge badge-primary">January</span></label>
             <label><input type="radio" name="month" value="February"><span class="badge badge-primary">February</span></label>
             <label><input type="radio" name="month" value="March"><span class="badge badge-primary">March</span></label>
             <label><input type="radio" name="month" value="April"><span class="badge badge-primary">April</span></label>
             <label><input type="radio" name="month" value="May"><span class="badge badge-primary">May</span></label>
             <label><input type="radio" name="month" value="June"><span class="badge badge-primary">June</span></label>
             <label><input type="radio" name="month" value="July"><span class="badge badge-primary">July</span></label>
             <label><input type="radio" name="month" value="August"><span class="badge badge-primary">August</span></label>
             <label><input type="radio" name="month" value="September"><span class="badge badge-primary">September</span></label>
             <label><input type="radio" name="month" value="October"><span class="badge badge-primary">October</span></label>
             <label><input type="radio" name="month" value="November"><span class="badge badge-primary">November</span></label>
             <label><input type="radio" name="month" value="December"><span class="badge badge-primary">December</span></label>
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
                            <th>Percentage</th>
                            <th>Details</th>
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
                                    Percentage
                                </td>
                                <td>
                                    <a href="">View Details</a>
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
                   $(this).find('input').val() === 'absent' ? 'badge-red' : 'badge-yellow';
          });
        });
      });

    function submitForm(card) {
        $(card).find('.classwork-form').submit();
    }
</script>
@endsection
