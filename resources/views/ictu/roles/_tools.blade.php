<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ictu.roles.search') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search user" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('ictu.roles') }}" class="nav-link">
                    <i class="fas fa-users"></i> View all                    
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ictu.roles.create') }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> New entry
                </a>
            </li>
            @if(Route::currentRouteName() == 'ictu.roles.show' ||
                Route::currentRouteName() == 'ictu.roles.edit' ||
                Route::currentRouteName() == 'ictu.roles.reset' ||
                Route::currentRouteName() == 'ictu.roles.confirm-delete') 
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ictu.roles.edit', $userrole->id ) }}" class="nav-link">
                        <i class="fas fa-user-edit"></i> Modify user
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ictu.roles.confirm-delete', $userrole->id)}}" class="nav-link">
                        <i class="fas fa-user-slash"></i> Remove access
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>