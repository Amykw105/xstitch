@extends('layouts.app')
@section('content')
<div class="container">
  <profileinfo userslug="{{$user->slug}}"></profileinfo>
  <liststatuses userslug="{{$user->slug}}" projectslug="{{$project->slug}}"></liststatuses>
</div>
@stop
