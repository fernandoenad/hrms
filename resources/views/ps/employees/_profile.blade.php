<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{url('/')}}/storage/avatars/{{ $employee->person->image }}">
        </div>

        <h3 class="profile-username text-center" style="font-size: 200%">{{ $employee->person->getFullnameBox() }}</h3>
        <p class="text-muted text-center">{{ $employee->item->position }}</p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Employee No</b> <a class="float-right">{{ $employee->empno ?? __('') }}</a>
            </li>
            <li class="list-group-item">
                <b>Hire Date</b> <a class="float-right">{{ $employee->hiredate ?? __('') }}</a>
            </li>
            <li class="list-group-item">
                <b>Years in Service</b> <a class="float-right">@if(isset($employee->hiredate)) {{ $employee->getYearsInService() }} @else {{ __('') }} @endif</a>
            </li>
            <li class="list-group-item">
                <b>Status</b> <a class="float-right">@if(isset($employee->item_id)) {{ $employee->getStatus() }} @else {{ __('') }} @endif</a>
            </li>                      
        </ul>
    </div>
</div>