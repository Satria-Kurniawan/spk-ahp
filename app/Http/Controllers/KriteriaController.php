<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatriksBerpasangan;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function getDataKriteria()
    {
        $dataKriteria = Kriteria::all();
        $matriksBerpasangan = MatriksBerpasangan::all();

        // Menghitung jumlah nilai perkolom pada matriks berpasangan
        $jumlahPerKolom = PerhitunganController::hitungJumlahPerkolom($dataKriteria, $matriksBerpasangan);
        // dd($jumlahPerKolom);
        // End

        // Menghitung matriks nilai kriteria
        $resultMatriksNilaiKriteria = PerhitunganController::hitungMatriksNilaiKriteria($dataKriteria, $matriksBerpasangan, $jumlahPerKolom);
        $matriksNilaiKriteria = $resultMatriksNilaiKriteria['matriksNilaiKriteria'];
        $jumlahPerBaris = $resultMatriksNilaiKriteria['jumlahPerBaris'];
        $nilaiPrioritas = $resultMatriksNilaiKriteria['nilaiPrioritas'];
        // End

        $resultArray = array_map(function ($value1, $value2) {
            return $value1 * $value2;
        }, $jumlahPerKolom, $resultMatriksNilaiKriteria['nilaiPrioritas']);

        // dd($resultArray);

        $lambdaMax = array_sum($resultArray);

        // Mencari matriks penjumlahan tiap baris
        // Ubah data matriks berpasangan jadi matriks 2 dimensi
        $size = count($dataKriteria);
        $matrix = array_fill(0, $size, array_fill(0, $size, 0));

        foreach ($matriksBerpasangan as $data) {
            $row = array_search($data->kriteria_1, array_column($dataKriteria->toArray(), 'nama'));
            $col = array_search($data->kriteria_2, array_column($dataKriteria->toArray(), 'nama'));
            $matrix[$row][$col] = $data->nilai;
        }

        $matriksPenjumlahanTiapBaris = [];

        foreach ($matrix as $rowIndex => $row) {
            $resultRow = [];
            foreach ($row as $colIndex => $value) {
                $resultRow[] = $value * $nilaiPrioritas[$colIndex];
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
        // End

        // Menghitung Rasio Konsistensi
        $hasilPenjumlahanRasioKonsistensi = [];

        foreach ($hasilPenjumlahanTiapBaris as $index => $value) {
            $hasil = $value + $nilaiPrioritas[$index];
            $hasilPenjumlahanRasioKonsistensi[$index] = $hasil;
        }
        // End

        // Hasil perhitungan akhir
        $totalHasilPenjumlahanRasioKonsistensi = array_sum($hasilPenjumlahanRasioKonsistensi);
        $n = count($dataKriteria);

        if ($n === 0 || $n === 1 || count($matriksBerpasangan) === 0) {
            $lambdaMax = 0;
            $CI = 0;
            $CR = 0;
            $keterangan = '';
        } else {
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

            $CR = $n !== 2 ? $CI / $nilaiIR[$n] : 0;

            $keterangan = $CR <= 0.1 ? 'Konsisten' : 'Tidak Konsisten';
        }
        // End

        return view('admin.kriteria.index', compact(
            'dataKriteria',
            'matriksBerpasangan',
            'jumlahPerKolom',
            'matriksNilaiKriteria',
            'jumlahPerBaris',
            'nilaiPrioritas',
            'matriksPenjumlahanTiapBaris',
            'hasilPenjumlahanTiapBaris',
            'hasilPenjumlahanRasioKonsistensi',
            'totalHasilPenjumlahanRasioKonsistensi',
            'n',
            'lambdaMax',
            'CI',
            'CR',
            'keterangan'
        ));
    }

    public function createKriteria()
    {
        return view('admin.kriteria.create');
    }

    public function storeKriteria(Request $req)
    {
        $validatedData = $req->validate([
            'nama' => 'required'
        ]);

        Kriteria::create($validatedData);

        return redirect()->route('kriteria.data')->with('success', "Berhasil menambahkan kriteria.");
    }

    public function editKriteria($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function updateKriteria(Request $req, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $validatedData = $req->validate([
            'nama' => 'required'
        ]);

        $kriteria->update($validatedData);

        return redirect()->route('kriteria.data')->with('success', "Berhasil memperbarui kriteria.");
    }

    public function deleteKriteria($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $matriksBerpasangan = MatriksBerpasangan::where(function ($query) use ($kriteria) {
            $query->where('kriteria_1', $kriteria->nama)
                ->orWhere('kriteria_2', $kriteria->nama);
        });

        $matriksBerpasangan->delete();
        $kriteria->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus kriteria.');
    }
}
