<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function getDataKategori(){
        $dataKategori = Kategori::all();

        return view('admin.kategori.index', compact('dataKategori'));
    }

    public function createKategori(){
        return view('admin.kategori.create');
    }

    public function storeKategori(Request $req){
        $validatedData = $req->validate([
            'nama' => 'required'
        ]);

        Kategori::create($validatedData);

        return redirect()->route('kategori.data')->with('success', "Kategori berhasil ditambahkan.");
    }

    public function editKategori($id){
        $kategori = Kategori::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function updateKategori(Request $req, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validatedData = $req->validate([
            'nama' => 'required'
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategori.data')->with('success', 'Kategori berhasil diperbarui');
    }

    public function deleteKategori($id){
        $kategori = Kategori::findOrFail($id);
        $subKriteriaFound = SubKriteria::where("id_kategori", $id)->count();

        if ($subKriteriaFound === 0) {
            $kategori->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Tidak dapat menghapus kategori karena terdapat sub kriteria terkait.']);
        }
    }
}
