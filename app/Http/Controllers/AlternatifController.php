<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function getDataAlternatif(){
        $dataKriteria = Kriteria::all();
        $dataAlternatif = Alternatif::all();

        return view('admin.alternatif.index', compact('dataKriteria', 'dataAlternatif'));
    }

    public function createAlternatif(){
        $dataKriteria = Kriteria::all();
        $dataSubkriteria = SubKriteria::all();

        return view('admin.alternatif.create', compact('dataKriteria', 'dataSubkriteria'));
    }

    public function storeAlternatif(Request $req){
        $data = $req->all();

        unset($data['_token']);
        unset($data['nama']);

        $data = array_map('strval', $data);

        $validatedData = $req->validate([
            'nama' => 'required|string'
        ]);

        Alternatif::create([
            'nama' => $validatedData['nama'],
            'data' => $data
        ]);

        return redirect()->route('alternatif.data')->with('success', "Berhasil menambahkan alternatif.");
    }

    public function editAlternatif($id){
        $alternatif = Alternatif::findOrFail($id);
        $dataKriteria = Kriteria::all();
        $dataSubkriteria = SubKriteria::all();

        return view('admin.alternatif.edit', compact('alternatif', 'dataKriteria', 'dataSubkriteria'));
    }

    public function updateAlternatif(Request $req, $id){
        $alternatif = Alternatif::findOrFail($id);

        $data = $req->all();

        unset($data['_token']);
        unset($data['nama']);

        $data = array_map('strval', $data);

        $validatedData = $req->validate([
            'nama' => 'required|string'
        ]);

        $alternatif->update([
            'nama' => $validatedData['nama'],
            'data' => $data
        ]);

        return redirect()->route('alternatif.data')->with('success', "Berhasil memperbarui alternatif.");
    }

    public function deleteAlternatif($id){
        $alternatif = Alternatif::findOrFail($id);

        $alternatif->delete();

        return redirect()->back()->with('success', "Berhasil menghapus alternatif.");
    }
}
