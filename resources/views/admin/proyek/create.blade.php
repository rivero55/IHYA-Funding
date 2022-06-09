@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Project</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Project</h1>
{{-- <p class="mb-4">Description</p> --}}
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                   
                </ul>
            </div>
            @endif
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="project_name">Nama Project</label>
                            <input type="text" class="form-control" name="project_name" id="project_name"
                                placeholder="ex: Peternakan Lele" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="project_owner">Project Owner</label>
                            <select class="form-control" id="project_owner" name="project_owner">
                                <option value="0" selected disabled>Pilih Pemilik Project</option>
                                
                                <option value=""></option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-3">
                            <label for="province">Provinsi</label>
                            <select class="form-control" id="province" name="province">
                                <option value="0" selected disabled>Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="district">Kabupaten/Kota</label>
                            <select class="form-control" id="district" name="district">
                                <option value="0" selected disabled>Pilih Kabupaten/Kota</option>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sub-district">Kecamatan</label>
                            <select class="form-control" id="sub-district" name="sub-district">
                                <option value="0" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="village">Kelurahan/Desa</label>
                            <select class="form-control" id="village" name="village">
                                <option value="0" selected disabled>Pilih Kelurahan/Desa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-3">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="type">
                                <option value="" selected disabled>Pilih Kategori</option>
                               
                                <option></option>
                               
                            </select>
                        </div>
                     
                        <div class="form-group col-md-3">
                            <label for="image">Gambar</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="prospektus">File Prospektus</label>
                            <input type="file" class="form-control" name="prospektus" id="prospektus"
                                accept="application/pdf">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3"></textarea>
                            <small class="form-text text-muted">Opsional</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('admin') }}">Cancel</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@endsection