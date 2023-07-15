<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksBerpasanganSubkriteria extends Model
{
    use HasFactory;

    protected $table = 'matriks_berpasangan_subkriteria';

    protected $fillable = [
        'subkriteria_1',
        'subkriteria_2',
        'nilai',
        'id_kriteria'
    ];
}
