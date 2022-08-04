@extends('layouts.landing')
@section('title', 'edit funding batch')
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
use App\Models\Address;
@endphp
@push('css')
<style>
body {
    padding-top: 70px;
}
</style>
@endpush
<div class="container" id="container">
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
    <div class="row mt-2">
        <div class="col-6 offset-3 card">
            <form action="{{ route('funding.batch.update', [$funding_batch->proyek->id, $funding_batch->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row py-3">
                <h5>Proyek Penggalangan Dana</h5>
                <div class="col-md-8 mb-2">
                    <label for="inputNamaProyek" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="inputNamaProyek" name="proyek_name" value="{{old('proyek_name') ?? $funding_batch->proyek->name}}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="proyek_type">Kategori Proyek</label>
                    <select class="form-select mt-2" id="proyek_type" name="proyek_type">
                        <option value="0" selected disabled>Pilih Kategori Proyek</option>
                        @foreach ($proyek_types as $proyek_type)
                        <option value="{{ $proyek_type->name}}"}} selected>{{ $proyek_type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="inputPassword4" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" name="location" id="inputPassword4" value="{{old('location') ?? $funding_batch->proyek->location}}">
                </div>
             

                <div class="col-md-6">
                    <label for="image">Upload Foto Penggalangan Dana</label>
                    <input type="file" class="form-control mt-2" name="image" id="image" accept="image/*">
                </div>
                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description') ?? $funding_batch->proyek->description }}</textarea>
                    </div>
                </div>
                <hr class="mt-3">
                <h5>Proyek Batch</h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="batch_no">Batch ke-</label>
                        <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                            value="{{old('batch_no') ?? $funding_batch->batch_no }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group col-md-6">
                        <label for="minimum_fund">Minimal Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                value="{{ (old('minimum_fund') ?? $funding_batch->minimum_fund) ?? 10000}}" readonly>
                        </div>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="maximum_fund">Maksimal Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                value="{{ old('maximum_fund') ?? $funding_batch->maximum_fund }}">
                        </div>


                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <label for="target_nominal">Target Total Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="target_nominal" id="target_nominal" min=1
                                value="{{ old('target_nominal') ?? $funding_batch->target_nominal }}">
                        </div>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group col-md-8">
                        <label for="date">Tanggal Pelaksanaan Proyek</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ old('start_date') ?? (date('Y-m-d', strtotime($funding_batch->start_date))) }}"
                                placeholder="3" min="">
                            <span class="mx-3 align-center font-weight-bold">-</span>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ old('end_date') ?? (date('Y-m-d', strtotime($funding_batch->end_date)))}}"
                                placeholder="7">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success d-block my-2 w-100">Simpan</button>
            </form>

        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{asset('vendor/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
@endpush
@push('js')
<script src="{{asset('vendor/summernote/summernote-bs4.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        placeholder: 'Ketik disini..',
        height: 200
    });
});
</script>

@endpush