@extends('layouts.app')
@section('content')
<div class="container">
  <profileinfo userslug="{{$user->slug}}"></profileinfo>
  <listprojects userslug="{{$user->slug}}"></listprojects>
  <br/><br/>
  
</div>
@stop
