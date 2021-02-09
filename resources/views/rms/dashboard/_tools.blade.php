<div class="card card-default">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('rms.show', 'dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
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