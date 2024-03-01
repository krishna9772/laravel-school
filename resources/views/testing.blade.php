@extends('layouts.app')

@section('content')


    @foreach ($users as $user)
        <p class="text-danger">{{$user->user_name}}</p>
    @endforeach


@endsection
