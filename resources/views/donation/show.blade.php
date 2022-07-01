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
    <div class="row pt-5">
        <div class="col-lg-6 offset-lg-1 col-md-12" id="main">
            <div class="card mb-3 border-0">

                <img src="{{asset('storage/images/proyek/'.$proyek_batch->proyek->image)}}" alt="..."
                    class="img-fluid rounded">
                <div class="col-md-12">
                    <div class="card-body">

                        <h3 class="">{{$proyek_batch->proyek->name}} - Batch {{$proyek_batch->batch_no}}</h3>
                        <div class="row mt-3 mb-4">
                            
                            <div class="col-sm-6 col-12 pe-0">
                                <p class="text-muted mb-1 text-sm-end">
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center ">
                            <p class="float-left mb-2">Donasi berakhir <span class="fw-bold">
                                    {{$proyek_batch->daysLeft()}} </span>
                                hari lagi</p>
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
                                <h6 class="text-end"><span id="start_invest">{{$proyek_batch->proyek->proyek_owner->name}}</span></h6>
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
                                    @guest
                                    <a type="button" class="btn btn-success" id="donasinoLogin" href="{{route('login')}}">Mulai Donasi</a>
                                  
                                    @else
                                    <a type="button" class="btn btn-success" id="donasinoLogin" href="{{route('donation.amount',$proyek_batch->id)}}"
                                        >Mulai Donasi</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                        <!-- Modal  -->

                    </div>
                </div>
            </div>
        </div>
        @endif
       
        <div class="col-lg-6 offset-lg-1  col-md-12" style="word-wrap: break-word;">
            <h3 class="mt-4 mb-2">Cerita </h3>
   
        {!! $proyek_batch->proyek->description !!}

        </div>
        <div class="col-lg-6 offset-lg-1  col-md-12" style="word-wrap: break-word;">
            <h3 class="mt-4 mb-2">Doa dan Harapan Donatur</h3>

        </div>

        <div class="col-lg-6 offset-lg-1  col-md-12" style="word-wrap: break-word;">
            <h3 class="mt-4 mb-2">Donasi</h3>
            
        </div>


    </div>
</div>

@endsection
@push('css')
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
    text-align: center;
}
</style>
@endpush
@push('js')


<script>
function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var footer_top = $("#footer").offset().top;
    var div_top = $('#container').offset().top + $('#container')
        .height();
    var div_height = $("#sticky-sidebar").height();

    var padding = 60;

    if (window_top + div_height > footer_top - padding) {
        $('#sticky-sidebar').css({
            top: (window_top + div_height - footer_top +
                padding) * -1
        });
    } else if (window_top > div_top) {
        $('#sticky-sidebar').addClass('stick');
        $('#sticky-sidebar').css({
            top: 70
        });
    } else {
        $('#sticky-sidebar').removeClass('stick');
        $('#sticky-sidebar').css({
            top: 70
        });

    }
}
$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@endpush