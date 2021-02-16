<div class="card card-info">
    <div class="card-header">{{ __('Administrative Tools') }}</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ou.station.employees.search', $station->id) }}">
                @csrf
                <div class="input-group input-group-md">
                    <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="str" type="search" placeholder="Search employee" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                </form>
            </li>
            @if(Route::currentRouteName() == 'ou.station.employees.show' ||
                Route::currentRouteName() == 'ou.station.employees.add' || 
                Route::currentRouteName() == 'ou.station.employees.edit' ||
                Route::currentRouteName() == 'ou.station.employees.move') 
                <li class="nav-item">
                    <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                        <i class="fas fa-user"></i> View employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                        <i class="fas fa-user-edit"></i> Modify employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                        <i class="fas fa-user-minus"></i> Move/transfer employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                    <i class="fas fa-users"></i> View employees
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.employees.filter', [$station->id, '%']) }}" class="nav-link">
                    <i class="fas fa-users"></i> View all employees
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> Add employee
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.employees.items', [$station->id, 15]) }}" class="nav-link">
                    <i class="fas fa-user-tag"></i> View items
                </a>
            </li>
            <li class="nav-item">
                <?php $count = App\Models\Deployment::where('station_id', '=', $station->id)->count(); ?>
                <a href="{{ route('ou.station.employees.items', [$station->id, $count]) }}" class="nav-link">
                    <i class="fas fa-user-tag"></i> View all items
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.employees.plantilla', [$station->id, 15]) }}" class="nav-link">
                    <i class="fas fa-tags"></i> View plantilla
                </a>
            </li>
            <li class="nav-item">
                <?php $count = App\Models\Deployment::where('station_id', '=', $station->id)->count(); ?>
                <a href="{{ route('ou.station.employees.plantilla', [$station->id, $count]) }}" class="nav-link">
                    <i class="fas fa-tags"></i> View all plantilla
                </a>
            </li>
        </ul>
    </div>
</div>

