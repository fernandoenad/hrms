<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('storage/avatars') }}/{{ $person->image }}">
        </div>

        <h3 class="profile-username text-center">{{ $person->getFullname() }}</h3>
        @if(isset($person->employee->item_id))
            <p class="text-muted text-center">{{ $person->employee->item->position ?? __('') }}</p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Employee No</b> <a class="float-right">{{ $person->employee->empno ?? __('') }}</a>
                </li>
                <li class="list-group-item">
                    <b>Hire Date</b> <a class="float-right">{{ $person->employee->hiredate ?? __('') }}</a>
                </li>
                <li class="list-group-item">
                    <b>Years in Service</b> <a class="float-right">@if(isset($person->employee->hiredate)) {{ $person->employee->getYearsInService() }} @else {{ __('') }} @endif</a>
                </li>
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right">@if(isset($person->employee->item_id)) {{ $person->employee->getStatus() }} @else {{ __('') }} @endif</a>
                </li>
            </ul>
        @else
            <p class="text-muted text-center">{{ __('Applicant') }}</p>
        @endif
    </div>
</div>

<div class="card card-info">
    <div class="card-header">Logs</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <?php $userlogs =  Auth::user()->userlog()->select('sessionkey')
                ->groupBy('sessionkey')
                ->take(5)
                ->get(); ?>
            @foreach($userlogs as $userlog)
            <li class="nav-item">
                <a href="#" class="nav-link">
                <?php $userlog_r =  App\Models\UserLog::where('sessionkey', '=', $userlog->sessionkey)
                    ->get()->first(); ?>
                    {{ $userlog_r->ip ?? '' }}
                    <span class="badge badge-warning float-right">{{ date('M d, Y', strtotime($userlog_r->created_at)) }}</span>
                </a>
            </li> 
            @endforeach
        </ul>
    </div>
</div>