
        <div class="col-md-4">
          <div class="panel panel-default">
              <div class="panel-body">
                  <userinfo userid="{{ $user->id }}" userslug="{{ $user->slug }}"></userinfo>
                  <hr>
                  <useractions currentslug="{{Auth::user()->slug}}" currentid="{{Auth::user()->id}}" userid="{{ $user->id }}" userslug="{{ $user->slug }}"></useractions>
              </div>
          </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <followers userid="{{ $user->id }}" userslug="{{ $user->slug }}"></followers>
                </div>
            </div>
        </div>
