@extends('layouts.app')

@section('content')

<div class="mx-5 py-5">

    {{-- <form action="" method="get"> --}}

        <h3>{{$gradeName}} - {{$className}} Classwork</h3>

        <div class="row">
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
