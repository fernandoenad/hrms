<div class="card card-info">
    <div class="card-header">{{ __('Administrative Tools') }}</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                @if(Route::currentRouteName() == 'ps.people' || Route::currentRouteName() == 'ps.people.search') 
                    <form class="form-inline" method="post" action="{{ route('ps.people.search') }}">
                @else
                    <form class="form-inline" method="post" action="{{ route('ps.employees.search') }}">
                @endif
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
            @if(Route::currentRouteName() == 'ps.people')
                <li class="nav-item">
                    <a href="{{ route('ps.people') }}" class="nav-link">
                        <i class="fas fa-users"></i> View all
                    </a>
                </li>
            @else 
                <li class="nav-item">
                    <a href="{{ route('ps.employees') }}" class="nav-link">
                        <i class="fas fa-users"></i> View all
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('ps.people.create') }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> New entry
                </a>
            </li>

            @if(Route::currentRouteName() == 'ps.people.edit' 
                || Route::currentRouteName() == 'ps.people.show' 
                || Route::currentRouteName() == 'ps.people.reset'
                || Route::currentRouteName() == 'ps.people.employ'
                || Route::currentRouteName() == 'ps.employees.show'
                || Route::currentRouteName() == 'ps.employees.edit'
                || Route::currentRouteName() == 'ps.employees.confirm-delete'
                || Route::currentRouteName() == 'ps.employees.si'
                || Route::currentRouteName() == 'ps.employees.pr'
                || Route::currentRouteName() == 'ps.employees.ee') 
                <li class="nav-item">
                    <a href="#" class="nav-link"><b></a></b> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.people.edit', $person->id)}}" class="nav-link"><i class="fas fa-user-edit"></i> Modify profile</a>
                </li>
                @if(isset($person->employee) && isset($person->employee->item))
                    <li class="nav-item">
                        <a href="{{ route('ps.employees.edit', $person->employee->id) }}" class="nav-link"><i class="fas fa-user-tag"></i> Modify employment</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ps.employees.si', $person->employee->id) }}" class="nav-link"><i class="fas fa-sort-numeric-up-alt"></i> &nbsp;Increment SG-Step</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ps.employees.pr', $person->employee->id) }}" class="nav-link"><i class="fas fa-sort-amount-up"></i> &nbsp;Promote rank</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ps.employees.ee', $person->employee->id) }}" class="nav-link"><i class="fas fa-stop-circle"></i>  &nbsp;End employment</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ps.employees.confirm-delete', $person->employee->id) }}" class="nav-link"><i class="fas fa-user-times"></i> Remove employment</a>
                    </li>
                @else
                    @if(!isset($person->employee))
                    <li class="nav-item">
                        <a href="{{ route('ps.people.employ', $person->id)}}" class="nav-link"><i class="fas fa-user-tag"></i> Employ</a>
                    </li>
                    @endif
                @endif
                <li class="nav-item">
                    <a href="{{ route('ps.people.reset', $person->id)}}" class="nav-link"><i class="fas fa-user-shield"></i> Reset password</a>
                </li>
                
            @endif
        </ul>
    </div>
</div>