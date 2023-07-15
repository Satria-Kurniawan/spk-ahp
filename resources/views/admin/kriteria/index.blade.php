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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('kriteria.create') }}" class="btn btn-primary float-right"><i
                    class="fas fa-fw fa-plus-circle"></i>Tambah Data</a>
            <h5 class="m-0 font-weight-bold text-primary">Kriteria</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th width="50px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKriteria as $kriteria)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>C{{ $loop->index + 1 }}</td>
                                <td>{{ $kriteria->nama }}</td>
                                <td class="d-flex">
                                    <a href="{{ url('/kriteria/edit/' . $kriteria->id) }}"><i
                                            class="fas fa-fw fa-edit mr-1"></i></a>
                                    <a href="{{ url('/kriteria/delete/' . $kriteria->id) }}"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria {{ $kriteria->nama }}?')">
                                        <i class="fas fa-fw fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Matriks Perbandingan Berpasangan</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('matriksBerpasangan.store') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                @foreach ($dataKriteria as $kriteria)
                                    <th>{{ $kriteria->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKriteria as $indexA => $kriteriaA)
                                <tr>
                                    <th>{{ $kriteriaA->nama }}</th>
                                    @foreach ($dataKriteria as $indexB => $kriteriaB)
                                        <td>
                                            @if ($indexA === $indexB)
                                                1
                                            @elseif ($indexA < $indexB)
                                                <select class="w-100"
                                                    name="matriks[{{ $indexA }}][{{ $indexB }}]">
                                                    @php
                                                        $options = range(1, 9);
                                                    @endphp
                                                    @foreach ($options as $option)
                                                        <option value="{{ $option }}"
                                                            {{ $matriksBerpasangan->where('kriteria_1', $kriteriaA->nama)->where('kriteria_2', $kriteriaB->nama)->pluck('nilai')->first() == $option
                                                                ? 'selected'
                                                                : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                @php
                                                    $nilaiPerbandingan = $matriksBerpasangan
                                                        ->where('kriteria_1', $kriteriaA->nama)
                                                        ->where('kriteria_2', $kriteriaB->nama)
                                                        ->pluck('nilai')
                                                        ->first();
                                                @endphp
                                                {{ $nilaiPerbandingan ?? '' }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                <th class="text-primary">Jumlah</th>
                                @foreach ($jumlahPerKolom as $jumlah)
                                    <td class="text-primary">{{ $jumlah }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Matriks Berpasangan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Matriks Nilai Kriteria (Normalisasi)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach ($dataKriteria as $kriteria)
                                <th>{{ $kriteria->nama }}</th>
                            @endforeach
                            <th>Jumlah</th>
                            <th>Prioritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKriteria as $kriteriaA)
                            <tr>
                                <th>{{ $kriteriaA->nama }}</th>
                                @foreach ($dataKriteria as $kriteriaB)
                                    <td>

                                        @php
                                            $nilaiNormalisasi = collect($matriksNilaiKriteria)
                                                ->where('kriteria_1', $kriteriaA->nama)
                                                ->where('kriteria_2', $kriteriaB->nama)
                                                ->pluck('nilai')
                                                ->first();
                                        @endphp
                                        {{ $nilaiNormalisasi }}
                                    </td>
                                @endforeach
                                <td>{{ $jumlahPerBaris[$loop->index] }}</td>
                                <td>{{ $nilaiPrioritas[$loop->index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Matriks Penjumlahan Tiap Baris</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach ($dataKriteria as $kriteria)
                                <th>{{ $kriteria->nama }}</th>
                            @endforeach
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matriksPenjumlahanTiapBaris as $row)
                            <tr>
                                <th>{{ $dataKriteria[$loop->index]->nama }}</th>
                                @foreach ($row as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                                <td>{{ $hasilPenjumlahanTiapBaris[$loop->index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Perhitungan Rasio Konsistensi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Jumlah per Baris</th>
                            <th>Prioritas</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKriteria as $index => $kriteria)
                            <tr>
                                <th>{{ $kriteria->nama }}</th>
                                <td>{{ $hasilPenjumlahanTiapBaris[$index] }}</td>
                                <td>{{ $nilaiPrioritas[$index] }}</td>
                                <td>{{ $hasilPenjumlahanRasioKonsistensi[$index] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Total</th>
                            <td>{{ $totalHasilPenjumlahanRasioKonsistensi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Hasil Perhitungan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $totalHasilPenjumlahanRasioKonsistensi }}</td>
                        </tr>
                        <tr>
                            <th>n</th>
                            <td>{{ $n }}</td>
                        </tr>
                        <tr>
                            <th>Lambda Max</th>
                            <td>{{ $lambdaMax }}</td>
                        </tr>
                        <tr>
                            <th>CI</th>
                            <td>{{ $CI }}</td>
                        </tr>
                        <tr>
                            <th>CR</th>
                            <td>{{ $CR }} ({{ $keterangan }})</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
