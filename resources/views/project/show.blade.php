@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Project</div>

                <div class="panel-body">
                    This is project info
                    <projectinfo userslug="{{ Auth::user()->slug }}" projectslug="{{$projectslug}}" projectid="{{$projectid['id']}}"> </projectinfo>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
