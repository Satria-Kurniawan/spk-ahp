<?php

function hitungJumlahPerkolomMatriksBerpasangan($dataSubkriteria, $idKriteria, $matriksBerpasangan)
{
    $data = $dataSubkriteria->where('id_kriteria', $idKriteria);
    $matriks = $matriksBerpasangan->where('id_kriteria', $idKriteria);

    $jumlahKolom = count($dataSubkriteria);
    $jumlahPerKolom = array_fill(0, $jumlahKolom, 0);

    foreach ($matriks as $item) {
        $index = $data->search(function ($subkriteria) use ($item) {
            return $subkriteria->nama === $item->subkriteria_2;
        });

        $nilai = $item->nilai;
        $jumlahPerKolom[$index] += $nilai;
    }

    $jumlah = collect($jumlahPerKolom)->filter(function ($value) {
        return $value !== 0;
    });

    return $jumlah;
}

function hitungMatriksNilaiKriteria($dataSubkriteria, $idKriteria, $matriksBerpasangan, $jumlahPerKolom)
{
    $data = $dataSubkriteria->where('id_kriteria', $idKriteria);
    $matriks = $matriksBerpasangan->where('id_kriteria', $idKriteria);

    if (count($matriks) === 0) {
        return [
            'matriksNilaiKriteria' => [],
            'jumlahPerBaris' => [],
            'nilaiPrioritas' => [],
            'nilaiPrioritasSubkriteria' => []
        ];
    }

    $matriksNilaiKriteria = [];

    foreach ($matriks as $item) {
        $index = $data->search(function ($subkriteria) use ($item) {
            return $subkriteria->nama === $item->subkriteria_2;
        });

        $nilai = $item->nilai;
        $normalizedNilai = $nilai / $jumlahPerKolom[$index];

        $matriksNilaiKriteria[] = [
            'subkriteria_1' => $item->subkriteria_1,
            'subkriteria_2' => $item->subkriteria_2,
            'nilai' => $normalizedNilai,
        ];
    }

    // Mencari jumlah nilai perbaris pada matriks nilai kriteria
    $jumlahBaris = count($dataSubkriteria);
    $jumlahPerBaris = array_fill(0, $jumlahBaris, 0);

    foreach ($matriksNilaiKriteria as $item) {
        $index = $data->search(function ($subkriteria) use ($item) {
            return $subkriteria->nama === $item['subkriteria_1'];
        });

        $nilai = $item['nilai'];

        $jumlahPerBaris[$index] += $nilai;
    }

    $jumlahPerBaris = collect($jumlahPerBaris)->filter(function ($value) {
        return $value !== 0;
    })->values();

    // // Mencari nilai prioritas berdasarkan
    $nilaiPrioritas = [];
    $jumlahSubkriteria = count($data);

    foreach ($jumlahPerBaris as $index => $jumlah) {
        if ($jumlahSubkriteria !== 0) {
            $nilaiPriority = $jumlahPerBaris[$index] / $jumlahSubkriteria;
        } else {
            $nilaiPriority = 0;
        }

        $nilaiPrioritas[] = $nilaiPriority;
    }
    // End

    $nilaiPrioritasSubkriteria = [];
    $nilaiMax = max($nilaiPrioritas);

    foreach ($nilaiPrioritas as $value) {
        if ($nilaiMax !== 0) {
            $nilaiPrioritasSubkriteria[] = $value / $nilaiMax;
        } else {
            $nilaiPrioritasSubkriteria[] = 0;
        }
    }

    return compact(
        'matriksNilaiKriteria',
        'jumlahPerBaris',
        'nilaiPrioritas',
        'nilaiPrioritasSubkriteria'
    );
}

function hitungMatriksPenjumlahanTiapBaris($dataSubkriteria, $idKriteria, $matriksBerpasangan, $nilaiPrioritas)
{
    $dataSub = $dataSubkriteria->where('id_kriteria', $idKriteria)->values();
    $matriksBerp = $matriksBerpasangan->where('id_kriteria', $idKriteria)->values();

    if (count($dataSub) === 0 || count($matriksBerp) === 0 || count($nilaiPrioritas) === 0) {
        return [
            'matriksPenjumlahanTiapBaris' => [],
            'hasilPenjumlahanTiapBaris' => []
        ];
    }

    $size = count($dataSub);
    $matrix = array_fill(0, $size, array_fill(0, $size, 0));

    foreach ($matriksBerp as $data) {
        $row = array_search($data->subkriteria_1, array_column($dataSub->toArray(), 'nama'));
        $col = array_search($data->subkriteria_2, array_column($dataSub->toArray(), 'nama'));
        $matrix[$row][$col] = $data->nilai;
    }

    $matriksPenjumlahanTiapBaris = [];

    foreach ($matrix as $rowIndex => $row) {
        $resultRow = [];
        foreach ($row as $colIndex => $value) {
            if (isset($nilaiPrioritas[$colIndex])) {
                $resultRow[] = $value * $nilaiPrioritas[$colIndex];
            }
        }
        $matriksPenjumlahanTiapBaris[] = $resultRow;
    }

    $hasilPenjumlahanTiapBaris = [];

    foreach ($matriksPenjumlahanTiapBaris as $rowIndex => $row) {
        $hasil = 0;
        foreach ($row as $colIndex => $value) {
            $hasil += $value;
        }
        $hasilPenjumlahanTiapBaris[$rowIndex] = $hasil;
    }

    return compact(
        'matriksPenjumlahanTiapBaris',
        'hasilPenjumlahanTiapBaris'
    );
}

function hitungRasioKonsistensi($hasilPenjumlahanTiapBaris, $nilaiPrioritas, $dataSubkriteria, $jumlahPerKolom)
{

    if (count($hasilPenjumlahanTiapBaris) === 0 || count($nilaiPrioritas) === 0 || count($dataSubkriteria) === 0) {
        return [
            'hasilPenjumlahanRasioKonsistensi' => [],
            'totalHasilPenjumlahanRasioKonsistensi' => 0,
            'n' => 0,
            'lambdaMax' => 0,
            'CI' => 0,
            'CR' => 0,
            'keterangan' => ''
        ];
    }

    $hasilPenjumlahanRasioKonsistensi = [];

    foreach ($hasilPenjumlahanTiapBaris as $index => $value) {
        if (isset($nilaiPrioritas[$index])) {
            $hasil = $value + $nilaiPrioritas[$index];
            $hasilPenjumlahanRasioKonsistensi[$index] = $hasil;
        }
    }

    // dd($jumlahPerKolom, $nilaiPrioritas);

    $resultArray = array_map(function ($value1, $value2) {
        return $value1 * $value2;
    }, $jumlahPerKolom->toArray(), $nilaiPrioritas);

    // dd($resultArray);

    $lambdaMax = array_sum($resultArray);

    // Hasil perhitungan akhir
    $totalHasilPenjumlahanRasioKonsistensi = array_sum($hasilPenjumlahanRasioKonsistensi);
    $n = count($dataSubkriteria);
    // $lambdaMax = $totalHasilPenjumlahanRasioKonsistensi / $n;
    $CI = ($lambdaMax - $n) / ($n - 1);

    $nilaiIR = [
        1 => 0,
        2 => 0,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49
    ];

    $CR = $nilaiIR[$n] !== 0 ? $CI / $nilaiIR[$n] : 0;

    $keterangan = $CR <= 0.1 ? 'Konsisten' : 'Tidak Konsisten';
    // End

    return compact(
        'hasilPenjumlahanRasioKonsistensi',
        'totalHasilPenjumlahanRasioKonsistensi',
        'n',
        'lambdaMax',
        'CI',
        'CR',
        'keterangan'
    );
}
