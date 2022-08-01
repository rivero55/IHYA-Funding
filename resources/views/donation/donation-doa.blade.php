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
            <h5 class="mt-2 mb-2">Doa dan Harapan #OrangBaik </h5>
            @foreach($user_donations_doa->sortByDesc('created_at')->take(5) as $donatur)
            <div class="card col-lg-12 mb-2" style="border-radius: 15px;">
                <div class="card-body pe-4 py-2 text-black">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{$donatur->user->getPhotoProfile()}}" alt="Generic placeholder image"
                                class="rounded-circle border border-dark border-3 me-1" height="50" width="50" alt=""
                                loading="lazy">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <p class="mb-0">{{$donatur ->donaturName()}}</p>
                            </div>

                            <div>
                                <p class="small mb-0 mb-0">{{$donatur ->waktuDonasi()}}</p>
                            </div>
                        </div>
                    </div>
                    <p class="small mt-2">{{$donatur -> message}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endsection