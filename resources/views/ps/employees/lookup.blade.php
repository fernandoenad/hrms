@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Lookup Item</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees.show', $employee->id) }}">Employee</a></li>
                    @if(request()->redirect == 'ps.employees.re-employ')
                        <li class="breadcrumb-item"><a href="{{ route('ps.employees.re-employ', $employee->id) }}">Re-employ</a></li>
                    @else    
                        <li class="breadcrumb-item"><a href="{{ route('ps.employees.pr', $employee->id) }}">Promotion</a></li>
                    @endif
                    <li class="breadcrumb-item active">Lookup Item</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header pr-3">
                    <div class="float-right">
                        <form class="form-inline" method="post" action="{{ route('ps.employees.lookup-item', $employee->id) }}?redirect={{ request()->redirect }}">
                            @csrf

                            <div class="input-group input-group-md float-right">
                                <input id="searchString" name="searchString" class="form-control form-control-navbar" value="{{ request()->searchString }}" autocomplete="searchString" type="search" placeholder="Search item" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Item No.</th>
                                    <th>Position</th>
                                    <th>Plantilla Owner</th>
                                    <th>Deployment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($items) > 0)
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <strong>
                                                    <a href="{{ route(request()->redirect, $employee->id) }}?id={{ $item->id }}&name={{ $item->itemno }}">
                                                        {{ $item->itemno }}
                                                    </a>
                                                </strong>
                                            </td>
                                            <td>{{ $item->position }}</td>
                                            <td>
                                                <strong>{{ $item->station->name ?? __('Unassigned') }}</strong>
                                                ({{ $item->station->code ?? __('') }})
                                            </td>    
                                            <td>
                                                <strong>{{ $item->deployment->station->name ?? __('Unassigned') }}</strong>
                                                ({{ $item->deployment->station->code  ?? __('')}})
                                            </td>                                
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            {{ __('No record was found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $items->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('ps.people._tools')
        </div>        
    </div>
</div>
@endsection

