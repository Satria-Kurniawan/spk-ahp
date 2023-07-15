@extends('layouts.master')
@section('content')
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary float-right"><i
                    class="fas fa-fw fa-plus-circle"></i>Tambah Data</a>
            <h5 class="m-0 font-weight-bold text-primary">Kategori</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th width="50px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKategori as $kategori)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td class="d-flex">
                                    <a href="{{ url('/kategori/edit/' . $kategori->id) }}"><i
                                            class="fas fa-fw fa-edit mr-1"></i></a>
                                    <a href="{{ url('/kategori/delete/' . $kategori->id) }}"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kategori->nama }}?')">
                                        <i class="fas fa-fw fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
