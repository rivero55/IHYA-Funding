@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">proyek</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.show', $proyek->id) }}">{{$proyek->name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Batch</li>
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
                <h6 class="m-0 font-weight-bold text-primary">Edit Batch</h6>
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
                <form action="{{ route('proyek.batch.update', [$proyek->id, $proyek_batch->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="batch_no">Batch ke-</label>
                            <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                                value="{{old('batch_no') ?? $proyek_batch->batch_no }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="minimum_fund">Minimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                    value="{{ (old('minimum_fund') ?? $proyek_batch->minimum_fund) ?? 10000}}"
                                    readonly>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="maximum_fund">Maksimal Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                    value="{{ old('maximum_fund') ?? $proyek_batch->maximum_fund }}">
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak ada batas maksimum Donasi per
                                orang</small>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Target Total Donasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_nominal" id="target_nominal"
                                    min=1 value="{{ old('target_nominal') ?? $proyek_batch->target_nominal }}">
                            </div>

                        </div>
                    </div>

                   

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Tanggal Pelaksanaan Proyek</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ old('start_date') ?? (date('Y-m-d', strtotime($proyek_batch->start_date))) }}"
                                    placeholder="3" min="{{date('Y-m-d')}}">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ old('end_date') ?? (date('Y-m-d', strtotime($proyek_batch->end_date)))}}"
                                    placeholder="7">
                            </div>
                        </div>
                    </div>
               
                    @if(isset($proyek_batch->dana_terkumpul) && $proyek_batch->status != 'paid')
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Total Pendapatan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="dana_terkumpul" id="dana_terkumpul" min=1
                                    value="{{ old('dana_terkumpul') ?? $proyek_batch->dana_terkumpul }}" required readonly>
                            </div>

                            @push('js')
                            <script>


                                $('#dana_terkumpul').on("keyup change load", function () {
                                    count_return();
                                });

                            </script>
                            @endpush
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('proyek.show', $proyek->id) }}">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
   
    $('#start_date').change(function(){
            $('#end_date').val($('#start_date').val())
            $('#end_date').attr("min", $('#start_date').val())
        });

</script>
@endpush
