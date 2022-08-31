@extends('layouts.landing')
@section('title', 'Donasi Detail')
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
    <div class="row pt-5">
        <div class="col-lg-6 offset-lg-1 col-md-12" id="main">
            <div class="card mb-3 border-0">

                <img src="{{asset('storage/images/proyek/'.$proyek_batch->proyek->image)}}" alt="..."
                    class="img-fluid rounded">
                <div class="col-md-12">
                    <div class="card-body">

                        <h3 class="text-black pb-5">{{$proyek_batch->proyek->name}} - Batch {{$proyek_batch->batch_no}}</h3>
                    

                        <div class="d-flex justify-content-between align-items-center ">
                            <p class="float-left mb-2">Donasi berakhir <span class="fw-bold">
                                    {{$daysleft=$proyek_batch->daysLeft() == 0 ? "Hari ini" : (($proyek_batch->daysLeft() == "close") ? "" : $proyek_batch->daysLeft().' Hari Lagi' )}}
                                </span>
                            </p>
                            <p class="float-right mb-2"><span class="fw-bold">{{$proyek_batch->countDonations()}}
                                </span>
                                <span id="text-low">Donasi</span>
                            </p>
                        </div>
                        <div class="progress my-1">
                            <div class="progress-bar"
                                style="width:{{ $proyek_batch->totalPercentage() }}%;background-color:#198754;"
                                role="progressbar" aria-valuenow="{{ $proyek_batch->totalPercentage() }}"
                                aria-valuemin="0" aria-valuemax="100">{{ $proyek_batch->totalPercentage() }}%
                            </div>
                        </div>
                        <div class="row align-items-center ">
                            <div class="col-sm-7 col-12">
                                <p class="text-pendanaan mt-2"><span class="text-harga">Rp
                                        {{number_format($proyek_batch->totalDonations(),0,",",".")}}</span>
                                    /<span class="fw-bold"> Rp
                                        {{number_format($proyek_batch->target_nominal,0,",",".")}}</span></p>
                            </div>
                            <h6 class="pt-5">Tanggal Proyek Donasi Mulai - Berakhir</h6>
                            <p>( {{Carbon::parse($proyek_batch->start_date)->isoFormat('D MMMM Y').' - '. Carbon::parse($proyek_batch->end_date)->isoFormat('D MMMM Y')}}
                                )</p>
                        </div>


                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body pe-4 py-2 text-black">
                    <h5 class="mb-3">Penggalang </h5>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{$proyek_batch->proyek->proyek_owner->user->getPhotoProfile()}}"
                                alt="Generic placeholder image" class="rounded-circle  me-1" height="50" width="50"
                                alt="" loading="lazy">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            {{$proyek_batch->proyek->proyek_owner->name}}
                        </div>
                    </div>
                    <a href="{{route('donation.penggalang', $proyek_batch->proyek->proyek_owner->id)}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="card border-0 my-3">
                <div class="card-body">
                    <h3 class="mb-3">Cerita </h3>

                    {!! $proyek_batch->proyek->description !!}

                </div>
            </div>
        </div>

        @if (!$proyek_batch->isFullyFunded())
        <div class="col-lg-4">
            <div class="sticky-custom" id="sticky-sidebar">
                <div class="card shadow" style="border-radius: 10px">
                    <div class="card-body">

                        <div class="row">
                            <h5 class="mt-4">Informasi Penggalang Dana</h5>

                        </div>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="start_invest" class="col-4 col-sm-6 col-form-label">Lembaga/Yayasan</label>
                            <div class="col-8 col-sm-6">
                                <h6 class="text-end"><span
                                        id="start_invest">{{$proyek_batch->proyek->proyek_owner->name}}</span></h6>
                            </div>
                        </div>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="start_invest" class="col-4 col-sm-4 col-form-label">Verified</label>
                            <div class="col-8 col-sm-8">
                                <h6 class="text-end"><span id="start_invest"><span class="badge rounded-pill bg-primary"
                                            style="background-color:#FF8200 !important"><i class="fas fa-star pe-1"
                                                style="color:white;"></i>Identitas Terverifikasi</span></span></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="start_invest" class="col-4 col-sm-4 col-form-label">Kategori</label>
                            <div class="col-8 col-sm-8">
                                <h6 class="text-end"><span id="start_invest">{{$proyek_batch->proyek->type}}</span></h6>
                            </div>
                        </div>

                        <div class="my-3 row">
                            <div class="col">
                                <div class="d-grid">

                                    <a type="button" class="btn btn-success" id="donasinoLogin"
                                        href="{{route('donation.amount',[$proyek_batch->proyek->id,$proyek_batch->id])}}">Donasi
                                        Sekarang!</a>
                                </div>
                            </div>
                        </div>
                        <!-- Modal  -->

                    </div>
                </div>
            </div>
        </div>
        @endif


    <div class="col-lg-6 offset-lg-1 col-md-12">
        <div class="mt-2" style="word-wrap: break-word;">
            <div class="card">
                <div class="card-body">
                    <h4 class="my-2">Doa dan Harapan Donatur</h4>
                    @foreach($user_donations_message->sortByDesc('created_at')->take(5) as $donasi_doa)
                    <div class="card border col-lg-12 mb-2" style="border-radius: 15px;">
                        <div class="card-body pe-4 py-2 text-black">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{$donasi_doa->user->getPhotoProfile()}}" alt="Generic placeholder image"
                                        class="rounded-circle border border-dark me-1" height="35" width="35" alt=""
                                        loading="lazy">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="mb-0">{{$donasi_doa ->donaturName()}}</p>
                                    </div>

                                    <div>
                                        <p class="small mb-0 mb-0">{{$donasi_doa ->waktuDonasi()}}</p>
                                    </div>
                                </div>
                            </div>
                            <p class="small mt-2">{{$donasi_doa -> message}}</p>
                        </div>
                    </div>
                    @endforeach
                    <a type="button" class="btn btn-success rounded-pill d-grid mt-3"
                        href="{{route('donation.doa',$proyek_batch->id)}}">more details</a>

                </div>
            </div>
        </div>


        <div class="mt-2" style="word-wrap: break-word;">
            <div class="card">
                <div class="card-body">
                    <h4 class="my-2">Donasi ({{$donatur}})</h4>
                    @foreach($user_donations->sortByDesc('created_at')->take(5) as $donatur)
                    <div class="card col-lg-12 mb-2" style="border-radius: 15px;">
                        <div class="card-body pe-4 py-2 text-black">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{$donatur->user->getPhotoProfile()}}" alt="Generic placeholder image"
                                        class="rounded-circle border border-dark border-3 me-1" height="50" width="50"
                                        alt="" loading="lazy">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="mb-0"><span class="fw-bold"
                                                style="color:green;">{{$donatur ->donaturName()}}</span></p>
                                    </div>
                                    <div>
                                        <p class="small mb-0"></i>Bersedekah sebesar <span class="fw-bold">Rp
                                                {{number_format($donatur->nominal,0,",",".")}}</p>
                                    </div>
                                    <div>
                                        <p class="small mb-0 mb-0">{{$donatur->waktuDonasi()}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                    <a type="button" class="btn btn-success rounded-pill d-grid mt-3"
                        href="{{route('donation.donatur',$proyek_batch->id)}}">more details</a>
                </div>
            </div>
        </div>

        <div class="mt-2" style="word-wrap: break-word;">
            <div class="card">
                <div class="card-body">
                    <h4 class="my-2">Kabar Terkini </h4>
                    @foreach($log_transaksi->sortByDesc('created_at')->take(5) as $log_aktifitas)
                    <div class="card border col-lg-12 mb-2" style="border-radius: 15px;">
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
                        </div>
                    </div>
                    @endforeach
                    <a type="button" class="btn btn-success rounded-pill d-grid mt-3"
                        href="{{route('donation.kabar-terbaru',$proyek_batch->id)}}">more details</a>

                </div>
            </div>
        </div>
    </div>
</div></div>

@endsection