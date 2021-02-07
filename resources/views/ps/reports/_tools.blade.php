<div class="card card-info">
    <div class="card-header">Categorized Reports</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ps.reports.plantilla') }}" class="nav-link">
                    <i class="fas fa-users"></i> Plantilla report
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.reports.deployment') }}" class="nav-link">
                    <i class="fas fa-users"></i> Deployment report
                </a>
            </li>            
        </ul>
    </div>
</div>

<div class="card card-info">
    <div class="card-header">Filtered Reports</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @if(Route::currentRouteName() == 'ps.reports.schools' || Route::currentRouteName() == 'ps.reports.schools-search')
                <li class="nav-item active p-3">
                    <form class="form-inline" method="post" action="{{ route('ps.reports.schools-search', $fiscalcategory) }}">
                        @csrf
                        <div class="input-group input-group-md">
                            <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search station" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('ps.reports.schools', '%') }}" class="nav-link">
                    <i class="fas fa-school"></i> All
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.reports.schools', 'Non-IUs') }}" class="nav-link">
                    <i class="fas fa-school"></i> Non-IUs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.reports.schools', 'IUs') }}" class="nav-link">
                    <i class="fas fa-school"></i> IUs
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-school"></i> SHSs
                </a>
            </li>
        </ul>
    </div>
</div>