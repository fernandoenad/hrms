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

@if(Route::currentRouteName() == 'ps.rms.applications-show-cycle')
    <div class="card card-info">
        <div class="card-header">Application Filters</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('ps.rms') }}" class="nav-link">
                        <i class="fas fa-inbox"></i> New
                        <span class="badge badge-danger float-right">
                            {{ App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'New')->get()->count() }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms') }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Update
                        <span class="badge badge-danger float-right">
                            {{ App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'Update')->get()->count() }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.rms') }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Retain
                        <span class="badge badge-danger float-right">
                            {{ App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', 'Retain')->get()->count() }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif