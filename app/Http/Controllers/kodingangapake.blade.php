{{-- protected function hitungMatriksPerbandingan($kriteria)
{
    $kriteriaCount = count($kriteria);
    $matriksPerbandingan = [];

    for ($i = 0; $i < $kriteriaCount; $i++) {
        $matriksPerbandingan[$i] = [];
        for ($j = 0; $j < $kriteriaCount; $j++) {
            $kriteria1 = $kriteria[$i];
            $kriteria2 = $kriteria[$j];
            // Misalnya, bobot perbandingan kriteria disimpan di dalam model PerbandinganKriteria
            $nilai = PerbandinganKriteria::where('kriteria_id_1', $kriteria1->id)
                ->where('kriteria_id_2', $kriteria2->id)
                ->value('nilai');
            $matriksPerbandingan[$i][$j] = $nilai;
        }
    }

    return $matriksPerbandingan;
}

protected function hitungMatriksNormalisasi($matriksPerbandingan)
{
    $kriteriaCount = count($matriksPerbandingan);
    $matriksNormalisasi = [];

    for ($i = 0; $i < $kriteriaCount; $i++) {
        $sum = array_sum($matriksPerbandingan[$i]);
        $matriksNormalisasi[$i] = [];
        for ($j = 0; $j < $kriteriaCount; $j++) {
            $matriksNormalisasi[$i][$j] = $matriksPerbandingan[$i][$j] / $sum;
        }
    }

    return $matriksNormalisasi;
}

protected function hitungVektorPrioritas($matriksNormalisasi)
{
    $kriteriaCount = count($matriksNormalisasi);
    $vektorPrioritas = [];

    for ($i = 0; $i < $kriteriaCount; $i++) {
        $sum = 0;
        for ($j = 0; $j < $kriteriaCount; $j++) {
            $sum += $matriksNormalisasi[$j][$i];
        }
        $vektorPrioritas[$i] = $sum / $kriteriaCount;
    }

    return $vektorPrioritas;
}

protected function hitungKonsistensiRatio($matriksPerbandingan, $vektorPrioritas)
{
    $kriteriaCount = count($matriksPerbandingan);
    $lambdaMax = 0;
    $ci = 0;
    $ri = [0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];

    // Menghitung nilai Lambda Max
    for ($i = 0; $i < $kriteriaCount; $i++) {
        $sum = 0;
        for ($j = 0; $j < $kriteriaCount; $j++) {
            $sum += $matriksPerbandingan[$i][$j] * $vektorPrioritas[$j];
        }
        $lambdaMax += $sum * $vektorPrioritas[$i];
    }

    // Menghitung Consistency Index (CI)
    $ci = ($lambdaMax - $kriteriaCount) / ($kriteriaCount - 1);

    // Menghitung Consistency Ratio (CR)
    $cr = $ci / $ri[$kriteriaCount - 1];

    return $cr;
} --}}
