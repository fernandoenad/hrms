<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('img/logo.png') }}">
        </div>

        <h3 class="profile-username text-center">{{ $station->name ?? '' }}</h3>
        <p class="text-muted text-center">
            {{ $station->address ?? '' }} <br>
            {{ $station->office->name ?? '' }} ({{ $station->office->town->name ?? '' }})</p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>School ID</b> <a class="float-right">{{ $station->code ?? '' }}</a>
            </li>
            <li class="list-group-item">
                <b>Services</b> <a class="float-right">{{ $station->services ?? '' }}</a>
            </li>
            <li class="list-group-item">
                <b>Category</b> <a class="float-right">{{ $station->category ?? '' }}</a>
            </li>
            <li class="list-group-item">
                <b>Type</b> <a class="float-right">{{ $station->fiscalcategory ?? '' }}</a>
            </li>
            <li class="list-group-item">
                <b>School Head</b> <a class="float-right">{{ $station->person->user->name ?? '' }}</a>
            </li>
        </ul>
    </div>
</div>
