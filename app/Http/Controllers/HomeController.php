<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Athlete;
use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layouts.master');
    }

    public function dashboard(){
        $jumlahKriteria = count(Kriteria::all());
        $jumlahKategori = count(Kategori::all());
        $jumlahSubkriteria = count(SubKriteria::all());
        $jumlahAlternatif = count(Alternatif::all());
        $jumlahAtlet = count(Athlete::all());

        return view('admin.dashboard.index', compact(
            'jumlahKriteria',
            'jumlahKategori',
            'jumlahSubkriteria',
            'jumlahAlternatif',
            'jumlahAtlet'
        ));
    }
}
