@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Requests Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Requests Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">All</span>
                            <span class="info-box-number">
                                <a href="{{ route('ictu.requests') }}">
                                    {{ number_format(App\Models\AccountRequest::count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New</span>
                            <span class="info-box-number">
                                <a href="{{ route('ictu.requests.display-new') }}">
                                    {{ number_format(App\Models\AccountRequest::where('status', '=', 1)->count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number">
                                <a href="{{ route('ictu.requests.display-pending') }}">
                                    {{ number_format(App\Models\AccountRequest::where('status', '=', 2)->count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Resolved</span>
                            <span class="info-box-number">
                                <a href="{{ route('ictu.requests.display-resolved') }}">
                                    {{ number_format(App\Models\AccountRequest::where('status', '=', 3)->count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(Route::currentRouteName() == 'ictu.requests.edit')
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                Take Action for Request ID: #<strong>{{ $accountrequest->id ?? '' }}</strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('ictu.requests.update', $accountrequest->id) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group row">
                                    <label for="action_old" class="col-md-3 col-form-label text-md-right">{{ __('Reqt Action') }}</label>

                                    <div class="col-md-8 pt-2">
                                        {{ $accountrequest->action ?? '' }}

                                        @error('action_old')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="remarks_old" class="col-md-3 col-form-label text-md-right">{{ __('Reqt Remarks') }}</label>

                                    <div class="col-md-8 pt-2">
                                        <?php echo $accountrequest->remarks ?? ''; ?>
                                    </div>
                                </div>

                                <!--
                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-form-label text-md-right">Action Options</label>

                                    <div class="col-md-8 pt-2">
                                        <small>
                                        @if(isset($accountrequest->person)) 
                                            <a href="{{ route('ictu.people.edit-credentials', $accountrequest->person->id) }}" target="_blank">Modify Credentials / Reset Password</a>
                                            / <a href="{{ route('ictu.requests.reset-password', $accountrequest->id) }}">Reset Password</a>
                                            / <a href="{{ route('ictu.requests.verify-email', $accountrequest->id) }}">Verify Manually</a> 
                                        @else
                                            <?php $remarks_arr = explode('/', $accountrequest->remarks);  ?>
                                            <a href="{{ route('ictu.people.search') }}?searchString={{ $remarks_arr[0] }}" target="_blank">Modify Email</a>  
                                        @endif                                        

                                        </small>
                                    </div>
                                </div>
                                -->

                                <div class="form-group row">
                                    <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Action') }}</label>

                                    <div class="col-md-8">
                                        <select id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" autocomplete="status">
                                            <option value="2" @if(old('status') == 2 || $accountrequest->status == 2) {{ 'selected' }} @endif>Pending</option>
                                            <option value="3" @if(old('status') == 3 || $accountrequest->status == 3) {{ 'selected' }} @endif>Resolved</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="remarks" class="col-md-3 col-form-label text-md-right">{{ __('Remarks') }}</label>

                                    <div class="col-md-8">
                                        <textarea id="type" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" autocomplete="remarks"></textarea>

                                        @error('remarks')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-primary float-right">
                                                {{ __('Save Action') }}
                                            </button>
                                            <a href="{{ route('ictu.requests') }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>  
                    </div> 
                </div> 
            @endif

            <div class="card card-outline card-primary">
                <div class="card-header">
                    Account Request List
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Help ID</th>
                                    <th>Action</th>
                                    <th width="10%">Remarks</th>
                                    <th>Status</th>
                                    <th>Actor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($accountrequests) > 0)
                                    @foreach($accountrequests as $accountrequest)
                                    <tr>
                                        <td>{{ $accountrequest->id ?? '' }}</td>
                                        <td>
                                            <small>
                                            {{ $accountrequest->action ?? '' }}
                                            <br>
                                            @if(isset($accountrequest->person)) 
                                                <strong>{{ $accountrequest->person->getFullnameBox() }}</strong>
                                            @endif
                                            </small>
                                        </td>
                                        <td><small>{{ strip_tags(substr($accountrequest->remarks, 0, 40) ?? '') }}...</small></td>
                                        <td>
                                            <span class="badge badge-{{ $accountrequest->getStatuscolor($accountrequest->status) ?? '' }}"
                                                title="{{ date('M d, Y h:ia', strtotime($accountrequest->created_at)) ?? '' }}">
                                                {{ $accountrequest->getStatus($accountrequest->status) ?? '' }}
                                            </span>
                                            <br>
                                        </td>
                                        <td><small>{{ $accountrequest->user->name ?? 'No case owner yet' }}</small></td>
                                        <td><a href="{{ route('ictu.requests.edit', $accountrequest->id) }}" class="btn btn-primary btn-sm">Take Action</a></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix p-2 pb-0">
                    <div class="float-right small">
                        {{ $accountrequests->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.requests._tools')
        </div>
    </div>
</div>
@endsection
