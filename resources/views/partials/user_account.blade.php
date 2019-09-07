<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="icon">
            <i class="ion ion-person"> </i>
        </span>
        <span class="hidden-xs"> {{ (isset(\Auth::user()->name)?\Auth::user()->name:'Logged In User') }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            @if (isset(\Auth::user()->profile_pic))
                <img src="{{ config('app.app_public_path') }}img/user2-160x160.jpg" class="img-circle" alt="User Image">
            @else
                <div class="icon">
                    <i class="ion ion-person master_user_avatar"></i>
                </div>
            @endif
            <p>
                {{ (isset(\Auth::user()->name)?\Auth::user()->name:'Logged In User') }} ({{ (isset(\Auth::user()->name)?strtoupper(\Auth::user()->role):'') }})
            </p>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">
            <div>
                <a href="{{ config('app.app_url_prefix') }}/logout" class="btn btn-default btn-flat">Log out</a>
            </div>
        </li>
    </ul>
</li>