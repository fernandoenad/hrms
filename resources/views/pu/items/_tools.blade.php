<div class="card card-info">
    <div class="card-header">Administrative Tools</div>

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
                <a href="{{ route('pu.items') }}" class="nav-link">
                    <i class="fas fa-tags"></i> View all                    
                </a>
            </li>

            @if(Route::currentRouteName() == 'pu.items.show' || 
                Route::currentRouteName() == 'pu.items.edit')
                <li class="nav-item">
                    <a href="#" class="nav-link"><b></a></b> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('pu.items.edit', $item->id )}}" class="nav-link"><i class="fas fa-edit"></i> Modify item</a>
                </li>         
            @endif
        </ul>
    </div>
</div>