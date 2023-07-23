<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\MatriksBerpasangan;
use App\Models\MatriksBerpasanganSubkriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function getDataPerhitungan(){
        // MATRIKS NILAI PRIORITAS KRITERIA
        $dataKriteria = Kriteria::all();
        $matriksBerpasangan = MatriksBerpasangan::all();

        $jumlahPerKolom = $this->hitungJumlahPerkolom($dataKriteria, $matriksBerpasangan);
        $resultMatriksNilaiKriteria = $this->hitungMatriksNilaiKriteria($dataKriteria, $matriksBerpasangan, $jumlahPerKolom);
        $nilaiPrioritas = $resultMatriksNilaiKriteria['nilaiPrioritas'];
        // END

        $dataKategori = Kategori::all();

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

        // dd($matriksNilaiPrioritasSubkriteria);


        $newMatriksNilaiPrioritasSubkriteria = [];

        foreach ($matriksNilaiPrioritasSubkriteria as $kriteria => $nilaiSubkriteria) {
            // Jika key memiliki dua kata, ganti spasi dengan underscore
            $key = str_replace(' ', '_', $kriteria);
            $newMatriksNilaiPrioritasSubkriteria[$key] = $nilaiSubkriteria;
        }

        // PERHITUNGAN ALTERNATIF
        $dataAlternatif = Alternatif::all();

        // dd($newMatriksNilaiPrioritasSubkriteria, $dataAlternatif->toArray());

        $hasil = [];

        foreach ($dataAlternatif as $alternatif) {
            $nilaiSubkriteria = [];

            foreach ($alternatif['data'] as $kriteria => $nilaiKriteria) {
                $nilaiSubkriteria[$kriteria] = $newMatriksNilaiPrioritasSubkriteria[$kriteria][$nilaiKriteria];
            }

            $hasil[] = $nilaiSubkriteria;
        }

        $hasilAkhir = [];

        foreach ($hasil as $indexA => $data) {
            $hasilKriteria = [];

            $dataValues = array_values($data);

            foreach ($dataValues as $indexB => $nilai) {
                $hasilKriteria[$indexB] = $nilai * $nilaiPrioritas[$indexB];
            }

            $hasilAkhir[] = $hasilKriteria;
        }

        $hasilPerankingan = [];
        $totalNilai = [];

        foreach ($hasilAkhir as $indexA => $data) {
            $total = 0;

            foreach ($data as $indexB => $value) {
                $total += $value;
            }

            $totalNilai[] = $total;

            $hasilPerankingan[] = [
                'alternatif' => $dataAlternatif[$indexA]->nama,
                'data' => $data,
                'total' => $total
            ];
        }

        usort($hasilPerankingan, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });
        // END

        return view('admin.perhitungan.index', compact(
            'dataKriteria',
            'nilaiPrioritas',
            'dataKategori',
            'matriksNilaiPrioritasSubkriteria',
            'dataAlternatif',
            'hasilAkhir',
            'totalNilai',
            'hasilPerankingan',
        ));
    }

    public static function hitungJumlahPerkolom($dataKriteria, $matriksBerpasangan){
        $jumlahKolom = count($dataKriteria);
        $jumlahPerKolom = array_fill(0, $jumlahKolom, 0);

        foreach ($matriksBerpasangan as $item) {
            $index = $dataKriteria->search(function ($kriteria) use ($item) {
                return $kriteria->nama === $item->kriteria_2;
            });

            $nilai = $item->nilai;
            $jumlahPerKolom[$index] += $nilai;
        }

        return $jumlahPerKolom;
    }

    public static function hitungMatriksNilaiKriteria($dataKriteria, $matriksBerpasangan, $jumlahPerKolom){
        // Mencari matriks nilai kriteria
        $matriksNilaiKriteria = [];

        foreach ($matriksBerpasangan as $item) {
            $index = $dataKriteria->search(function ($kriteria) use ($item) {
                return $kriteria->nama === $item->kriteria_2;
            });

            $nilai = $item->nilai;
            $normalizedNilai = $nilai / $jumlahPerKolom[$index];

            $matriksNilaiKriteria[] = [
                'kriteria_1' => $item->kriteria_1,
                'kriteria_2' => $item->kriteria_2,
                'nilai' => $normalizedNilai,
            ];
        }
        // Mencari jumlah nilai perbaris pada matriks nilai kriteria
        $jumlahBaris = count($dataKriteria);
        $jumlahPerBaris = array_fill(0, $jumlahBaris, 0);

        foreach ($matriksNilaiKriteria as $item) {
            $index = $dataKriteria->search(function ($kriteria) use ($item) {
                return $kriteria->nama === $item['kriteria_1'];
            });

            $nilai = $item['nilai'];
            $jumlahPerBaris[$index] += $nilai;
        }

        // Mencari nilai prioritas
        $nilaiPrioritas = [];
        $jumlahKriteria = count($dataKriteria);

        foreach ($jumlahPerBaris as $index => $jumlah) {
            $nilaiPriority = $jumlahPerBaris[$index] / $jumlahKriteria;

            $nilaiPrioritas[] = $nilaiPriority;
        }

        return [
            'matriksNilaiKriteria' => $matriksNilaiKriteria,
            'jumlahPerBaris' => $jumlahPerBaris,
            'nilaiPrioritas' => $nilaiPrioritas
        ];
    }

    public static function hitungNilaiRekomendasi(){
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

        // dd($matriksNilaiPrioritasSubkriteria);


        $newMatriksNilaiPrioritasSubkriteria = [];

        foreach ($matriksNilaiPrioritasSubkriteria as $kriteria => $nilaiSubkriteria) {
            // Jika key memiliki dua kata, ganti spasi dengan underscore
            $key = str_replace(' ', '_', $kriteria);
            $newMatriksNilaiPrioritasSubkriteria[$key] = $nilaiSubkriteria;
        }

        // PERHITUNGAN ALTERNATIF
        $dataAlternatif = Alternatif::all();

        // dd($newMatriksNilaiPrioritasSubkriteria, $dataAlternatif->toArray());

        $hasil = [];

        foreach ($dataAlternatif as $alternatif) {
            $nilaiSubkriteria = [];

            foreach ($alternatif['data'] as $kriteria => $nilaiKriteria) {
                $nilaiSubkriteria[$kriteria] = $newMatriksNilaiPrioritasSubkriteria[$kriteria][$nilaiKriteria];
            }

            $hasil[] = $nilaiSubkriteria;
        }

        $hasilAkhir = [];

        foreach ($hasil as $indexA => $data) {
            $hasilKriteria = [];

            $dataValues = array_values($data);

            foreach ($dataValues as $indexB => $nilai) {
                $hasilKriteria[$indexB] = $nilai * $nilaiPrioritas[$indexB];
            }

            $hasilAkhir[] = $hasilKriteria;
        }

        $totalNilai = [];

        foreach ($hasilAkhir as $indexA => $data) {
            $total = 0;

            foreach ($data as $indexB => $value) {
                $total += $value;
            }

            $totalNilai[] = $total;
        }

        return $totalNilai;
    }
}
