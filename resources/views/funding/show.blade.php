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
            <img class="card-img-top my-2" src="{{ asset('storage/images/proyek/'.$funding_detail->proyek->image) }}"
                alt="Card image cap">

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

                <p class=" pt-3">Status Proyek : <span
                        class="fw-bold badge rounded-pill bg-{{($funding_detail->status == 'draft') ? 'secondary' : (($funding_detail->status == 'closed') ? 'warning' : 'success')}}">{{$funding_detail->status}}</span>
                </p>
                <p class="f">Status Verifikasi Proyek : <span
                        class="fw-bold badge rounded-pill bg-{{($funding_detail->verification_status == 'rejected') ? 'danger' : (($funding_detail->verification_status == 'process') ? 'warning' : 'success')}}">{{$funding_detail->verification_status}}</span>
                </p>
                @if($funding_detail->verification_status == 'rejected')
                <p>Feedback: <span class="fw-bold">{{$funding_detail->verification_feedback}}</span></p>
                @endif
            </div>
            @if(!$funding_detail->isFunding())
            <a href="{{route('funding.batch.edit', [$funding_detail->proyek->id, $funding_detail->id])}} " type=button
                class="btn btn-outline-success my-2">Edit Proyek Batch</a>
            @endif

            @if($funding_detail->redeemDana())

            <button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#tarikdana">
                Tarik Dana
            </button>
            <div class="modal fade" id="tarikdana" tabindex="-1" aria-labelledby="tarikdanaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tarik dana proyek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('pay.donation-payout', $funding_detail->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <p class="mb-2">Dana Terakhir : <span class="fw-bold">Rp {{number_format($funding_detail->currBalance(),0,",",".")}}</span></p>
                                <label for="description">Jumlah dana yang ingin ditarik</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="nominal" id="nominal" min=1
                                        value="{{ old('target_nominal') }}">
                                </div>
                                <small class="">Tidak boleh melebihi nominal Dana Terakhir</small>

                                <div class="form-group col-md-12 mt-2">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description"
                                        rows="3"></textarea>
                                </div>
                                
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tarik Dana</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
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