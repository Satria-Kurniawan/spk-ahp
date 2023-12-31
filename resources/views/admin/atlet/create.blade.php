@extends('layouts.master')
@section('content')
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif

    @if (Session::has('rekomendasi'))
        <div class="alert alert-success text-" role="alert">
            Hasil Rekomendasi <span class="font-weight-bold">{{ Session('nama') }}</span> adalah
            <span class="font-weight-bold"> {{ Session('rekomendasi') }}</span>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Atlet</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('atlet.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Atlet</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama atlet..." />
                </div>
                <div class="row">
                    @foreach ($dataKriteria as $kriteria)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $kriteria->nama }}</label>
                                <select class="w-100" name="{{ $kriteria->nama }}">
                                    @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteria)
                                        <option value="{{ $subkriteria->nama }}">
                                            {{ $subkriteria->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Simpan Atlet</button>
                </div>
            </form>
        </div>
    </div>
@endsection
