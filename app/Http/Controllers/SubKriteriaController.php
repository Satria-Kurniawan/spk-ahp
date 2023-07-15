<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\MatriksBerpasanganSubkriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function getDataSubkriteria(){
        $dataKriteria = Kriteria::all();
        $dataSubkriteria = SubKriteria::with('kategori')->get();

        $matriksBerpasangan = MatriksBerpasanganSubkriteria::all();

        return view('admin.subkriteria.index', compact(
            'dataKriteria',
            'dataSubkriteria',
            'matriksBerpasangan'
        ));
    }

    public function createSubkriteria($idKriteria){
        $dataKategori = Kategori::all();
        $kriteria = Kriteria::findOrFail($idKriteria);

        return view('admin.subkriteria.create', compact('dataKategori', 'kriteria'));
    }

    public function storeSubkriteria(Request $req){
        $validatedData = $req->validate([
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_kriteria' => 'required',
        ]);

        SubKriteria::create($validatedData);

        return redirect()->route('subkriteria.data');
    }

    public function editSubkriteria($id){
        $subKriteria = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::where('id', $subKriteria->id_kriteria)->first();
        $dataKategori = Kategori::all();
        $selectedKategori = Kategori::where('id', $subKriteria->id_kategori)->first();

        return view('admin.subkriteria.edit', compact('subKriteria', 'kriteria', 'dataKategori', 'selectedKategori'));
    }

    public function updateSubkriteria(Request $req, $id){
        $subKriteria = SubKriteria::findOrFail($id);

        $validatedData = $req->validate([
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_kriteria' => 'required',
        ]);

        $subKriteria->update($validatedData);

        return redirect()->route('subkriteria.data')->with('success', "Berhasil memperbarui subkriteria.");
    }

    public function deleteSubkriteria($id){
        $subKriteria = SubKriteria::findOrFail($id);
        $matriksBerpasangan = MatriksBerpasanganSubkriteria::where(function ($query) use ($subKriteria) {
            $query->where('subkriteria_1', $subKriteria->nama)
                  ->orWhere('subkriteria_2', $subKriteria->nama);
        });

        $matriksBerpasangan->delete();
        $subKriteria->delete();

        return redirect()->route('subkriteria.data')->with('success', "Berhasil menghapus subkriteria.");
    }
}
