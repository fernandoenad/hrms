<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.vacancy') }}" class="nav-link">
                    <i class="fas fa-list"></i> My Assignments
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.user') }}" class="nav-link">
                    <i class="fas fa-users-cog"></i> Users
                </a>
            </li>
        </ul>
    </div>
</div>
@if(Route::currentRouteName() == 'rms.vacancy.show')
<div class="card card-info">
    <div class="card-header">Filters</div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show', $vacancy->id) }}" class="nav-link">
                    <i class="fas fa-list"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.user') }}" class="nav-link">
                    <i class="fas fa-list"></i> Ranking Files
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
