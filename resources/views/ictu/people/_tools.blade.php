<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ictu.people.search') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            @if(Route::currentRouteName() == 'ictu.people' || 
                Route::currentRouteName() == 'ictu.people.search' ||
                Route::currentRouteName() == 'ictu.people.show' ||
                Route::currentRouteName() == 'ictu.people.edit-credentials' || 
                Route::currentRouteName() == 'ictu.people.delete')
                <li class="nav-item">
                    <a href="{{ route('ictu.people') }}" class="nav-link">
                        <i class="fas fa-users"></i> View all
                    </a>
                </li>
            @else 
                <li class="nav-item">
                    <a href="{{ route('ictu.employees') }}" class="nav-link">
                        <i class="fas fa-users"></i> View all
                    </a>
                </li>
            @endif

            @if(Route::currentRouteName() == 'ictu.people.show' 
                || Route::currentRouteName() == 'ictu.people.reset'
                || Route::currentRouteName() == 'ictu.employees.show'
                || Route::currentRouteName() == 'ictu.people.edit-credentials'
                || Route::currentRouteName() == 'ictu.people.delete') 
                <li class="nav-item">
                    <a href="#" class="nav-link"><b></a></b> 
                </li>
                @if($person->user->isSuperAdmin() !== true)
                    <li class="nav-item">
                        <a href="{{ route('ictu.people.reset', $person->id) }}" class="nav-link"><i class="fas fa-user-edit"></i> Reset password</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('ictu.people.edit-credentials', $person->id) }}" class="nav-link"><i class="fas fa-user-edit"></i> Modify credentials</a>
                </li>                  

                @if($person->user->isSuperAdmin() !== true)
                    <li class="nav-item">
                        <a href="{{ route('ictu.people.delete', $person->id) }}" class="nav-link"><i class="fas fa-user-times"></i> Remove account</a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>