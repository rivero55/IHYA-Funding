@extends('layouts.landing')
@section('css')
<!-- CSS only -->

<style>
body {
    padding-top: 90px;
}

.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}
</style>
@endsection
@section ('content')
<div class="container">
    <h3 class="mb-5">Event Berbagi</h3>
    <div class="row">
        @foreach ($datas as $data)
        <div class="col-md-6 col-lg-3 col-12">

            <div class="card rounded-top h-100">
                <img class="card-img-top" style="" src="{{asset($data->photo)}}" alt="Card image cap">
                <div class="card-body  d-flex flex-column">
                    <h4 class="card-title">{{ $data->name }}</h4>
                    <div class="mt-auto">
                    <p class="card-text">
                        {{ $data->description }}</p>
                    <p><i class=" fab fa-pushed"></i> Sisa Kuota Online :  <br>
                        <i class=" fab fa-pushed"></i> Sisa Kuota Offline : 
                        <i class=" fas fa-star"></i> Menu Makanan :
                    </p>
                    <p><i class="fas fa-calendar-check"></i> Tanggal Mulai : <br>
                        <i class="fas fa-calendar-times"></i> Tanggal Selesai :
                    </p>
                    <p class="card-text"><small class="text-muted"></small></p>

                    <a href='{{url("makan-gratis/$data->id/detail/")}}'>
                        <button type="button" class="btn btn-outline-success mt-2">Lihat Detail</button>
                    </a>

                    <form method="post" action="{{url('/register_to_event')}}">
                        @csrf
                        <input type="hidden" name="event_id" value="{{$data->id}}">
                        <input type="hidden" name="redirectTo" value="{{Request::path()}}">
                        <button type="submit" class="btn btn-success mt-2">Daftar Makan GRATIS</button>
                    </form>
</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection