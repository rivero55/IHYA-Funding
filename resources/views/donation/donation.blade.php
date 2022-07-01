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
        <div class="col-md-6 col-lg-3 col-12">
            <div class="card rounded-top h-100">
                <img class="card-img-top" src="{{ asset('storage/images/proyek/'.$data->proyek->image) }}"
                    alt="Card image cap">
                <div class="card-body  d-flex flex-column">
                    <h4 class="card-title">{{ $data->fullName()}}</h4>
                    <div class="mt-auto">
                        <p class="card-text">
                            {{ $data->proyek->proyek_owner->name}}</p>
                        <p class=""><span class="text-pendanaan mt-2"> 
                                 Rp {{number_format($data->totalDonations(),0,",",".")}}<span> Terdanai</span> 
                        </p>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width:{{ $data->totalPercentage() }}% ;background-color:#198754;" role="progressbar"
                                aria-valuenow="{{ $data->totalPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <a class="d-none" href="#"></a>
                        <div class="d-flex justify-content-between align-items-center" id="landing-projek-paragraph">
                            <p class="float-left mb-0">Ditutup Pada</p>
                            <p class="float-right mb-0">Tersisa</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" id="landing-projek-paragraph">
                            <p class="text-muted mb-1">
                                {{Carbon::parse($data->end_date)->isoFormat('D MMMM Y')}}</p>
                            <p class="text-muted mb-1">{{$data->daysLeft()}} hari lagi</p>
                        </div>
                    </div>

                        <a type="button" class="btn btn-outline-success mt-2" href="{{route('donation.show', $data->id)}}">Lihat Detail</a>
                        <button type="submit" class="btn btn-success mt-2 btn-block">Donasi</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection