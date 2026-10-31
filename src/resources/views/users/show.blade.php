
@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-description', 'Informasi lengkap akun pengguna Kantin.ONE.')

@section('dashboard-content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Detail Pengguna</h4>
                <p class="text-muted mb-0">
                    Informasi lengkap akun pengguna.
                </p>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row g-4">

            {{-- User Information --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Informasi Pengguna</h5>
                    </div>

                    <div class="card-body px-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Nama Lengkap</div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Username</div>
                                <div class="fw-semibold">{{ $user->username }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Email</div>
                                <div class="fw-semibold">{{ $user->email ?: '—' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Role</div>
                                <span class="badge bg-info-subtle text-info">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Status Akun</div>

                                @if ($user->is_active)
                                    <span class="badge bg-success-subtle text-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Email Terverifikasi</div>
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success-subtle text-success">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Tanggal Dibuat</div>
                                <div class="fw-semibold">
                                    {{ $user->created_at?->format('d M Y, H:i') ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Terakhir Diperbarui</div>
                                <div class="fw-semibold">
                                    {{ $user->updated_at?->format('d M Y, H:i') ?? '—' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Actions --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Aksi Pengguna</h5>
                    </div>

                    <div class="card-body px-4 pb-4">

                        <a href="{{ route('users.edit', $user) }}"
                           class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-edit me-2"></i>Edit Pengguna
                        </a>

                        @if ($user->id !== auth()->id())

                            <form action="{{ route('users.toggle-status', $user) }}"
                                  method="POST"
                                  class="status-form mb-2"
                                  data-name="{{ $user->name }}"
                                  data-active="{{ $user->is_active ? '1' : '0' }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} w-100">
                                    <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} me-2"></i>
                                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                                </button>
                            </form>

                            @if (!$user->is_active)
                                <form action="{{ route('users.destroy', $user) }}"
                                      method="POST"
                                      class="delete-user-form"
                                      data-name="{{ $user->name }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Hapus Akun
                                    </button>
                                </form>
                            @endif

                        @else
                            <div class="alert alert-light border small mb-0">
                                <i class="fas fa-info-circle text-primary me-1"></i>
                                Ini adalah akun yang sedang Anda gunakan.
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
