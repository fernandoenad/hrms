@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Items</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active">Items</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Plantilla Position (SG) /  Station</th>
                                    <th>Current Appointment / Station</th>
                                </tr>
                            </thead>
                                @if(sizeof($items) > 0)
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <strong>
                                                    <a href="{{ route('ps.items.show', $item->id) }}">{{ $item->itemno }}</a>
                                                </strong>
                                            </td>
                                            <td>
                                                <strong>{{ $item->position }} ({{ $item->salarygrade }})</strong>
                                                <br>
                                                @if(isset($item->station))
                                                    
                                                    {{ $item->station->name }} ({{ $item->station->code }})
                                                @else
                                                    {{ __('Unfilled Item') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($item->employee))
                                                    <strong>
                                                        <a href="{{ route('ps.employees.show', $item->employee->id) }}">
                                                            {{ $item->employee->person->getFullnameSorted() }}
                                                        </a>
                                                    </strong>
                                                    <br>
                                                    {{ $item->employee->station->name }} ({{ $item->employee->station->code }})
                                                @else
                                                    {{ __('Unfilled Item') }}
                                                @endif
                                            </td>                                        
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            <tbody>

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
            @include('ps.items._tools')
        </div>        
    </div>
</div>
@endsection

