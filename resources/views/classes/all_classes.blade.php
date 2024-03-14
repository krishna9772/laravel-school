@extends('layouts.app')

@section('styles')
<style>
    .accordion .card {
      margin-bottom: 0;
    }

    .accordion .card:focus{
        border: none
    }

    .accordion .card.show .card-header {
    }

    .accordion .card.show .card-header:focus {
        outline:0 !important;
    }


    .accordion .card-header .btn::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        float: right;
        transition: all 0.4s ease;
      }

      /* .accordion .card-header .btn {
        transform: rotate(0deg);
        }

      .accordion .card-header .btn:focus::after {
        transform: rotate(-180deg);
      } */

      /* .rotated {
      transform: rotate(-180deg);
    } */

      /* .accordion .card-header .btn:not(:focus)::after{
        transform: rotate(180deg)
      } */

      /* .accordion .card-header .btn.collapsed::after {
        transform: rotate(-180deg);
      }

      .accordion .card-header .btn.collapsed::after {
        transform: rotate(-180deg);
      } */


      .accordion .card-header {
        padding: 0;
        border: none
      }

      .accordion .card-header .btn {
        display: block;
        width: 100%;
        height: 100%;
        padding: 1rem;
        margin: 0;
        border: none;
        text-align: left;
      }

      .accordion .card-header .btn:focus{
        border: none;
      }
  </style>
@endsection

@section('content')

    <div class=" mx-5 py-4">

        <div class="d-flex justify-content-between ">
            <h3>All Classes</h3>
            <div class="">
                <a href="{{route('classes.createNewClass')}}">
                    <button class="btn btn-primary"> <i class="fa fa-plus"></i> New Class</button>
                </a>
            </div>
        </div>


        <div class="mt-5">
            <div class="accordion w-100" id="accordionExample" >
                @foreach ($grades as $grade)
                <div class="card" class=" w-100">
                    <div class="card-header" id="heading{{$grade->id}}">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left accordion-btn" type="button" data-toggle="collapse" data-target="#collapse{{$grade->id}}" aria-expanded="false" aria-controls="collapse{{$grade->id}}">
                                {{$grade->grade_name}}
                            </button>
                        </h2>
                    </div>

                    <div id="collapse{{$grade->id}}" class="collapse" aria-labelledby="heading{{$grade->id}}" data-parent="#accordionExample">
                    <div class="card-body">
                        @if (count($grade->classes) != 0)
                            <div class="row">
                                @foreach ($grade->classes as $class)
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <a href="" class="text-decoration-none">
                                            <div class="info-box">
                                            <span class="info-box-icon bg-info elevation-1">
                                                <i class="fa fa-university" aria-hidden="true"></i>
                                            </span>

                                            <div class="info-box-content text-dark">
                                                <span class="info-box-text text-lg">{{$class->class_name}}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mx-3 my-2">
                                <h5>There is No Class Yet</h5>
                            </div>

                        @endif
                    </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $grades->links()}}
            </div>

        </div>
    </div>

@endsection

@section('scripts')

<script>
    // $('.collapse').collapse();

    // $('.accordion-btn').click(function(){
        $('.accordion .card-header .accordion-btn').click(function() {
            // Toggle rotation using a class
            $(this).find('.btn-after').toggleClass('rotated');
            $(this).toggleClass('rotated');
          });
    // });

</script>

@endsection
