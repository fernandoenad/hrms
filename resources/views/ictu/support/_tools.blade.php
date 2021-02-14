<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ictu.support.search') }}">
                @csrf

                <div class="input-group input-group-md">
                    <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="searchString" type="str" placeholder="Search article..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('ictu.support') }}" class="nav-link">
                    <i class="fas fa-life-ring"></i> View all
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('ictu.support.create') }}" class="nav-link">
                    <i class="fas fa-life-ring"></i> New Entry
                </a>
            </li>
        </ul>
    </div>
</div>