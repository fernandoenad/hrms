<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{url('/')}}/storage/avatars/{{ $person->image }}">
        </div>

        <h3 class="profile-username text-center" style="font-size: 200%">{{ $person->getFullnameBox() }}</h3>
        <p class="text-muted text-center">
            @if(isset($person->employee->item))
                {{ $person->employee->item->position }} 
                <br>
                <small>
                    {{ $person->employee->item->deployment->station->name }} 
                    ({{ $person->employee->item->deployment->station->code }})
                </small>
            @else  
                {{ __('Applicant / Unassigned') }}
            @endif                
        </p>
        @if(isset($person->employee->item))
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Empl No</b> <a class="float-right">{{ $person->employee->empno ?? __('') }}</a>
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
        @endif
    </div>
</div>