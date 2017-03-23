<div class="side_content">
    <div class="profile">
        <div class="user-details">
            <userinfo userid="{{ $user->id }}" userslug="{{ $user->slug }}"></userinfo>
        </div>
        <div class="follow-details">
            <followers currentslug="{{Auth::user()->slug}}" currentid="{{Auth::user()->id}}" userid="{{ $user->id }}" userslug="{{ $user->slug }}"></followers>
        </div>
    </div>
</div>
