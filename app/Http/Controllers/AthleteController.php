<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Athlete;
use App\Models\Kriteria;
use App\Models\MatriksBerpasangan;
use App\Models\MatriksBerpasanganSubkriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function createAtlet()
    {
        $dataKriteria = Kriteria::all();
        $dataSubkriteria = SubKriteria::all();

        return view('admin.atlet.create', compact('dataKriteria', 'dataSubkriteria'));
    }

    public function storeAtlet(Request $req)
    {
        // INPUT
        $data = $req->all();

        unset($data['_token']);
        unset($data['nama']);

        $data = array_map('strval', $data);

        $validatedData = $req->validate([
            'nama' => 'required|string'
        ]);
        // END

        // MATRIKS NILAI PRIORITAS KRITERIA
        $dataKriteria = Kriteria::all();
        $matriksBerpasangan = MatriksBerpasangan::all();

        $jumlahPerKolom = PerhitunganController::hitungJumlahPerkolom($dataKriteria, $matriksBerpasangan);
        $resultMatriksNilaiKriteria = PerhitunganController::hitungMatriksNilaiKriteria($dataKriteria, $matriksBerpasangan, $jumlahPerKolom);
        $nilaiPrioritas = $resultMatriksNilaiKriteria['nilaiPrioritas'];
        // END

        //MATRIKS NILAI PRIORITAS SUBKRITERIA
        $dataSubkriteria = SubKriteria::all();
        $matriksBerpasanganSK = MatriksBerpasanganSubkriteria::all();

        $matriksNilaiPrioritasSubkriteria = [];

        foreach ($dataKriteria as $index => $kriteria) {
            $jumlahPerKolomSK = hitungJumlahPerkolomMatriksBerpasangan($dataSubkriteria, $kriteria->id, $matriksBerpasanganSK);
            $resultMatriksNilaiSubkriteria = hitungMatriksNilaiKriteria($dataSubkriteria, $kriteria->id, $matriksBerpasanganSK, $jumlahPerKolomSK);
            $nilaiPrioritasSubkriteria = $resultMatriksNilaiSubkriteria['nilaiPrioritasSubkriteria'];

            $keySubkriteria = $dataSubkriteria->where('id_kriteria', $kriteria->id)->values();

            $col = [];
            foreach ($nilaiPrioritasSubkriteria as $indexPS => $value) {
                $col[$keySubkriteria[$indexPS]->nama] = $value;
            }

            $matriksNilaiPrioritasSubkriteria[$kriteria->nama] = $col;
        }
        // END

        $newMatriksNilaiPrioritasSubkriteria = [];

        foreach ($matriksNilaiPrioritasSubkriteria as $kriteria => $nilaiSubkriteria) {
            // Jika key memiliki dua kata, ganti spasi dengan underscore
            $key = str_replace(' ', '_', $kriteria);
            $newMatriksNilaiPrioritasSubkriteria[$key] = $nilaiSubkriteria;
        }

        // PERHITUNGAN ATLET
        $nilaiSubkriteria = [];

        foreach ($data as $kriteria => $nilaiKriteria) {
            $nilaiSubkriteria[$kriteria] = $newMatriksNilaiPrioritasSubkriteria[$kriteria][$nilaiKriteria];
        }

        // dd($nilaiSubkriteria);

        $hasilKriteria = [];

        foreach (array_values($nilaiSubkriteria) as $index => $nilai) {
            $hasilKriteria[$index] = $nilai * $nilaiPrioritas[$index];
        }

        $total = 0;

        foreach ($hasilKriteria as $index => $value) {
            $total += $value;
        }

        $rekomendasi = "";

        $nilaiRekomendasi = PerhitunganController::hitungNilaiRekomendasi();

        if ($total >= $nilaiRekomendasi[0]) {
            $rekomendasi = "Atlet Utama";
        } else if ($total >= $nilaiRekomendasi[1]) {
            $rekomendasi = "Atlet Binaan";
        } else {
            $rekomendasi = "Atlet Pemula";
        }

        $athleteExists = Athlete::where('nama', $validatedData['nama'])->first();

        if ($athleteExists) {
            $athleteExists->update([
                'nama' => $validatedData['nama'],
                'data' => $data,
                'rekomendasi' => $rekomendasi
            ]);
        } else {
            Athlete::create([
                'nama' => $validatedData['nama'],
                'data' => $data,
                'rekomendasi' => $rekomendasi
            ]);
        }

        return redirect()->back()->with('nama', $req->input('nama'))->with('rekomendasi', $rekomendasi);
    }

    public function getDataRekapan()
    {
        $dataRekapan = Athlete::all();

        return view('admin.atlet.index', compact('dataRekapan'));
    }
}
