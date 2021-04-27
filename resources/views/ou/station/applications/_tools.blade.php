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

            @if(Route::currentRouteName() == 'ou.station.applications.showvacancy' ||
                Route::currentRouteName() == 'ou.station.applications.upload-ranklist')    
                <?php $ranking = App\Models\Ranking::where('year', '=', $cycle)->where('vacancy_id', '=', $vacancy->id)->where('station_id', '=', $station->id)->orderby('rankings.id', 'desc')->get()->first(); ?>         
                
                @if($ranking != null)
                <li class="nav-item">
                    <a href="{{ asset('storage/') }}/{{ $ranking->attachment }}" class="nav-link" download>
                        <i class="fas fa-eye"></i> View Ranklist
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ou.station.applications.upload-ranklist', [$station->id, $cycle, $vacancy->id]) }}?ranking_id={{ $ranking->id }}" class="nav-link">
                        <i class="fas fa-upload"></i> Re-upload Ranklist
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('ou.station.applications.upload-ranklist', [$station->id, $cycle, $vacancy->id]) }}" class="nav-link">
                        <i class="fas fa-upload"></i> Upload Ranklist
                    </a>
                </li>
                @endif                
            @endif
        </ul>
    </div>
</div>