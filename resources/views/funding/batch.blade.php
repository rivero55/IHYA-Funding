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
    <form action="{{route('funding.batch.store',$proyek->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-2">
        <div class="col-6 offset-3 card">
                <h5 class="my-2">Proyek Batch</h5>
                <div class="row">
                        <div class="form-group col-md-6">
                            <label for="batch_no">Batch ke-</label>
                            <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                                value="{{old('batch_no') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="minimum_fund">Minimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                    value="{{ old('minimum_fund') ?? 10000}}" readonly>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="maximum_fund">Maksimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                    value="{{ old('maximum_fund') }}">
                            </div>
                            <small class="form-text text-muted">Opsional</small>


                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Target Total Donasi </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_nominal" id="target_nominal"
                                    min=1 value="{{ old('target_nominal') }}">
                            </div>

                        </div>
                    </div>
                    

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Tanggal Pelaksanaan Proyek</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ old('start_date') }}" placeholder="3" min="{{date('Y-m-d')}}">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="date" class="form-control" name="end_date" id="end_date" 
                                    value="{{ old('end_date') }}" placeholder="7" min="{{date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <button type="submit" class="btn btn-success d-block my-2 w-100">Buat Batch</button>

            </div>
        </div>
    </div>
</form>
</div>

@endsection
