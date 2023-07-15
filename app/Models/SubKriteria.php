<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriterias';
    protected $fillable = ['nama', 'id_kategori', 'id_kriteria'];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
