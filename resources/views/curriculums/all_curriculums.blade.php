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

      <h3 class="pt-3">Grades With Curricula</h3>

      <div class="row">

        @foreach ($data as $data)
        <div class="col-md-4 mt-3">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <div>
                   <h3 class="card-title">{{ $data['grade']->grade_name }}</h3>
                </div>
                <div class=" float-right ">
                   <a href="#" class="text-decoration-none">
                      <i class="fa fa-edit mr-3"></i>
                   </a>
                   <a href="" class="text-decoration-none">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                   </a>
                </div>
              </div>
              <!-- /.card-header -->

                <div class="card-body">

                    @foreach ($data['curriculums'] as $curriculum)
                    <div class="d-flex justify-content-between">
                        <span>{{$curriculum['curriculum']->curriculum_name }}</span>
                        <span>{{$curriculum['user']->user_name }}</span>
                    </div>
                    @endforeach

                </div>
            </div>
          </div>
        @endforeach
        <!-- left column -->

      </div>
    </div>
</section>

@endsection

@section('scripts')

<script>

</script>

@endsection
