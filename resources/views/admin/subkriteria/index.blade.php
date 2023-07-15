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
    @foreach ($dataKriteria as $kriteria)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ url('/subkriteria/create/' . $kriteria->id) }}" class="btn btn-primary float-right">
                    <i class="fas fa-fw fa-plus-circle"></i>Tambah Data
                </a>
                <h5 class="m-0 font-weight-bold text-primary">{{ $kriteria->nama }} (C{{ $loop->index + 1 }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Subkriteria</th>
                                <th>Kategori</th>
                                <th width="50px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteria)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $subkriteria->nama }}</td>
                                    <td>{{ $subkriteria->kategori->nama }}</td>
                                    <td class="d-flex">
                                        <a href="{{ url('/subkriteria/edit/' . $subkriteria->id) }}">
                                            <i class="fas fa-fw fa-edit mr-1"></i></a>
                                        <a href="{{ url('/subkriteria/delete/' . $subkriteria->id) }}"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus subkriteria {{ $subkriteria->nama }}?')">
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
                <form method="POST" action="{{ url('/matriks-berpasangan-subkriteria/store/' . $kriteria->id) }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteria)
                                        <th>{{ $subkriteria->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $indexA => $subkriteriaA)
                                    <tr>
                                        <th>{{ $subkriteriaA->nama }}</th>
                                        @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $indexB => $subkriteriaB)
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
                                                                {{ $matriksBerpasangan->where('subkriteria_1', $subkriteriaA->nama)->where('subkriteria_2', $subkriteriaB->nama)->pluck('nilai')->first() == $option
                                                                    ? 'selected'
                                                                    : '' }}>
                                                                {{ $option }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    @php
                                                        $nilaiPerbandingan = $matriksBerpasangan
                                                            ->where('subkriteria_1', $subkriteriaA->nama)
                                                            ->where('subkriteria_2', $subkriteriaB->nama)
                                                            ->pluck('nilai')
                                                            ->first();
                                                    @endphp
                                                    {{ $nilaiPerbandingan ?? '' }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                @if (count($dataSubkriteria->where('id_kriteria', $kriteria->id)) !== 0)
                                    <tr>
                                        <th class="text-primary">Jumlah</th>
                                        @php
                                            $jumlahPerKolom = hitungJumlahPerkolomMatriksBerpasangan($dataSubkriteria, $kriteria->id, $matriksBerpasangan);
                                        @endphp
                                        @foreach ($jumlahPerKolom as $jumlah)
                                            <td class="text-primary">{{ $jumlah }}</td>
                                        @endforeach
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Matriks Berpasangan</button>
                    </div>
                </form>
            </div>
        </div>

        @php
            if (count($dataSubkriteria->where('id_kriteria', $kriteria->id)) !== 0) {
                $result = hitungMatriksNilaiKriteria($dataSubkriteria, $kriteria->id, $matriksBerpasangan, $jumlahPerKolom);
                $matriksNilaiKriteria = $result['matriksNilaiKriteria'];
                $jumlahPerBaris = $result['jumlahPerBaris'];
                $nilaiPrioritas = $result['nilaiPrioritas'];
                $nilaiPrioritasSubkriteria = $result['nilaiPrioritasSubkriteria'];
            
                $result2 = hitungMatriksPenjumlahanTiapBaris($dataSubkriteria, $kriteria->id, $matriksBerpasangan, $nilaiPrioritas);
                $matriksPenjumlahanTiapBaris = $result2['matriksPenjumlahanTiapBaris'];
                $hasilPenjumlahanTiapBaris = $result2['hasilPenjumlahanTiapBaris'];
            
                $dataSubK = $dataSubkriteria->where('id_kriteria', $kriteria->id)->values();
            
                $result3 = hitungRasioKonsistensi($hasilPenjumlahanTiapBaris, $nilaiPrioritas, $dataSubK);
                $hasilPenjumlahanRasioKonsistensi = $result3['hasilPenjumlahanRasioKonsistensi'];
                $totalHasilPenjumlahanRasioKonsistensi = $result3['totalHasilPenjumlahanRasioKonsistensi'];
                $n = $result3['n'];
                $lambdaMax = $result3['lambdaMax'];
                $CI = $result3['CI'];
                $CR = $result3['CR'];
                $keterangan = $result3['keterangan'];
            } else {
                $matriksPenjumlahanTiapBaris = [];
                $dataSubK = [];
                $totalHasilPenjumlahanRasioKonsistensi = 0;
                $n = 0;
                $lambdaMax = 0;
                $CI = 0;
                $CR = 0;
                $keterangan = '';
            }
        @endphp

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
                                @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteria)
                                    <th>{{ $subkriteria->nama }}</th>
                                @endforeach
                                <th>Jumlah</th>
                                <th>Prioritas</th>
                                <th>Prioritas Subkriteria</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteriaA)
                                <tr>
                                    <th>{{ $subkriteriaA->nama }}</th>
                                    @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteriaB)
                                        <td>

                                            @php
                                                $nilaiNormalisasi = collect($matriksNilaiKriteria)
                                                    ->where('subkriteria_1', $subkriteriaA->nama)
                                                    ->where('subkriteria_2', $subkriteriaB->nama)
                                                    ->pluck('nilai')
                                                    ->first();
                                            @endphp
                                            {{ $nilaiNormalisasi }}
                                        </td>
                                    @endforeach

                                    <td>{{ $jumlahPerBaris[$loop->index] ?? 0 }}</td>
                                    <td>{{ $nilaiPrioritas[$loop->index] ?? 0 }}</td>
                                    <td>{{ $nilaiPrioritasSubkriteria[$loop->index] ?? 0 }}</td>
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
                                @foreach ($dataSubkriteria->where('id_kriteria', $kriteria->id) as $subkriteria)
                                    <th>{{ $subkriteria->nama }}</th>
                                @endforeach
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matriksPenjumlahanTiapBaris as $row)
                                <tr>
                                    <th>{{ $dataSubK[$loop->index]->nama }}
                                    </th>
                                    @foreach ($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    <td>{{ $hasilPenjumlahanTiapBaris[$loop->index] ?? 0 }}</td>
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
                            @foreach ($dataSubK as $index => $subkriteria)
                                <tr>
                                    <th>{{ $subkriteria->nama }}</th>
                                    <td>{{ $hasilPenjumlahanTiapBaris[$index] ?? 0 }}</td>
                                    <td>{{ $nilaiPrioritas[$index] ?? 0 }}</td>
                                    <td>{{ $hasilPenjumlahanRasioKonsistensi[$index] ?? 0 }}</td>
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
                                <td>{{ $CR }} <span class="text-success">({{ $keterangan }})</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="p-2 w-100 h-25 bg-dark text-white mb-5">Batas</div>
    @endforeach
@endsection
