<div class="card-body box-profile">
    <div class="text-center">
        <img class="profile-user-img img-fluid img-circle"
            src="{{url('/')}}/storage/avatars/{{ $person->image }}">
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