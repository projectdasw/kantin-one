@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold">Pengelola Kantin Dashboard</h3>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}.</p>
    <p>Anda masuk sebagai Pengelola Kantin.</p>
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fa-solid fa-right-from-bracket me-2"></i>
        Logout
    </button>
</form>
</div>
@endsection
