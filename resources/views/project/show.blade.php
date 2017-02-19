@extends('layouts.default')

@section('content')

        <section class="main_content">
                    <projectinfo userslug="{{ $user->slug }}" projectslug="{{$projectslug}}" projectid="{{$projectid['id']}}"> </projectinfo>
        </section>

@endsection
