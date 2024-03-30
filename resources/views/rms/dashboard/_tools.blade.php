<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.account.register') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Register
                </a>
            </li>
        </ul>
    </div>
</div>

@include('rms.vacancies._tools')

@if(Route::currentRouteName() == 'rms_x' || Route::currentRouteName() == 'rms.show_x')
<div class="card card-info">
    <div class="card-header">Unique Visits</div>

    <div class="card-body text-center">
        <?php $unique_visit_count = App\Models\UserLog::select('sessionkey')
                ->groupBy('sessionkey')
                ->get()->count(); ?>
        <h4>{{ number_format($unique_visit_count, 0) }}</h4> visits
    </div>
</div>
@endif