<div class="card card-info">
    <div class="card-header">Request Lookup</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active p-3">
                <form class="form-inline" method="post" action="{{ route('help.track-request') }}">
                    @csrf
                    <div class="input-group input-group-md">
                        <input id="id" name="id" class="form-control form-control-navbar @error('id') is-invalid @enderror" value="{{ old('id') ?? request()->get('id') }}" autocomplete="id" type="search" placeholder="Request reference no" aria-label="id">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            @guest
            @else
                <?php $accountrequests = App\Models\AccountRequest::where('person_id', '=', Auth::user()->person->id)->get(); ?>
                
                @foreach($accountrequests as $accountrequest)
                    <li class="nav-item">
                        <a href="{{ route('help.track-request') }}" class="nav-link" 
                            onclick="event.preventDefault();
                            document.getElementById('accountrequest-form-{{ $accountrequest->id ?? '' }}').submit();">
                            <i class="fas fa-search"></i> Reference #{{ $accountrequest->id }}
                        </a>
                    </li>
                    <form id="accountrequest-form-{{ $accountrequest->id ?? '' }}" action="{{ route('help.track-request') }}" method="POST" class="d-none">
                        @csrf
                        <input type="text" id="id" name="id" value="{{ $accountrequest->id ?? '' }}">
                    </form>
                @endforeach
            @endguest
        </ul>
    </div>
</div>