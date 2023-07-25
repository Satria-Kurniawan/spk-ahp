@extends('layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Matriks Nilai Prioritas Kriteria</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th>Nilai Prioritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKriteria as $kriteria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>C{{ $loop->iteration }}</td>
                                <td>{{ $kriteria->nama }}</td>
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
            <h5 class="m-0 font-weight-bold text-primary">Matriks Nilai Prioritas Subkriteria</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            @foreach ($dataKriteria as $kriteria)
                                <th>{{ $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dataNilaiPrioritasSubkriteria = array_values($matriksNilaiPrioritasSubkriteria);
                            
                            foreach ($dataNilaiPrioritasSubkriteria as &$subArray) {
                                $subArray = array_values($subArray);
                            }
                            
                            // dd($matriksNilaiPrioritasSubkriteria);
                            
                        @endphp

                        @foreach ($dataNilaiPrioritasSubkriteria as $indexA => $item)
                            @if (isset($dataKategori[$loop->index]))
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dataKategori[$loop->index]->nama }}</td>
                                    @foreach ($dataNilaiPrioritasSubkriteria as $indexB => $value)
                                        <td>
                                            @isset($dataNilaiPrioritasSubkriteria[$indexB][$indexA])
                                                {{ $dataNilaiPrioritasSubkriteria[$indexB][$indexA] }}
                                            @endisset
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Data Hasil Akhir</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alternatif</th>
                            @foreach ($dataKriteria as $kriteria)
                                <th>{{ $kriteria->nama }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($hasilAkhir) }} --}}
                        @foreach ($hasilAkhir as $hasilNilaiKriteria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dataAlternatif[$loop->index]->nama }}</td>
                                @foreach ($hasilNilaiKriteria as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                                <td>{{ $totalNilai[$loop->index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Hasil Perankingan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            {{-- @foreach ($dataKriteria as $kriteria)
                                <th>{{ $kriteria->nama }}</th>
                            @endforeach --}}
                            <th>Total</th>
                            {{-- <th>Ranking</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilPerankingan as $hasil)
                            <tr>
                                <td>{{ $hasil['alternatif'] }}</td>
                                {{-- @foreach ($hasil['data'] as $value)
                                    <td>{{ $value }}</td>
                                @endforeach --}}
                                <td>{{ $hasil['total'] }}</td>
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
