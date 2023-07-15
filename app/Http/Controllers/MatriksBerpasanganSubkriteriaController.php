<?php

namespace App\Http\Controllers;

use App\Models\MatriksBerpasanganSubkriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class MatriksBerpasanganSubkriteriaController extends Controller
{
    public function storeMatriksBerpasanganSubkriteria(Request $request, $idKriteria)
    {
        $dataSubkriteria = SubKriteria::all();

        // Reset data matriks berpasangan
        MatriksBerpasanganSubkriteria::where('id_kriteria', $idKriteria)->delete();

        $matriksBerpasangan = [];

        foreach ($dataSubkriteria->where('id_kriteria', $idKriteria) as $indexA => $subkriteriaA) {
            foreach ($dataSubkriteria->where('id_kriteria', $idKriteria) as $indexB => $subkriteriaB) {
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

                MatriksBerpasanganSubkriteria::create([
                    'subkriteria_1' => $subkriteriaA->nama,
                    'subkriteria_2' => $subkriteriaB->nama,
                    'nilai' => $nilaiPerbandingan,
                    'id_kriteria' => $idKriteria
                ]);
            }
        }

        return redirect()->route('subkriteria.data')->with('success', 'Matriks berpasangan berhasil disimpan.');
    }
}
