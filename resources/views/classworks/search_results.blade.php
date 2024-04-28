@extends('layouts.app')

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

        <h3 class="text-capitalize">{{$gradeName}} / {{$className}} / Classwork</h3>

        <div class="row">
            @if(count($groupedClasswork) != 0)
                @foreach ($groupedClasswork as $index => $classwork)
                    <div class="col-12 col-sm-6 col-md-3 mt-4" onclick="submitForm(this)" style="cursor: pointer">
                        <form class="classwork-form" action="{{route('classworks.show',$classwork[0]->topic_name)}}" method="get">
                            {{-- <input type="hidden" name="classword_id" value="{{$classwork[0]->id}}"> --}}
                            <input type="hidden" name="grade_name" value="{{$gradeName}}">
                            <input type="hidden" name="class_name" value="{{$className}}">

                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fa fa-university mr-2" aria-hidden="true"></i>
                                </span>
                                <div class="info-box-content text-dark">
                                    <span class="info-box-text text-lg">{{$classwork[0]->topic_name}}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            @else
            @can(['manage classworks'])

                <div class="m-auto">
                    <a href="{{route('classworks.create') }}">
                        <button class="btn btn-primary"> <i class="fa fa-plus"></i> New ClassWork</button>
                    </a>
                </div>
            @endcan
            @can(['view classworks'])
            <div class="m-auto">

                <p class="text-bold badge badge-info">No classworks assigned yet.</p>
            </div>
            @endcan

            @endif
        </div>


    {{-- </form> --}}

</div>

@endsection

@section('scripts')
<script>
    function submitForm(card) {
        $(card).find('.classwork-form').submit();
    }
</script>
@endsection
