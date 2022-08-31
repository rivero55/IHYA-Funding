@extends('layouts.landing')
@section('title', 'Kabar Terbaru')
@section('css')

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
<div class="container">
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
    <div class="row pt-3">
        <div class="col-lg-4 offset-4 card border col-md-12" style="word-wrap: break-word;">
            <h5 class="mt-2 mb-2">Kabar Terbaru </h5>
            @foreach($log_transaksi->sortByDesc('created_at') as $log_aktifitas)
                    <div class="card border-0 col-lg-12 mb-2" style="border-radius: 15px;">
                        <div class="card-body pe-4 py-2 text-black">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{$log_aktifitas->user->getPhotoProfile()}}" alt="Generic placeholder image"
                                        class="rounded-circle border border-dark me-1" height="35" width="35" alt=""
                                        loading="lazy">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="mb-0">{{$log_aktifitas->proyek_batch->proyek->proyek_owner->name}}</p>
                                    </div>

                                    <div>
                                        <p class="small mb-0 mb-0">{{$log_aktifitas->waktuTarikDana()}}</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-pendanaan mt-2"><span class="text-harga">Tarik Dana Sebesar : <span class="fw-bold">Rp 
                                        {{number_format($log_aktifitas->nominal,0,",",".")}}</span>
                            <p class="small mt-2">{!!$log_aktifitas ->description!!}</p>
                        <hr>

                        </div>
                    </div>
                    @endforeach
        </div>
    </div>
    @endsection