@extends('layouts.landing')
@section('title', 'Crowdfunding Detail')
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
    @csrf
    <div class="row mt-2">
        <div class="col-6 offset-3 card">
            <img class="card-img-top my-2"
                src="{{ asset('storage/images/proyek/'.$funding_detail->proyek->image) }}" alt="Card image cap">

            <h3 class="text-black pb-2">{{$funding_detail->proyek->name}} - Batch {{$funding_detail->batch_no}}</h3>
            <div class="d-flex justify-content-between align-items-center ">
                <p class="float-left mb-2">Donasi berakhir <span class="fw-bold">
                        {{$daysleft=$funding_detail->daysLeft() == 0 ? "Hari ini" : (($funding_detail->daysLeft() == "close") ? "" : $funding_detail->daysLeft().' Hari Lagi' )}}
                    </span>
                </p>
                <p class="float-right mb-2"><span class="fw-bold">{{$funding_detail->countDonations()}}
                    </span>
                    <span id="text-low">Donasi</span>
                </p>
            </div>
            <div class="progress my-1">
                <div class="progress-bar"
                    style="width:{{ $funding_detail->totalPercentage() }}%;background-color:#198754;" role="progressbar"
                    aria-valuenow="{{ $funding_detail->totalPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $funding_detail->totalPercentage() }}%
                </div>
            </div>
            <div class="row align-items-center ">
                    <p class="text-pendanaan mt-2"><span class="text-harga">Total Donasi terkumpul Rp
                            {{number_format($funding_detail->totalDonations(),0,",",".")}}</span>
                        / <span class="fw-bold"> Rp
                            {{number_format($funding_detail->target_nominal,0,",",".")}}</span></p>
                <div class="d-flex justify-content-between align-items-center pt-4">

                    <p class="fw-bold">Tanggal Proyek Donasi Mulai - Berakhir</p>
                    <p>( {{Carbon::parse($funding_detail->start_date)->isoFormat('D MMMM Y').' - '. Carbon::parse($funding_detail->end_date)->isoFormat('D MMMM Y')}}
                        )</p>
                </div>

                    <p class=" pt-3">Status Proyek : <span class="fw-bold badge rounded-pill bg-{{($funding_detail->status == 'draft') ? 'secondary' : (($funding_detail->status == 'closed') ? 'warning' : 'success')}}">{{$funding_detail->status}}</span></p>
                    <p class="f">Status Verifikasi Proyek : <span class="fw-bold badge rounded-pill bg-{{($funding_detail->verification_status == 'rejected') ? 'danger' : (($funding_detail->verification_status == 'process') ? 'warning' : 'success')}}">{{$funding_detail->verification_status}}</span></p>
                    @if($funding_detail->verification_status == 'rejected')
                    <p>Feedback: <span class="fw-bold">{{$funding_detail->verification_feedback}}</span></p>
                    @endif
            </div>
            @if(!$funding_detail->isFunding())
            <a href="{{route('funding.batch.edit', [$funding_detail->proyek->id, $funding_detail->id])}} " type=button class="btn btn-outline-success my-2">Edit Proyek Batch</a>
            @endif

            @if($funding_detail->redeemDana())
            <a href="{{route('funding.batch.show', [$funding_detail->proyek->id, $funding_detail->id])}} " type=button class="btn btn-success my-2">Tarik Dana</a>
            @endif
        </div>
    </div>
</div>
</div>

@endsection