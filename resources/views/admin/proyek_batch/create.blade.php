@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">Proyek</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.show', $proyek->id) }}">{{$proyek->name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Batch</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">proyek {{$proyek->name}}</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Batch</h6>
            </div>
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
            <div class="card-body">
            <form action="{{ route('proyek.batch.store', $proyek->id) }}" method="POST"
                    enctype="multipart/form-data">
                    
                    @csrf
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
                            <small class="form-text text-muted">Kosongkan jika tidak ada batas maksimum Donasi per
                                orang</small>

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


                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('proyek.show', $proyek->id) }}">Cancel</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
      
        $('#minimum_fund, #target_nominal').on("keyup change load", function(){
            count_lot();
        });

        $('#start_date').change(function(){
            $('#end_date').val($('#start_date').val())
            $('#end_date').attr("min", $('#start_date').val())
        });
    </script>

@endpush