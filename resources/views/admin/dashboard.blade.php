@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header text-center font-weight-bold text-primary">{{ __('Dashboard') }}</div>

                <div class="card-body text-xs font-weight-bold text-primary text-uppercase h2 mb-1 text-center ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Selamat {{ Auth::user()->name }}, Anda Telah Berhasil Login!
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<!-- Content Row -->

    <div class="row justify-content-center" style="margin-right: 100 rem">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transactions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- //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 --}}
