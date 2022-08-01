@extends('layouts.landing')
@section('title', 'Donatur')
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
            <div class="card border-0">
                <div class="card-body pe-4 py-2 text-black">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{$proyek_owner->user->getPhotoProfile()}}" alt="Generic placeholder image"
                                class="rounded-circle  me-1" height="75" width="75" alt="" loading="lazy">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0"><span class="fw-bold" style="color:green;">{{$proyek_owner->name}}</span>
                            </p>
                            <div>
                                <p class="small mb-0 mb-0">Aktif sejak
                                    {{Carbon::parse($proyek_owner->created_at)->isoFormat('D MMMM Y')}}</p>
                            </div>
                        </div>

                    </div>
                    <hr class="mt-4">
                    <h6 class="text-black">Tentang Penggalang</h6>
                    <p>{!!$proyek_owner->description!!}</p>
                    <hr>
                    <h6 class="mt-2 mb-2">Proyek penggalangan dana</h6>
                    @foreach($penggalang_crowdfunding->sortByDesc('created_at') as $penggalang)
                    <div class="card col-lg-12 mb-2" style="border-radius: 15px;">
                        <div class="card-body pe-4 py-2 text-black">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{asset('storage/images/proyek/'.$penggalang->proyek->image)}}"
                                        alt="Generic placeholder image" class="me-1" height="50" width="75" alt=""
                                        loading="lazy">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="mb-0">{{$penggalang ->fullName()}}</p>
                                    </div>

                                    <div>
                                   
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center"
                                        id="landing-projek-paragraph">
                                        <p class="text-start mb-0 card-text ">
                                            Penggalang</p>
                                            <p class="text-end mb-0 card-text fw-bold">
                                            {{ $penggalang->proyek->proyek_owner->name}}</p>
                                    </div>
                                    <div class="progress mt-3">
                                        <div class="progress-bar"
                                            style="width:{{ $penggalang->totalPercentage() }}% ;background-color:#198754;"
                                            role="progressbar" aria-valuenow="{{ $penggalang->totalPercentage() }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center"
                                        id="landing-projek-paragraph">
                                        <p class="text-start mb-0">Terdanai</p>
                                        <p class="text-end mb-0">Tersisa</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        id="landing-projek-paragraph">
                                        <p class=""><span class="fw-bold">
                                                Rp {{number_format($penggalang->totalDonations(),0,",",".")}}</span>
                                        </p>
                                        <p class="text-muted mb-1">
                                            {{$daysleft=$penggalang->daysLeft() == 0 ? "Hari Terakhir" : (($penggalang->daysLeft() == "close") ? "Ditutup" : $penggalang->daysLeft().' Hari Lagi' )}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <a href="{{route('donation.show', $penggalang->id)}}" class="stretched-link"></a>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection