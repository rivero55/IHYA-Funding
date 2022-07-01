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

.accordion-button:not(.collapsed) {
    color: white !important;
    background-color: #198754 !important;
    opacity: 0.8;
}

.accordion-button.collapsed::after {
    background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23198754'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffff'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
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
        <div class="col-6 offset-3 card">
            <div class="mt-4">
                <label for="formGroupExampleInput" class="form-label fw-bold">
                    <h4 class="">Masukan Nominal Donasi</h4>
                </label>
            </div>
            <div class="input-group">
                <div class="input-group-text">Rp</div>
                <input type="tel" class="form-control" id="autoSizingInputGroup"
                    placeholder="Masukan Nominal Uang Donasi Anda">
            </div>
            <div class="row card-body">
                <button class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2" type="" id="">10.000</button>
                <button class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2" type="" id="">30.000</button>
                <button class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2" type="" id="">50.000</button>
                <button class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2" type="" id="">100.000</button>
                <button class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2" type="" id="">200.000</button>
            </div>
            <div class="my-1" id="metode-pembayaran">
                <label for="formGroupExampleInput" class="form-label fw-bold">
                    <h4 class="">Pilih Metode Pembayaran</h4>
                </label>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Transfer Bank
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row pb-5">
                                    <div class="col-12 w-100">
                                        <label class="d-inline">
                                            <input type="radio" class="btn-check" name="options-outlined"
                                                value="E-Money, Tranfer Bank, Dan Lain Lain" id="first-payment"
                                                autocomplete="off" checked>
                                            <label class="btn btn-outline-success w-100 py-2 card-input"
                                                for="first-payment" id="wallet-card-methodpayment">
                                                <img src="{{asset('assets/img/logo.png')}}" style="width:40px"
                                                    class="center"></img>

                                                Bca
                                            </label>
                                        </label>

                                    </div>
                                    <div class="col-12 w-100 pt-2">
                                        <label class="d-inline">
                                            <input type="radio" class="btn-check" name="options-outlined"
                                                value="E-Money, Tranfer Bank, Dan Lain Lain" id="success-outlined"
                                                autocomplete="off">
                                            <label
                                                class="btn btn-outline-success card py-2 card-input text-radio text-center"
                                                for="success-outlined" id="wallet-card-methodpayment">Transfer
                                            </label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                E-Payment
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Minimarket
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center py-4"><a href="{{route('login')}}" style="color:#198754">Login</a> atau Isi Data
                Diri dibawah ini</div>
            <div class="my-1">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Nama</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingemail" placeholder="email">
                    <label for="floatingemail">Password</label>
                </div>
                <div class="form-check form-switch d-flex justify-content-between ps-0">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Sembunyikan nama saya (donasi
                        anonim)</label>
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Doa (Opsional)</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <button class="btn btn-success d-block my-2">Bayar</button>

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
function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var footer_top = $("#footer").offset().top;
    var div_top = $('#container').offset().top + $('#container')
        .height();
    var div_height = $("#sticky-sidebar").height();

    var padding = 60;

    if (window_top + div_height > footer_top - padding) {
        $('#sticky-sidebar').css({
            top: (window_top + div_height - footer_top +
                padding) * -1
        });
    } else if (window_top > div_top) {
        $('#sticky-sidebar').addClass('stick');
        $('#sticky-sidebar').css({
            top: 70
        });
    } else {
        $('#sticky-sidebar').removeClass('stick');
        $('#sticky-sidebar').css({
            top: 70
        });

    }
}
$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@endpush