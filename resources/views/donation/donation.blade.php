@extends('layouts.landing')
@section('title', 'Donasi')
@section('css')
<!-- CSS only -->

<style>
body {
    padding-top: 90px;
}

.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}
</style>
@endsection
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
@section ('content')
<div class="container">
    <h3 class="mb-5">Event Berbagi</h3>
    <div class="row">
        @foreach ($proyek_batch as $data)
        <div class="col-md-6 col-lg-3 col-12 mt-2">
            <div class="card rounded-top h-100">
                <img class="card-img-top" src="{{ asset('storage/images/proyek/'.$data->proyek->image) }}"
                    alt="Card image cap">
                <div class="card-body  d-flex flex-column">
                    <h5 class="card-title">{{ $data->fullName()}}</h5>
                    <div class="mt-auto">
                        
                            <div class="d-flex justify-content-between align-items-center mb-2" id="landing-projek-paragraph">
                            <p class="text-start mb-0">Penggalang</p>
                            <p class="text-end mb-0 card-text fw-bold">{{ $data->proyek->proyek_owner->name}}</p>
                        </div>
                        <p class=""><span class="fw-bold"> 
                                 Rp {{number_format($data->totalDonations(),0,",",".")}}</span>  Terdanai
                        </p>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width:{{ $data->totalPercentage() }}% ;background-color:#198754;" role="progressbar"
                                aria-valuenow="{{ $data->totalPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <a class="d-none" href="#"></a>
                        <div class="d-flex justify-content-between align-items-center" id="landing-projek-paragraph">
                            <p class="text-start mb-0">Ditutup Pada</p>
                            <p class="text-end mb-0">Tersisa</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" id="landing-projek-paragraph">
                            <p class="text-muted mb-1">
                                {{Carbon::parse($data->end_date)->isoFormat('D MMMM Y')}}</p>
                            <p class="text-muted mb-1">{{$daysleft=$data->daysLeft() == 0 ? "Hari Terakhir" : (($data->daysLeft() == "close") ? "Ditutup" : $data->daysLeft().' Hari Lagi' )}} </p>
                        </div>
                    </div>

                        @if ($data->isFullyFunded())
                        <a type="button" class="btn btn-outline-success mt-2" href="{{route('donation.show', $data->id)}}">Lihat Detail</a>
                        <a class="btn btn-secondary btn-block mt-2 " disabled>Donasi ditutup</a>
                        
                        
                        @else
                        <a type="button" class="btn btn-outline-success mt-2" href="{{route('donation.show', $data->id)}}">Lihat Detail</a>

                        <a type="submit" class="btn btn-success mt-2 btn-block" href="{{route('donation.amount',[$data->proyek->id,$data->id])}}">Donasi</a>
                        @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection