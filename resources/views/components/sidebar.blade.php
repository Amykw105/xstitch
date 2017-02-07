
        <div class="col-md-4">
          <div class="panel panel-default">
              <div class="panel-body">
                  <userinfo userid="{{ $user->id }}" userslug="{{ $user->slug }}"></userinfo>
              </div>
          </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <followers currentslug="{{Auth::user()->slug}}" currentid="{{Auth::user()->id}}" userid="{{ $user->id }}" userslug="{{ $user->slug }}"></followers>
                </div>
            </div>
        </div>
