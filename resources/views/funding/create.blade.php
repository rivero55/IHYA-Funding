@extends('layouts.landing')
@section('title', 'Donasi')
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
    <form action="{{route('funding.store')}}" method="POST" enctype="multipart/form-data">
    <div class="row mt-2">
        <div class="col-6 offset-3 card">
            <div class="row py-3">
                <h5>Data Diri</h5>
                    @csrf
                    <div class="col-md-6 mb-2">
                        <label for="inputNama1" class="form-label">Nama Sesuai KTP</label>
                        <input type="text" class="form-control" id="inputNama1" name="nama_ktp" value="{{old('nama_ktp') ?? $user_profile->ktp_name ?? ''}}"{{!$user_profile ? '' : 'readonly'}}>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="inputKTP1" class="form-label">No. KTP</label>
                        <input type="tel" class="form-control" id="inputKTP1" name="no_ktp" value="{{old('no_ktp') ?? $user_profile->ktp_number ?? ''}}" {{!($user_profile) ? '' : 'readonly'}}>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="inputJob" class="form-label">Pekerjaan Kamu</label>
                        <input type="text" class="form-control" id="inputJob" name="job" value="{{old('job') ?? $user_profile->job ?? ''}}" {{!($user_profile) ? '' : 'readonly'}}>
                    </div>
                    <div class="col-md-6">
                        <label for="inputJobPlace" class="form-label">Tempat kerja</label>
                        <input type="tel" class="form-control" id="inputJobPlace" name="job_detail" value="{{old('job_detail') ?? $user_profile->job_detail ?? ''}}" {{!($user_profile) ? '' : 'readonly'}}>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Sosial Media kamu</label>
                    </div>
                    <div class="col-md-12 mb-2">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="social_media" id="inlineRadio1"
                                value="Instagram" {{  (old('social_media') == 'Instagram') ? 'checked' : (($user_profile->social_media ?? '') == 'Instagram'  ? 'checked' : ((empty($user_profile->social_media)) ? '' :  'disabled'))}}>
                            <label class="form-check-label" for="inlineRadio1">Instagram</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="social_media" id="inlineRadio2"
                                value="Twitter" {{  (old('social_media') == 'Twitter') ? 'checked' : (($user_profile->social_media  ?? '')== 'Twitter'  ? 'checked' : ((empty($user_profile->social_media)) ? '' :  'disabled'))}}>
                            <label class="form-check-label" for="inlineRadio2">Twitter</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="social_media" id="inlineRadio3"
                                value="LinkedIn" {{  (old('social_media') == 'LinkedIn') ? 'checked' : (($user_profile->social_media  ?? '')== 'LinkedIn'  ? 'checked' : ((empty($user_profile->social_media)) ? '' :  'disabled'))}}>
                            <label class="form-check-label" for="inlineRadio3">LinkedIn</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="social_media" id="inlineRadio4"
                                value="Facebook" {{  (old('social_media') == 'Facebook') ? 'checked' : (($user_profile->social_media  ?? '')== 'Facebook'  ? 'checked' : ((empty($user_profile->social_media)) ? '' :  'disabled'))}}>
                            <label class="form-check-label" for="inlineRadio4">Facebook</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="inputSocialMedia" class="form-label">Link Sosial Media mu</label>
                        <input type="text" class="form-control" name="social_media_link" id="inputSocialMedia" value="{{old('social_media_link') ?? $user_profile->social_link ?? ''}}" {{!($user_profile) ? '' : 'readonly'}}>
                    </div>

            </div>
            <hr>
            <div class="row py-3">
                <h5>Proyek Penggalangan Dana</h5>
                <div class="col-md-8 mb-2">
                    <label for="inputNamaProyek" class="form-label">Beri judul untuk galang dana ini</label>
                    <input type="text" class="form-control" id="inputNamaProyek" name="proyek_name" value="{{old('proyek_name')}}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="proyek_type">Kategori Proyek</label>
                    <select class="form-select mt-2" id="proyek_type" name="proyek_type">
                        <option value="0" selected disabled>Pilih Kategori Proyek</option>
                        @foreach ($proyek_types as $proyek_type)
                        <option value="{{ $proyek_type->name}}" {{old('proyek_type') == $proyek_type->name  ? 'selected' : ''}}>{{ $proyek_type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="inputPassword4" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" name="location" id="inputPassword4" value="{{old('location')}}">
                </div>
                <div class="mb-3 col-md-12 mb-2">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Penggalang
                        Dana</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="tujuan_penggalang" rows="3"
                        placeholder="Kami merupakan lembaga amil zakat yang bergerak dalam penghimpunan dana Zakat, infaq, sedekah, kemanusiaan, dan CSR perusahaan" >{{old('tujuan_penggalang') ??$proyek_owners->description ?? ''}}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="image">Upload Foto Penggalangan Dana</label>
                    <input type="file" class="form-control mt-2" name="image" id="image" accept="image/*">
                </div>
                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3">{!! old('description') !!}</textarea>
                    </div>
                </div>
                <hr class="mt-3">
                <h5>Proyek Batch</h5>

                <div class="row">
                        <div class="form-group col-md-6">
                            <label for="batch_no">Batch ke-</label>
                            <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                                value="{{old('batch_no') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="minimum_fund">Minimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                    value="{{ old('minimum_fund') ?? 10000}}" readonly>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="maximum_fund">Maksimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                    value="{{ old('maximum_fund') }}">
                            </div>
                            <small class="form-text text-muted">Opsional</small>


                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Target Total Donasi </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_nominal" id="target_nominal"
                                    min=1 value="{{ old('target_nominal') }}">
                            </div>

                        </div>
                    </div>
                    

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Tanggal Pelaksanaan Proyek</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ old('start_date') }}" placeholder="3" min="{{date('Y-m-d')}}">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="date" class="form-control" name="end_date" id="end_date" 
                                    value="{{ old('end_date') }}" placeholder="7" min="{{date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <button type="submit" class="btn btn-success d-block my-2 w-100">Buat Proyek Pendanaan</button>

            </div>
        </div>
    </div>
</form>
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