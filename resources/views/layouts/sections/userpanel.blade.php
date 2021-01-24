<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('storage/avatars') }}/{{ Auth::user()->person->image }}" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">{{ Auth::user()->person->getFullname() }}</span>
        </a>
        
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <li class="user-header bg-primary">
                <img src="{{ asset('storage/avatars') }}/{{ Auth::user()->person->image }}" class="img-circle elevation-2" alt="User Image">
                <p>
                    {{ Auth::user()->person->getFullname() }} 
                    <small>{{ Auth::user()->getUserType() }}</small>
                </p>
            </li>
            <li class="user-footer">
                <a href="{{ route('my.tools') }}" class="btn btn-default btn-flat">{{ __('Tools') }}</a>
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Sign out') }}
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </li>
</ul>