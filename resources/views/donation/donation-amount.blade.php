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
            <form action="{{ route('pay.donation', [$proyek_batch->proyek->id, $proyek_batch->id]) }}"
                                    method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mt-4">
                <label for="formGroupExampleInput" class="form-label fw-bold">
                    <h4 class="">Masukan Nominal Donasi</h4>
                </label>
            </div>
            <div class="input-group">
                <div class="input-group-text">Rp</div>
                <input type="tel" class="form-control" id="autoSizingInputGroup"
                    placeholder="Masukan Nominal Uang Donasi Anda" name="nominal" id="nominal" >
            </div>
            <div class="row card-body">
                <button type="button" class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2 donation-amount" >10.000</button >
                <button type="button" class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2 donation-amount" >30.000</button>
                <button type="button" class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2 donation-amount" >50.000</button>
                <button type="button" class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2 donation-amount" >100.000</button>
                <button type="button" class="col-lg btn btn-outline-success rounded-pill mx-lg-1 my-2 donation-amount" >200.000</button>
            </div>
            <div class="my-1" id="metode-pembayaran">
                <label for="formGroupExamplebutton" class="form-label fw-bold">
                    <h4 class="">Pilih Metode Pembayaran</h4>
                </label>
                <div class="accordion" id="accordionExample">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-controls="collapseOne">
                                Transfer Bank
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row pb-5">
                                    <div class="col-12 w-100">
                                        <label class="d-inline">
                                            <input type="radio" class="btn-check" name="payment_method"
                                                value="Transfer Bank" id="first-payment"
                                                autocomplete="off" >
                                            <label class="btn btn-outline-success w-100 py-2 card-input"
                                                for="first-payment" id="wallet-card-methodpayment">
                                                <img src="{{asset('assets/img/logo.png')}}" style="width:40px"
                                                    class="center"></img> Transfer Bank
                                            </label>
                                        </label>

                                    </div>
                                    <div class="col-12 w-100 pt-2">
                                        <label class="d-inline">
                                            <input type="radio" class="btn-check" name="payment_method"
                                                value="Transfer Bank" id="second-payment-tranferbank"
                                                autocomplete="off">
                                            <label
                                                class="btn btn-outline-success w-100 card-input"
                                                for="second-payment-tranferbank" id="wallet-card-methodpayment">E - Wallet
                                            </label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!Auth::guest())
                    <!--<div class="accordion-item">-->
                    <!--    <h2 class="accordion-header" id="headingThree">-->
                    <!--        <button class="accordion-button" type="button" data-bs-toggle="collapse"-->
                    <!--            data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">-->
                    <!--            Wallet-->
                    <!--        </button>-->
                    <!--    </h2>-->
                    <!--    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree"-->
                    <!--        data-bs-parent="#accordionExample">-->
                    <!--        <div class="accordion-body">-->
                             
                    <!--        <input type="radio" class="btn-check" name="payment_method"-->
                    <!--                            value="wallet" id="wallet"-->
                    <!--                            autocomplete="off">-->
                    <!--                        <label-->
                    <!--                            class="btn btn-outline-success card py-2 card-input text-radio text-center"-->
                    <!--                            for="wallet" id="wallet-card-methodpayment"> <p class="mb-0">Wallet</p>-->
                    <!--                <span class="">Saldo Anda : Rp-->
                    <!--                    {{number_format(Auth::user()->balance,0,",",".")}}</span>-->
                    <!--                        </label>-->
                    <!--            </div>-->
                               
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <!-- <div class="accordion-item">
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
                    </div> -->
                
                </div>
            </div>
            <div class="text-center py-4"> Data Diri Anda </div>
            <p class="fw-bold">{{Auth::user()->name}}</p>
            <span class="">{{Auth::user()->email}}</span>
            
            @else
            
            
            <div class="text-center py-4"><a href="{{route('login')}}" style="color:#198754">Login</a> atau Isi Data
                Diri dibawah ini</div>
            <div class="my-1">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="nama" required>
                    <label for="floatingInput">Nama</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingemail" placeholder="email" name="email" required>
                    <label for="floatingemail">Email</label>
                </div>
             @endif

                <div class="form-check form-switch d-flex justify-content-between ps-0">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Sembunyikan nama saya (donasi
                        anonim)</label>
                    <input class="form-check-input" type="checkbox" name="anonim" id="flexSwitchCheckDefault">
                </div>
                
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Doa (Opsional)</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success d-block my-2 w-100">Bayar</button>
            </div>
            
</form>

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


$('.donation-amount').click(function(){
    let hei=$('input[name=nominal]').val($(this).text().replace('.',''));
console.log(hei);

});
</script>

@endpush