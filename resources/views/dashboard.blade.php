@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Dashboard</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total Animals</h6>
                        <h3>{{ $totalAnimals ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total Purchases</h6>
                        <h3>{{ $totalPurchases ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total Sales</h6>
                        <h3>{{ $totalSales ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total Spent</h6>
                        <h3>R$ {{ number_format($totalSpent ?? 0, 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
