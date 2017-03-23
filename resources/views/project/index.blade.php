@extends('layouts.default')

@section('content')

        <projects userid="{{ $user->id }}" userslug="{{ $user->slug }}"
            @if (Auth::User()->id === $user->id)
              permissions="true"
            @else
              permissions="false"
            @endif
        ></projects>


        <statusfeed userid="{{ $user->id }}" userslug="{{ $user->slug }}"></statusfeed>


@endsection
