@if(Route::currentRouteName() == 'ou.office.pw.index' || 
    Route::currentRouteName() == 'ou.office.pw.lookup' || 
    Route::currentRouteName() == 'ou.office.pw.reset')
    <div class="card card-info">
        <div class="card-header">{{ __('Search') }}</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active p-3">
                    <form class="form-inline" method="post" action="{{ route('ou.office.pw.index', $office) }}">
                        @csrf
                        @method('post')
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
            </ul>
        </div>
    </div>

@endif 
