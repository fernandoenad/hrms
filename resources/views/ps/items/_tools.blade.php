<div class="card card-info">
    <div class="card-header">{{ __('Administrative Tools') }}</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('ps.items.search') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search item no" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.items') }}" class="nav-link">
                    <i class="fas fa-tags"></i> View all 
                    <span class="badge badge float-right">{{ number_format($items_a, 0) }}</span>
                    
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.items.unfilled') }}" class="nav-link">
                    <i class="fas fa-box-open"></i> Unfilled items 
                    <span class="badge badge float-right">{{ number_format($items_un, 0) }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.items.create') }}" class="nav-link">
                    <i class="fas fa-cart-plus"></i> New entry
                </a>
            </li>
        </ul>
    </div>
</div>