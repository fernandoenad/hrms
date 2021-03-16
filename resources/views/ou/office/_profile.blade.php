<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('storage/images/logo.png') }}">
        </div>

        <h3 class="profile-username text-center">{{ $office->name ?? '' }}</h3>
        <p class="text-muted text-center">
            ({{ $office->town->name ?? '' }})</p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Office ID</b> <a class="float-right">{{ $office->id ?? '' }}</a>
            </li>
            <li class="list-group-item">
                <b>Office Head</b> <a class="float-right">{{ $office->person->user->name ?? '' }}</a>
            </li>
        </ul>
    </div>
</div>
