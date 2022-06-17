@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">proyek</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">proyek</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-body">
                <form action="{{ route('proyek.update', $proyek->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="proyek_name">Nama Proyek</label>
                            <input type="text" class="form-control" name="proyek_name" id="proyek_name"
                                placeholder="ex: Peternakan Lele" value="{{old('proyek_name') ?? $proyek->name}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="proyek_owner">Proyek Owner</label>
                            <select class="form-control" id="proyek_owner" name="proyek_owner">
                                <option value="0" selected disabled>Pilih Pemilik Proyek</option>
                                @foreach ($proyek_owners as $proyek_owner)
                                <option value="{{ $proyek_owner->id}}"
                                    {{$proyek->owner_id == $proyek_owner->id ? 'selected':''}}>
                                    {{ $proyek_owner->name }}</option>
                                @endforeach
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
                            <select class="form-control" id="village" name="location_code">
                                <option value="0" selected disabled>Pilih Kelurahan/Desa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-3">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="type">
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($proyek_types as $proyek_type)
                                <option {{$proyek->type == $proyek_type->name ? 'selected':''}}>
                                    {{$proyek_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label for="image">Gambar</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            <small class="form-text text-muted">Kosongkan jika tidak diubah</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3">{{ old('description') ?? $proyek->description }}</textarea>
                            <small class="form-text text-muted">Opsional</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('proyek.index') }}">Cancel</a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{asset('vendor/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
@endpush
@push('js')
{{-- Summernote --}}
<script src="{{asset('vendor/summernote/summernote-bs4.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        placeholder: 'Ketik disini..',
        height: 200
    });
});
</script>

{{-- Script region existing --}}
@include('admin.plugins.set-existing-region')
@if ( !empty(old('village')) || !empty($proyek->location_code))
<script>
set_region("{{ old('village') ?? $proyek->location_code }}");
</script>
@else
<script>
get_province();
</script>
@endif


{{-- Script Get Region --}}
@include('admin.plugins.get-region')

@endpush