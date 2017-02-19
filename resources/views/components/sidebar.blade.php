
        <div class="side_content">
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
