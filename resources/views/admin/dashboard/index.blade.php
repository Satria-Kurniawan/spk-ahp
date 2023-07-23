@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-top-0 border-right-0 border-bottom-0 p-3 shadow-lg border-left-primary">
                <h2 class="text-primary">{{ $jumlahKriteria }}</h2>
                <h6>Kriteria</h6>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-top-0 border-right-0 border-bottom-0 p-3 shadow-lg border-left-primary">
                <h2 class="text-primary">{{ $jumlahKategori }}</h2>
                <h6>Kategori</h6>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-top-0 border-right-0 border-bottom-0 p-3 shadow-lg border-left-primary">
                <h2 class="text-primary">{{ $jumlahSubkriteria }}</h2>
                <h6>Subkriteria</h6>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-top-0 border-right-0 border-bottom-0 p-3 shadow-lg border-left-primary">
                <h2 class="text-primary">{{ $jumlahAlternatif }}</h2>
                <h6>Alternatif</h6>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-top-0 border-right-0 border-bottom-0 p-3 shadow-lg border-left-primary">
                <h2 class="text-primary">{{ $jumlahAtlet }}</h2>
                <h6>Atlet</h6>
            </div>
        </div>
    </div>
@endsection
