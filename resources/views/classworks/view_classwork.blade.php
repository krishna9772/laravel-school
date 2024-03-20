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

<div class="mx-5 py-5">

    <div class="d-flex justify-content-between mb-5">
        <div class="">
            <h3>{{$gradeName}} - {{$className}}</h3>
            <h4 class="">{{$topicName}} Classwork</h4>
        </div>
        <div class="mt-3">
            <a href="{{route('classworks.create') }}">
                <button class="btn btn-primary mr-3"> <i class="fa fa-plus"></i> Create Classwork</button>
            </a>
        </div>
    </div>

    <div class="accordion w-100" id="accordionExample" >
        @foreach ($classworks as $classwork)
        <div class="card" class=" w-100">
            <div class="card-header" id="heading{{$classwork[0]->id}}">
                <h2 class="mb-0">
                    <button class="btn btn-block text-left accordion-btn " type="button" data-toggle="collapse" data-target="#collapse{{$classwork[0]->id}}" aria-expanded="false" aria-controls="collapse{{$classwork[0]->id}}">
                        {{$classwork[0]->sub_topic_name}}


                        <a href="{{route('classworks.edit',$classwork[0]->sub_topic_name)}}" onclick="event.stopPropagation();">
                            <i class="fa fa-edit mr-2 ml-3" aria-hidden="true"></i>
                        </a>

                        {{-- <a href="">
                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </a> --}}

                        <a type="button" class="trash-btn" data-toggle="modal" data-target="#deleteClassworkModal_{{$classwork[0]->id}}">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </button>

                </h2>


            </div>


            <div class="modal fade" id="deleteClassworkModal_{{$classwork[0]->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class='modal-header'>
                        <p class='col-12 modal-title text-center'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button><br><br>
                          <span class=" text-dark" style="font-size: 18px">Are you sure to delete all classworks of <br>
                            <span class=" font-weight-bold text-dark" style="font-size: 19px"> {{$classwork[0]->sub_topic_name}}? </span>
                          </span>
                        </p>
                      </div>

                    <div class="modal-footer  justify-content-center ">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      {{-- <button type="button" data-grade-id="{{$data[0]->grade->id}}" class="btn btn-danger deleteBtn">Delete</button> --}}
                        <a type="button" data-sub-topic-name="{{$classwork[0]->sub_topic_name}}" class="btn btn-danger deleteBtn">Delete</a>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div id="collapse{{$classwork[0]->id}}" class="collapse" aria-labelledby="heading{{$classwork[0]->id}}" data-parent="#accordionExample">
                <div class="card-body p-0">
                    <ul class="list-group p-0">
                        @foreach ($classwork as $data)
                            <li class="list-group-item">
                                <a href="" class="text-decoration-none">

                                    {{-- <div class="d-flex justify-content-between"> --}}
                                        <span class="text-dark">{{$data->source_title}}</span> -
                                        <span>
                                            @if ($data->url != null)
                                                {{$data->url}}
                                            @endif
                                            @if ($data->file != null)
                                                {{ $data->file}}
                                            @endif
                                        </span>
                                    {{-- </div> --}}

                                    {{-- <p>
                                        {{$data->source_title}}
                                        @if ($data->url != null)
                                            {{$data->url}}
                                        @endif
                                        @if ($data->file != null)
                                            {{ $data->file}}
                                        @endif
                                    </p> --}}

                                    {{-- <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1">
                                            <i class="fa fa-university" aria-hidden="true"></i>
                                        </span>

                                        <div class="info-box-content text-dark">
                                            <span class="info-box-text text-lg">
                                                {{$data->source_title}}
                                                @if ($data->url != null)
                                                    {{$data->url}}
                                                @endif
                                                @if ($data->file != null)
                                                    {{ $data->file}}
                                                @endif
                                            </span>
                                        </div>
                                    <!-- /.info-box-content -->
                                    </div> --}}
                                </a>
                            </li>
                            {{-- <div class="col-12 col-sm-6 col-md-3"> --}}

                            {{-- </div> --}}
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


{{-- accordion --}}


@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('.trash-btn').click(function(event) {
            event.stopPropagation();
            event.preventDefault();
            var targetModal = $(this).data('target');
            $(targetModal).modal('show');
        });

        $('.deleteBtn').click(function(event){
            event.preventDefault();

            var subTopicName = $(this).data('sub-topic-name');
            console.log(subTopicName);

            var listItem = $(this).closest('li');

            $.ajax({
                type: 'GET',
                url : '{{route('classworks.delete.with.subTopicName', ["subTopicName" => ":subTopicName"]) }}'.replace(':subTopicName', subTopicName),
                success: function(response) {
                    listItem.remove();
                    console.log(response);
                    if(response == 'success'){
                        // window.location.href = '{{ route('curricula.index') }}';
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                }
            });

        });

    });
</script>

@endsection
