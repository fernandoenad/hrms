<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{url('/')}}/storage/avatars/{{ $person->image }}">
        </div>

        <h3 class="profile-username text-center" style="font-size: 200%">{{ $person->getFullnameBox() }}</h3>
        <p class="text-muted text-center">{{ __('Applicant / Unassigned') }}</p>
    </div>
</div>