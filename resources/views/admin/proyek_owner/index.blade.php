@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proyek Owner</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Proyek Owner</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{route('proyek-owner.create')}}"><i
                        class="fas fa-plus"></i> Tambah Data</a>
                <h6 class="m-0 font-weight-bold text-primary">List Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($proyek_owners as $proyek_owner)
                            <tr>
                                <td>{{ $proyek_owner->name }}</td>
                                <td>{!! $proyek_owner->description !!}</td>
                                <td class="text-center">
                                    <form action="{{ route('proyek-owner.destroy', $proyek_owner->id) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('proyek-owner.edit', $proyek_owner->id) }}"><i class="far fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




