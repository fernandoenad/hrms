<div class="card card-info">
    <div class="card-header">{{ __('Administrative Tools') }}</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ou.station.pbb.search', [$station->id, $year]) }}">
                @csrf
                <div class="input-group input-group-md">
                    <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="str" type="search" placeholder="Search list" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                </form>
            </li>
            @if(Route::currentRouteName() == 'ou.station.pbb.show' ||
                Route::currentRouteName() == 'ou.station.pbb.edit' ||
                Route::currentRouteName() == 'ou.station.employees.remove')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fas fa-user"></i> Modify employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fas fa-user"></i> Remove employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('ou.station.pbb', [$station->id, $year]) }}" class="nav-link">
                    <i class="fas fa-users"></i> Display list
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.pbb.add', [$station->id, $year]) }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> Add to list
                </a>
            </li>
        </ul>
    </div>
</div>

