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
        <div class="col-lg-6 offset-lg-3 card border col-md-12" style="word-wrap: break-word;">
            <div class="card border-0">
                <div class="card-body pe-4 py-2 text-black">
                    <h5 class="mt-2 mb-2">Donasi saya</h5>

                    @foreach($user_donations->sortByDesc('created_at') as $donasi_user)
                    <div class="card border-0" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('storage/images/proyek/'.$donasi_user->proyek_batch->proyek->image)}}"
                                    alt="Generic placeholder image" class="me-1" height="125" width="150" alt=""
                                    loading="lazy">
                            </div>
                            <div class="flex-grow-1 ms-3 ">
                                <div class="d-flex flex-row align-items-center">
                                    <p class="mb-0">{{$donasi_user->proyek_batch->fullName()}}</p>
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-2"
                                    id="landing-projek-paragraph">
                                    <p class=""><span class="fw-bold">
                                            Rp {{number_format($donasi_user->nominal,0,",",".")}}</span>
                                    </p>
                                    <p class="text-muted mx-3">
                                        •
                                    </p>
                                    <p class="small mb-0 mb-0">
                                        {{Carbon::parse($donasi_user->created_at)->isoFormat('D MMMM Y')}}</p>
                                </div>
                            </div>
                            <div class="flex-grow-3 ms-3">
                                <div class="badge rounded-pill bg-{{($donasi_user->status == 'EXPIRED') ? 'danger' : (($donasi_user->status == 'PENDING') ? 'secondary' : 'success')}} ">
                                    <p class="mb-0">{{(($donasi_user->status == 'COMPLETED') ? 'Payout' : 'Payment')}} {{$donasi_user->status}}</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{$donasi_user->payment_url}}" class="stretched-link"></a>

                    </div>
                    <hr>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection