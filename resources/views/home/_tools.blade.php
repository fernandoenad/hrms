<div class="card card-info">
    <div class="card-header">Search Topics</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('help.search') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="id" type="search" placeholder="Search topic" aria-label="str">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>

            <li class="nav-item">
                <a href="{{ route('help.track-requests') }}" class="nav-link">
                    <i class="fas fa-search"></i> Request lookup
                </a>
            </li>
        </ul>
    </div>
</div>