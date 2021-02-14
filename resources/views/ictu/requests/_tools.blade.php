<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ictu.requests.search') }}">
                @csrf

                <div class="input-group input-group-md">
                    <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="str" type="str" placeholder="Search request..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('ictu.requests') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> View all
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('ictu.requests.activations') }}" class="nav-link">
                    <i class="fas fa-user"></i> Recent Activations
                </a>
            </li>
        </ul>
    </div>
</div>