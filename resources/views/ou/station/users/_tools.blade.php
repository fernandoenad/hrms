<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <!--
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('dpsu.users.search') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search user" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            -->
            <li class="nav-item">
                <a href="{{ route('ou.station.users', $station->id) }}" class="nav-link">
                    <i class="fas fa-users"></i> View all                    
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.users.create', $station->id) }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> New entry
                </a>
            </li>
        </ul>
    </div>
</div>