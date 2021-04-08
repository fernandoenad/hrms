<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ps.rms') }}" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.rms.posts', 'Announcements') }}" class="nav-link">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.rms.posts', 'FAQs') }}" class="nav-link">
                    <i class="fas fa-question-circle"></i> RMS FAQs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.rms.vacancies') }}" class="nav-link">
                    <i class="fas fa-vote-yea"></i> Vacancies
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.rms.applications') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.rms.applications-needs-confirmation') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Needs Confirmation
                    <span class="badge badge-danger float-right">
                        {{ App\Models\Application::where('station_id', '=', 0)
                            ->where('status', '=', 1)->get()->count() }}
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>

@if(Route::currentRouteName() == 'ps.rms.applications-show-cycle' ||
    Route::currentRouteName() == 'ps.rms.applications-show-showfilter')
    <div class="card card-info">
        <div class="card-header">Application Filters</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-showfilter', [$cycle, 'New', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> New
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'New')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-showfilter', [$cycle, 'Update', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Update
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'Update')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-showfilter', [$cycle, 'Retain', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Retain
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'Retain')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif

@if(Route::currentRouteName() == 'ps.rms.applications-show-vacancy' ||
    Route::currentRouteName() == 'ps.rms.applications-show-vacancyfilter' || 
    Route::currentRouteName() == 'ps.rms.applications-show-ranking' )
    <div class="card card-info">
        <div class="card-header">Application Filters</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-vacancyfilter', [$cycle, $vacancy->id, 'New', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> New
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('vacancy_id', '=', $vacancy->id)
                                ->where('type', '=', 'New')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-vacancyfilter', [$cycle, $vacancy->id, 'Update', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Update
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('vacancy_id', '=', $vacancy->id)
                                ->where('type', '=', 'Update')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-vacancyfilter', [$cycle, $vacancy->id, 'Retain', 15]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Retain
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('vacancy_id', '=', $vacancy->id)
                                ->where('type', '=', 'Retain')->get()->count(),0) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">Ranking Files</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('ps.rms.applications-show-ranking', [$cycle, $vacancy->id]) }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Initial Ranking
                        <span class="badge badge-danger float-right">
                            {{ number_format(App\Models\Ranking::where('year', '=', $cycle)
                                ->where('vacancy_id', '=', $vacancy->id)->get()->count(),0) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif