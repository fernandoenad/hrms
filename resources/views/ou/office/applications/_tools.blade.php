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
            @if(Route::currentRouteName() == 'ou.office.applications.showvacancys' ||
                Route::currentRouteName() == 'ou.office.applications.upload-ranklists')    
                <?php $ranking = App\Models\Ranking::join('stations', 'station_id', '=', 'stations.id')->where('year', '=', $cycle)->where('vacancy_id', '=', $vacancy->id)->where('office_id', '=', $office->id)->get()->first(); ?>         

                @if($ranking != null)
                <li class="nav-item">
                    <a href="{{ asset('storage/') }}/{{ $ranking->attachment }}" class="nav-link" download>
                        <i class="fas fa-eye"></i> View Ranklist
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('ou.office.applications.upload-ranklist', [$office->id, $cycle, $vacancy->id]) }}" class="nav-link">
                        <i class="fas fa-upload"></i> Upload Ranklist
                    </a>
                </li>
                @endif                
            @endif
        </ul>
    </div>
</div>