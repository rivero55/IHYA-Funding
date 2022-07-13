@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">Proyek</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$proyek->name}}</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">{{$proyek->name}}</h1>
@endsection
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right"
                    href="{{ route('proyek.batch.create', $proyek->id) }}"><i class="fas fa-plus"></i> Tambah Data</a>
                <h6 class="m-0 font-weight-bold text-primary">Proyek Batches</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Batch ke-</th>
                                <th>Minimal Donasi</th>
                                <th>Maksimal Donasi</th>
                                <th>Target Total</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proyek->proyek_batch as $proyek_batch)
                            <tr>
                                <td>{{ $proyek_batch->batch_no }}</td>
                                <td>Rp. {{ number_format($proyek_batch->minimum_fund,0,",",".") }}</td>
                                <td>{{ empty($proyek_batch->maximum_fund) ? '-':'Rp. '. number_format($proyek_batch->maximum_fund,0,",",".")}}
                                </td>
                                <td>Rp. {{ number_format($proyek_batch->target_nominal,0,",",".") }}</td>
                                <td>{{ Carbon::parse($proyek_batch->start_date)->isoFormat('dddd, D MMMM Y') }}</td>
                                <td>{{ Carbon::parse($proyek_batch->end_date)->isoFormat('dddd, D MMMM Y') }}</td>
                                <td>{{ $proyek_batch->status }}</td>
                                </td>
                                <td class="text-center">
                                    @if ($proyek_batch->status == 'draft')
                                    <form
                                        action="{{ route('proyek.batch.status.update', [$proyek->id, $proyek_batch->id]) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin membuka batch ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="status" value="funding" hidden>
                                        <button type="submit" class="btn btn-sm btn-success mb-2"><i
                                                class="fas fa-lock-open"></i> Open</button>
                                    </form>
                                    @elseif($proyek_batch->status == 'funding')
                                    <form
                                        action="{{ route('proyek.batch.status.update', [$proyek->id, $proyek_batch->id]) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin memulai batch ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="status" value="ongoing" hidden>
                                        <button class="btn btn-sm btn-warning mb-2"><i class="fas fa-play"></i>
                                            Start</button>
                                    </form>
                                    @elseif($proyek_batch->status == 'ongoing')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal"
                                        data-target="#closedModal{{$proyek_batch->id}}">
                                        <i class="fas fa-stop"></i> Close
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="closedModal{{$proyek_batch->id}}" tabindex="-1"
                                        aria-labelledby="closedModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tutup Proyek Batch
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('proyek.batch.status.update', [$proyek->id, $proyek_batch->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda yakin menutup batch ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="status" value="closed" hidden>

                                                    <div class="modal-body">
                                                        <div class="row mt-3">
                                                            <div class="form-group col-md-12">
                                                                <label for="gross_income">Pendapatan Kotor</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rp</span>
                                                                    <input type="number" class="form-control" name="gross_income" id="gross_income"
                                                                        min=1 value="{{ old('gross_income') }}" required>
                                                                </div>
                                    
                                                                <small class="form-text text-muted">Jumlah Lot : <span id="lot_count"></span> lot</small>

                                                                <small class="form-text text-muted">Return per Lot : <span>Rp.</span> <span id="return_count">0</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-sm btn-danger mb-2"><i
                                                                class="fas fa-stop"></i> Close Proyek Batch</button>

                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>


                                    @elseif($proyek_batch->status == 'closed')
                                    <form action="  "
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin akan meneruskan dana ke Owner Proyek?')">
                                        @csrf
                                        @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fas fa-dollar-sign"></i>
                                        Pay</button>
                                    </form>
                                    @endif
                                    <form
                                        action="{{ route('proyek.batch.destroy', [$proyek->id, $proyek_batch->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info mb-2"
                                            href="{{ route('proyek.batch.edit', [$proyek->id, $proyek_batch->id]) }}"><i
                                                class="far fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger mb-2"><i
                                                class="far fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
@include('admin.plugins.dataTables-css')
@endpush
@push('js')


@include('admin.plugins.dataTables-js')
@include('admin.plugins.dataTables-set-js')
@endpush
