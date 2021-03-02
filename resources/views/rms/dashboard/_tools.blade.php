<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.show', 'announcements') }}" class="nav-link">
                    <i class="fas fa-th"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.show', 'announcements') }}" class="nav-link">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.show', 'vacancies') }}" class="nav-link">
                    <i class="fas fa-vote-yea"></i> Vacancies
                    <span class="badge badge-danger float-right">
                        <?php $vacancies = App\Models\Vacancy::where('status', '=', 1)
                            ->orderBy('salarygrade', 'desc')
                            ->get(); ?>
                        {{ $vacancies->count() }} Open</span>
                </a>
            </li>
            @guest
            @else
                @if(Auth::user()->hasRole('ps'))
                <li class="nav-item">
                    <a href="{{ route('ps.rms') }}" class="nav-link">
                        <i class="fas fa-inbox"></i> Applications
                    </a>
                </li>
                @endif
            @endguest
            <li class="nav-item">
                <a href="{{ route('rms.show', 'faqs') }}" class="nav-link">
                    <i class="fas fa-question-circle"></i> FAQs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rms.show', 'about') }}" class="nav-link">
                    <i class="fas fa-info-circle"></i> About
                </a>
            </li>
        </ul>
    </div>
</div>

@if(Route::currentRouteName() == 'rms' || Route::currentRouteName() == 'rms.show')
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