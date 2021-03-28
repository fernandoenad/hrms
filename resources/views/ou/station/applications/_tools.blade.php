<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ou.station.applications' , $station->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.needs-confirmation' , $station->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Needs Confirmation
                    <span class="badge badge-danger float-right">
                        {{ App\Models\Application::where('station_id', '=', $station->id)
                            ->where('status', '=', 1)->get()->count() }}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fas fa-upload"></i> Upload Ranklist
                </a>
            </li>
        </ul>
    </div>
</div>