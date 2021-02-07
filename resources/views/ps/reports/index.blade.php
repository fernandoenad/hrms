@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Report Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <i class="fas fa-print"></i>
                    Quick View Reports
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-report1-tab" data-toggle="pill" href="#vert-tabs-report1" role="tab" aria-controls="vert-tabs-report1" aria-selected="true">Report on Number of Teaching and Non-Teaching Employees</a>
                                <a class="nav-link" id="vert-tabs-report2-tab" data-toggle="pill" href="#vert-tabs-report2" role="tab" aria-controls="vert-tabs-report2" aria-selected="false">Personnel Complement Report</a>
                                <a class="nav-link" id="vert-tabs-report3-tab" data-toggle="pill" href="#vert-tabs-report3" role="tab" aria-controls="vert-tabs-report3" aria-selected="false">Report Non-Plantilla</a>

                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade show active" id="vert-tabs-report1" role="tabpanel" aria-labelledby="vert-tabs-report1-tab">
                                    <h5>Report on Number of Teaching and Non-Teaching Employees</h5>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>Employees</th>
                                                    <th class="text-right">Male</th>
                                                    <th class="text-right">Female</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="4">TEACHING</th>
                                                </tr>

                                                <?php $male_t_subt = 0; $female_t_subt = 0; $total_t_subt = 0; ?>
                                                @if(sizeof($teachingemployees) > 0)
                                                    @foreach($teachingemployees as $teachingemployee)
                                                        <tr> 
                                                            <td>{{ $teachingemployee->level ?? '' }}</td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $male_t_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $teachingemployee->level)
                                                                        ->where('employeetype', '=', 'Teaching')
                                                                        ->where('sex', '=', 'Male')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($male_t_count, 0) }}   
                                                            </td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $female_t_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $teachingemployee->level)
                                                                        ->where('employeetype', '=', 'Teaching')
                                                                        ->where('sex', '=', 'Female')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($female_t_count, 0) }}                          
                                                            </td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $total_t_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $teachingemployee->level)
                                                                        ->where('employeetype', '=', 'Teaching')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($total_t_count, 0) }} 
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                            $male_t_subt = $male_t_subt + $male_t_count; 
                                                            $female_t_subt = $female_t_subt + $female_t_count; 
                                                            $total_t_subt = $total_t_subt + $total_t_count; 
                                                        ?>
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="4">No record found.</td</tr>
                                                @endif
                                                <tr>
                                                    <th>Subtotal</th>
                                                    <th class="text-right">{{ number_format($male_t_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($female_t_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($total_t_subt, 0) }}</th>
                                                </tr>

                                                <tr>
                                                    <th colspan="4">NON-TEACHING</th>
                                                </tr>
                                                <?php $male_nt_subt = 0; $female_nt_subt = 0; $total_nt_subt = 0; ?>
                                                @if(sizeof($nonteachingemployees) > 0)
                                                    @foreach($nonteachingemployees as $nonteachingemployee)
                                                        <tr> 
                                                            <td>{{ $nonteachingemployee->level ?? '' }}</td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $male_nt_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $nonteachingemployee->level)
                                                                        ->where('employeetype', '=', 'Non-Teaching')
                                                                        ->where('sex', '=', 'Male')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($male_nt_count, 0) }}   
                                                            </td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $female_nt_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $nonteachingemployee->level)
                                                                        ->where('employeetype', '=', 'Non-Teaching')
                                                                        ->where('sex', '=', 'Female')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($female_nt_count, 0) }}                          
                                                            </td>
                                                            <td class="text-right">
                                                                <?php 
                                                                    $total_nt_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                                                        ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                                                        ->join('people', 'employees.person_id', '=', 'people.id')
                                                                        ->where('level', '=', $nonteachingemployee->level)
                                                                        ->where('employeetype', '=', 'Non-Teaching')
                                                                        ->select('people.id')
                                                                        ->get()->count();
                                                                ?>
                                                                {{ number_format($total_nt_count, 0) }} 
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                            $male_nt_subt = $male_nt_subt + $male_nt_count; 
                                                            $female_nt_subt = $female_nt_subt + $female_nt_count; 
                                                            $total_nt_subt = $total_nt_subt + $total_nt_count; 
                                                        ?>
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="4">No record found.</td</tr>
                                                @endif
                                                <tr>
                                                    <th>Subtotal</th>
                                                    <th class="text-right">{{ number_format($male_nt_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($female_nt_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($total_nt_subt, 0) }}</th>
                                                </tr>
                                                <tr class="bg-info">
                                                    <th>GRAND TOTAL</th>
                                                    <th class="text-right">{{ number_format($male_t_subt + $male_nt_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($female_t_subt + $female_nt_subt, 0) }}</th>
                                                    <th class="text-right">{{ number_format($total_t_subt + $total_nt_subt, 0) }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-report2" role="tabpanel" aria-labelledby="vert-tabs-report2-tab">
                                    <h5>Personnel Complement Report</h5>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-report3" role="tabpanel" aria-labelledby="vert-tabs-report3-tab">
                                    <h5>Report on Non-Plantilla</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.reports._tools')
        </div>
    </div>
</div>
@endsection
