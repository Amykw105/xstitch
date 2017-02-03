@extends('layouts.default')

@section('content')

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Project</div>

                <div class="panel-body">
                    This is project info
                    <projectinfo userslug="{{ $user->slug }}" projectslug="{{$projectslug}}" projectid="{{$projectid['id']}}"> </projectinfo>
                </div>
            </div>
        </div>

@endsection
