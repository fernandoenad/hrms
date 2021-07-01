@if (Auth::check())
    
    <?php $userranking = App\Models\UserRanking::where('user_id', '=', Auth::id())->get(); ?>

    @if(sizeof($userranking) > 0 || Auth::user()->isSuperAdmin())
        <div class="card card-info">
            <div class="card-header">RMS Tools</div>

            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    @if(Route::currentRouteName() == 'rms')
                    <li class="nav-item">
                        <a href="{{ route('rms.vacancy') }}" class="nav-link">
                            <i class="fas fa-list"></i> My Assignments
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('rms') }}" class="nav-link">
                            <i class="fas fa-th"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rms.vacancy') }}" class="nav-link">
                            <i class="fas fa-list"></i> My Assignments
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif
@endif

@if(Route::currentRouteName() == 'rms.vacancy.show' || Route::currentRouteName() == 'rms.vacancy.show.ranking')
<div class="card card-info">
    <div class="card-header">Filters</div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show', [$vacancy->id, 'All']) }}" class="nav-link">
                    <i class="fas fa-list"></i> All Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show', [$vacancy->id, 'New']) }}" class="nav-link">
                    <i class="fas fa-list"></i> New Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show', [$vacancy->id, 'Update']) }}" class="nav-link">
                    <i class="fas fa-list"></i> Update Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show', [$vacancy->id, 'Retain']) }}" class="nav-link">
                    <i class="fas fa-list"></i> Retain Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show.ranking', [$vacancy->id, 'All']) }}" class="nav-link">
                    <i class="fas fa-list"></i> All Ranking Files
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show.ranking', [$vacancy->id, '1']) }}" class="nav-link">
                    <i class="fas fa-list"></i> CD 1 Ranking Files
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show.ranking', [$vacancy->id, '2']) }}" class="nav-link">
                    <i class="fas fa-list"></i> CD 2 Ranking Files
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.vacancy.show.ranking', [$vacancy->id, '3']) }}" class="nav-link">
                    <i class="fas fa-list"></i> CD 3 Ranking Files
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
