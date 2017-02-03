@extends('layouts.default')

@section('content')

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <projects userid="{{ $user->id }}" userslug="{{ $user->slug }}"
                      @if (Auth::User()->id === $user->id)
                        permissions="true"
                      @else
                        permissions="false"
                      @endif
                      ></projects>
                </div>
            </div>
        </div>

@endsection
