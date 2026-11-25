@extends('layouts.dashboard')

@section('title', 'Histori Akun')
@section('page-title', 'Histori Akun')
@section('page-description', 'Riwayat aktivitas pengguna di Kantin.ONE')

@section('dashboard-content')
    @section('page-actions')
        {{-- Summary --}}
        <div class="row row-cols-1 row-cols-md-4 g-2">
            <div class="col">
                <div class="card text-bg-dark h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Total Aktivitas</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $totalActivities }}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-bg-primary h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Hari Ini</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $todayActivities }}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-bg-info h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Aktivitas Login</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $loginActivities }}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-bg-success h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Aktivitas Pengguna</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $userActivities }}</h2>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    {{-- Tabel Histori Akun --}}
    <div class="table-responsive" id="activityLogsTableContainer">
        {!! $dataTable->table([
            'class' => 'table table-hover align-middle mb-0',
        ]) !!}
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush