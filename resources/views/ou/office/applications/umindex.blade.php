@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for the {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Applications</li>
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
            
            <div class="card card-outline card-primary" id="example1_wrapper">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="list" class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">Applicant</th>
                                    <th>Position applied for</th>                                  
                                    <th>Station</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->last_name }}, {{ $application->first_name }}
                                                <br>
                                                Code: {{ $application->application_code }}
                                            </td>
                                            @php 
                                                $vacancy =  App\Models\Vacancy2::find($application->vacancy_id);
                                            @endphp 
                                            <td>{{ $vacancy->position_title }} ({{ $vacancy->cycle }})</td>
                                            @php 
                                                $station =  App\Models\Station::find($application->station_id);
                                            @endphp 
                                            <td>{{ $station->code }}- {{ $station->name }}</td>
                                            @php 
                                                $assessment =  App\Models\Assessment::where('application_id', '=', $application->id)->get();
                                            @endphp 
                                            <td>
                                                @if($assessment->count() > 0 && $assessment->first()->status == -1)
                                                    Disqualified
                                                @elseif ($assessment->count() > 0 && $assessment->first()->status == 0)
                                                    New (School)
                                                @elseif ($assessment->count() > 0 && $assessment->first()->status == 1)
                                                    Pending (School)
                                                @elseif ($assessment->count() > 0 && $assessment->first()->status == 2)
                                                    Pending (District) 
                                                @elseif ($assessment->count() > 0 && $assessment->first()->status > 2)
                                                    Completed (District)
                                                @else 
                                                    New
                                                @endif

                                            </td>
                                            <td>
                                                {{ $assessment->count() == 0 ? 'Call up school' : '' }}
                                                <!--
                                                <a href="{{ route('ou.office.applications.umprocess', [$office, $cycle, $application->id]) }}" 
                                                    onclick="return confirm('This will revert completed status to PENDING status, particulary useful when modifying assessment after Mark Complete was executed. Are you sure?')"
                                                    class="btn btn-sm btn-warning {{ $assessment->first() != null ? ($assessment->first()->status < 2 || $assessment->first()->status == 3 ? 'disabled' : '') : 'disabled' }} " 
                                                    title="Revert to Pending">
                                                    <span class="fas fa-sign-out-alt fa-fw"></span> Revert to Pending (Station)
                                                </a>
                                                -->
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record was found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.office.applications._tools')
        </div>        
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
@stop

@section('plugins.Datatables', true)

@section('js')
    <script> console.log('Hi!'); </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        $(function () {
            $("#list").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50, 100, 1000, 2000, 3000, 4000, 5000], // You can customize these values
                "ordering": false, // Disable initial sorting
                "dom": 'Blfrtip', // Ensure the buttons are displayed
                "buttons": ["excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>


@stop
