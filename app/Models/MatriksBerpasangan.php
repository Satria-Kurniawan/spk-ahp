<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksBerpasangan extends Model
{
    use HasFactory;

    protected $table = 'matriks_berpasangan';

    protected $fillable = [
        'kriteria_1',
        'kriteria_2',
        'nilai',
    ];
}
