<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatriksBerpasangan;
use Illuminate\Http\Request;

class MatriksBerpasanganController extends Controller
{
    public static function getDataMatriksBerpasangan($dataKriteria){
        $matriksBerpasangan = [];

        foreach ($dataKriteria as $indexA => $kriteriaA) {
            foreach ($dataKriteria as $indexB => $kriteriaB) {
                if ($indexA === $indexB) {
                    // Kriteria sama, beri nilai 1 (kriteria memiliki perbandingan sama terhadap dirinya sendiri)
                    $matriksBerpasangan[$indexB][$indexA] = 1;
                } else {
                    $nilaiPerbandingan = 1;

                    // Set nilai perbandingan kriteria A terhadap kriteria B
                    $matriksBerpasangan[$indexB][$indexA] = $nilaiPerbandingan;

                    // Set nilai perbandingan kebalikan (1/nilaiPerbandingan)
                    $matriksBerpasangan[$indexA][$indexB] = 1 / $nilaiPerbandingan;
                }
            }
        }

        return $matriksBerpasangan;
    }

    public function storeMatriksBerpasangan(Request $request)
    {
        $dataKriteria = Kriteria::all();

        // Reset data matriks berpasangan
        MatriksBerpasangan::truncate();

        $matriksBerpasangan = [];

        foreach ($dataKriteria as $indexA => $kriteriaA) {
            foreach ($dataKriteria as $indexB => $kriteriaB) {
                if ($indexA === $indexB) {
                    $nilaiPerbandingan = 1;
                } elseif ($indexA < $indexB) {
                    $inputName = 'matriks.' . $indexA . '.' . $indexB;
                    $nilaiPerbandingan = floatval($request->input($inputName));
                } else {
                    $nilaiPerbandingan = 1 / $matriksBerpasangan[$indexB][$indexA];
                }

                // Set nilai perbandingan kriteria A terhadap kriteria B
                $matriksBerpasangan[$indexA][$indexB] = $nilaiPerbandingan;

                // Set nilai perbandingan kebalikan (1/nilaiPerbandingan)
                $matriksBerpasangan[$indexB][$indexA] = ($nilaiPerbandingan != 0) ? 1 / $nilaiPerbandingan : 0;

                MatriksBerpasangan::create([
                    'kriteria_1' => $kriteriaA->nama,
                    'kriteria_2' => $kriteriaB->nama,
                    'nilai' => $nilaiPerbandingan,
                ]);
            }
        }

        return redirect()->route('kriteria.data')->with('success', 'Matriks berpasangan berhasil disimpan.');
    }
}
