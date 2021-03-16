<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ou.office.applications' , $office->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.office.applications.needs-confirmation' , $office->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Needs Confirmation
                    <span class="badge badge-danger float-right">
                        {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                            ->join('offices', 'stations.office_id', '=', 'offices.id')
                            ->where('office_id', '=', $office->id)
                            ->where('services', 'like', 'elementary')
                            ->where('status', '=', 1)
                            ->count() }}
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>