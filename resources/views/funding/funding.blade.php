@extends('layouts.landing')
@section('title', 'Galang Dana')
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
use App\Models\Address;
@endphp
@push('css')
<style>
body {
    padding-top: 90px;
}

.border-left-success {
    border-left: 5px solid #4CAF50;
}
.border-left-failed {
    border-left: 5px solid red;
}
.border-left-progress {
    border-left: 5px solid orange;
}
.nav-link{
    color:#4CAF50 !important;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    background-color:#4CAF50 !important;
    color:white !important;

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
    <div class="row mt-2">
        <div class="col-8 offset-2 card shadow mb-3">
            <div class="d-flex justify-content-between my-2 align-items-center">
                <h5 class="float-left mb-0">Buat Penggalangan Dana</h5>
                <p class="float-right mb-0">Total Proyek Funding : {{$user_crowdfunding->count()}}</p>
            </div>
            <a class="btn btn-outline-success mb-2" href="{{route('funding.create')}}">+ Buat Proyek Penggalangan Dana</a>

        </div>

        <div class="col-8 offset-2 card shadow">
            <h5 class="py-2">Kelola Penggalangan Dana </h5>
            <div class="card">

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua"
                                type="button" role="tab" aria-controls="semua" aria-selected="true">Semua</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif"
                                type="button" role="tab" aria-controls="aktif" aria-selected="false">Aktif</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="akhir-tab" data-bs-toggle="tab" data-bs-target="#akhir"
                                type="button" role="tab" aria-controls="akhir" aria-selected="false">Akhir</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                                type="button" role="tab" aria-controls="rejected" aria-selected="false">Rejected</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                type="button" role="tab" aria-controls="review" aria-selected="false">Dalam
                                Review</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            
                            @forelse ($user_crowdfunding->sortByDesc('created_at') as $funding)
                            <div class="card border-left-{{($funding->verification_status == 'rejected') ? 'failed' : (($funding->verification_status == 'process') ? 'progress' : 'success')}} success shadow h-100 mb-2 rounded">
                                <div class="card-body">
                                    <div class="row pb-3 ">
                                        <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama
                                            Proyek
                                            <div class="col pt-2">
                                                <h6 class="fw-bolder">{{$funding->fullName()}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">
                                            Progress
                                            <div class="col pt-2">
                                                <h6 class="fw-bold mb-0">{{$funding->verification_status}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Target Dana
                                            
                                            <div class="col pt-2 text-nowrap">
                                                <h6 class="fw-bolder"><span>Rp</span> {{ number_format($funding->target_nominal,0,",",".") }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 ">

                                            <div class="d-grid">
                                                <a href="{{route('funding.batch.show', [$funding->proyek->id, $funding->id])}}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio mb-1">
                                                    Lihat Detail
                                                </a>
                                                @if($funding->verification_status == "accepted")
                                                <a href="{{ route('funding.batch.create', $funding->proyek->id) }}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio">
                                                    Tambah Batch
                                                </a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                            <div class="card container-fluid" style="height:200px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                        <p class="text-muted">Belum ada proyek penggalangan dana</p>
                                        <a class="btn btn-sm btn-success mt-2 " href="{{route('donation')}}">+ Tambah
                                            Proyek</a>
                                    </div>
                                </div>
                            </div>

                            @endforelse

                        </div>
                        <div class="tab-pane fade" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                            @forelse ($user_crowdfunding_active->sortByDesc('created_at') as $funding)
                            <div class="card border-left-success shadow h-100 mb-2 rounded">
                                <div class="card-body">
                                    <div class="row pb-3 ">
                                        <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama
                                            Proyek
                                            <div class="col pt-2">
                                                <h6 class="fw-bolder">{{$funding->fullName()}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">
                                            Status
                                            <div class="col pt-2">
                                                <h6 class="fw-bold mb-0">{{$funding->status}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Dana
                                            Terkumpul
                                            <div class="col pt-2 text-nowrap">
                                                <h6 class="fw-bolder"><span>Rp</span> {{$funding->totalDonations()}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 ">

                                            <div class="d-grid">
                                                <a href="{{route('funding.batch.show', [$funding->proyek->id, $funding->id])}}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio">
                                                    Lihat Detail
                                                </a>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                            <div class="card container-fluid" style="height:200px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                        <p class="text-muted">Belum ada proyek penggalangan dana</p>
                                        <a class="btn btn-sm btn-success mt-2 " href="{{route('donation')}}">+ Tambah
                                            Proyek</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse

                        </div>
                        <div class="tab-pane fade" id="akhir" role="tabpanel" aria-labelledby="akhir-tab">
                        @forelse ($user_crowdfunding_closed->sortByDesc('created_at')  as $funding)
                            <div class="card border-left-success shadow h-100 mb-2 rounded">
                                <div class="card-body">
                                    <div class="row pb-3 ">
                                        <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama
                                            Proyek
                                            <div class="col pt-2">
                                                <h6 class="fw-bolder">{{$funding->fullName()}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">
                                            Status
                                            <div class="col pt-2">
                                                <h6 class="fw-bold mb-0">{{$funding->status}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Dana
                                            Terkumpul
                                            <div class="col pt-2 text-nowrap">
                                                <h6 class="fw-bolder"><span>Rp</span> {{$funding->totalDonations()}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 ">

                                            <div class="d-grid">
                                                <a href="{{route('funding.batch.show', [$funding->proyek->id, $funding->id])}}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio">
                                                    Lihat Detail
                                                </a>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                            <div class="card container-fluid" style="height:200px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                        <p class="text-muted">Belum ada proyek penggalangan dana</p>
                                        <a class="btn btn-sm btn-success mt-2 " href="{{route('donation')}}">+ Tambah
                                            Proyek</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        
                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                        @forelse ($user_crowdfunding_rejected->sortByDesc('created_at')  as $funding)
                            <div class="card border-left-failed shadow h-100 mb-2 rounded">
                                <div class="card-body">
                                    <div class="row pb-3 ">
                                        <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama
                                            Proyek
                                            <div class="col pt-2">
                                                <h6 class="fw-bolder">{{$funding->fullName()}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">
                                            Status
                                            <div class="col pt-2">
                                                <h6 class="fw-bold mb-0">{{$funding->status}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Dana
                                            Terkumpul
                                            <div class="col pt-2 text-nowrap">
                                                <h6 class="fw-bolder"><span>Rp</span> {{$funding->totalDonations()}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 ">

                                            <div class="d-grid">
                                                <a href="{{route('funding.batch.show', [$funding->proyek->id, $funding->id])}}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio">
                                                    Lihat Detail
                                                </a>
                                              

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                            <div class="card container-fluid" style="height:200px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                        <p class="text-muted">Belum ada proyek penggalangan dana</p>
                                        <a class="btn btn-sm btn-success mt-2 " href="{{route('donation')}}">+ Tambah
                                            Proyek</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        @forelse ($user_crowdfunding_review->sortByDesc('created_at')  as $funding)
                        <div class="card border-left-progress shadow h-100 mb-2 rounded">
                                <div class="card-body">
                                    <div class="row pb-3 ">
                                        <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama
                                            Proyek
                                            <div class="col pt-2">
                                                <h6 class="fw-bolder">{{$funding->fullName()}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">
                                            Progress
                                            <div class="col pt-2">
                                                <h6 class="fw-bold mb-0">{{$funding->verification_status}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Dana
                                            Anda
                                            <div class="col pt-2 text-nowrap">
                                                <h6 class="fw-bolder"><span>Rp </span> {{ number_format($funding->target_nominal,0,",",".") }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md mt-2 ">

                                            <div class="d-grid">
                                                <a href="{{route('funding.batch.show', [$funding->proyek->id, $funding->id])}}"
                                                    class="btn btn-sm btn-outline-success button-margin-portofolio">
                                                    Lihat Detail
                                                </a>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                            <div class="card container-fluid" style="height:200px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                        <p class="text-muted">Belum ada proyek penggalangan dana</p>
                                        <a class="btn btn-sm btn-success mt-2 " href="{{route('donation')}}">+ Tambah
                                            Proyek</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
@push('css')
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
    text-align: center;
}
</style>
@endpush
@push('js')


<script>
$('.donation-amount').click(function() {
    let hei = $('input[name=nominal]').val($(this).text().replace('.', ''));
    console.log(hei);

});
</script>

@endpush