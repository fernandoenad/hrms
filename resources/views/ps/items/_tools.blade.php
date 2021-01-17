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
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ps.items.create') }}" class="nav-link">
                    <i class="fas fa-plus-square"></i> New entry
                </a>
            </li>
            @if(Route::currentRouteName() == 'ps.items.show' 
                || Route::currentRouteName() == 'ps.items.edit'
                || Route::currentRouteName() == 'ps.items.deactivate') 
                <li class="nav-item">
                    <a href="#" class="nav-link"><b></a></b> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('ps.items.edit', $item->id )}}" class="nav-link"><i class="fas fa-edit"></i> Modify item</a>
                </li>
                @if($item->status == 'Active')
                    @if(!isset($item->employee))
                        <li class="nav-item">
                            <a href="{{ route('ps.items.deactivate', $item->id) }}" class="nav-link"><i class="fas fa-ban"></i> Deactivate Item</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('ps.employees.edit', $item->employee->id) }}" class="nav-link"><i class="fas fa-user-tag"></i> Modify assignment</a>
                        </li>
                    @endif                    
                @else
                    <li class="nav-item">
                        <a href="{{ route('ps.items.activate', $item->id) }}" class="nav-link"><i class="fas fa-check"></i> Activate Item</a>
                    </li>
                @endif           
            @endif
        </ul>
    </div>
</div>