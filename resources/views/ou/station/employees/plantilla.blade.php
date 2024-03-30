@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Plantilla</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }} </a></li>
                    <li class="breadcrumb-item active">Plantilla</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active</span>
                            <span class="info-box-number">
                                {{ number_format(
                                    App\Models\Item::join('employees', 'items.id', '=', 'employees.item_id')
                                        ->where('items.station_id', '=', $station->id)
                                        ->where('status', '=', 1)->count()
                                    , 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-folder-open"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Unfilled</span>
                            <span class="info-box-number">
                                {{ number_format(
                                    App\Models\Item::whereNotIn('items.id', function($query){
                                            $query->select('item_id')->from('employees');
                                            })
                                        ->where('items.station_id', '=', $station->id)
                                        ->where('status', '=', 1)
                                        ->count()
                                    , 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-folder-minus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Deactivated</span>
                            <span class="info-box-number">
                                {{ number_format(
                                    App\Models\Item::join('employees', 'items.id', '=', 'employees.item_id')
                                        ->where('items.station_id', '=', $station->id)
                                        ->where('status', '=', 0)->count()
                                    , 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    Item List
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item #</th>
                                    <th>Plantilla Position (SG) /  Station</th>
                                    <th>Current Appointment / Station</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($items) > 0)
                                    <?php $i=1; ?>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <div id="accordion" >
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $item->id }}">
                                                        <strong>{{ $item->itemno }}</strong>
                                                    </a>
                                                    <br>
                                                    @if($item->status == 'Inactive') {{ __('Deactivated') }} @endif
                                                    <div id="collapseOne{{ $item->id }}" class="panel-collapse collapse in">
                                                        Type: <strong>{{ $item->employeetype ?? ''  }}</strong> <br>
                                                        Level: <strong>{{ $item->level ?? ''  }}</strong> <br>
                                                        Creation: <strong>{{ $item->creationdate ?? ''  }}</strong> <br>
                                                        Appointment: <strong>{{ $item->appointmentdate ?? '-'  }}</strong> <br>
                                                        First Day: <strong>{{ $item->firstdaydate ?? '-'  }}</strong> <br>
                                                        Confirmation: <strong>{{ $item->confirmationdate ?? '-'  }}</strong> <br>
                                                        Remarks: <strong>{{ $item->remarks ?? '-'  }}</strong> <br>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $item->position }} ({{ $item->salarygrade }})</strong>
                                                <br>
                                                @if(isset($item->station))
                                                    
                                                    {{ $item->station->name }} ({{ $item->station->code }})
                                                @else
                                                    <strong class="text-danger">{{ __('Unassigned Item') }}</strong>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($item->employee))
                                                    <strong>
                                                        <a href="{{ route('ou.station.employees.show', [$station->id, $item->employee->id]) }}">
                                                            {{ $item->employee->person->getFullnameSorted() }}
                                                        </a>
                                                    </strong>                                                   
                                                @else
                                                    <strong class="text-danger">{{ __('Unfilled Item') }}</strong>
                                                @endif
                                                <br>
                                                @if(isset($item->deployment->station))
                                                    {{ $item->deployment->station->name }} ({{ $item->deployment->station->code }})
                                                @else
                                                    <strong class="text-danger">{{ __('Undeployed Item') }}</strong>
                                                @endif
                                            </td>                                        
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <span class="float-right">{{ $items->links() }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.employees._tools')
        </div>
    </div>
</div>

@endsection
