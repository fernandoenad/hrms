<div class="card card-info">
    <div class="card-header">{{ __('Administrative Tools') }}</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ps.people.search') }}">
                    @csrf
                    <div class="input-group input-group-sm">
                        <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search profile" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.people') }}" class="nav-link">
                    <i class="fas fa-users"></i> View all
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.people.create') }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> New entry
                </a>
            </li>

            @if(Route::currentRouteName() == 'ps.people.edit' 
                || Route::currentRouteName() == 'ps.people.show' 
                || Route::currentRouteName() == 'ps.people.reset'
                || Route::currentRouteName() == 'ps.people.employ') 
                <li class="nav-item">
                    <a href="#" class="nav-link"><b></a></b> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.people.edit', $person->id)}}" class="nav-link"><i class="fas fa-user-edit"></i> Modify</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.people.employ', $person->id)}}" class="nav-link"><i class="fas fa-user-check"></i> Employ</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.people.reset', $person->id)}}" class="nav-link"><i class="fas fa-user-shield"></i> Reset password</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onClick="alert('Notice: Feature not active yet.')"><i class="fas fa-user-slash"></i> Disable account</a>
                </li>  
            @endif
        </ul>
    </div>
</div>