@section('title', 'Login')

@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-light">
                                <div class="py-4"></div>
                                <img class="img-fluid w-50 mx-auto d-block mt-5" src="{{asset('assets/img/logo.png')}}" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome to Ihya Charity!</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input id="email" type="email"
                                                class="form-control-user form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Email Address" required
                                                autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input id="password" type="password"
                                                class="form-control-user form-control @error('password') is-invalid @enderror"
                                                name="password" id="exampleInputPassword" placeholder="Password" required
                                                autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>

                                        {{-- Button Login --}}
                                        <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-user d-grid">
                                            Login
                                        </button>
                                        </div>
                                        {{-- End Button Login --}}

                                    </form>
                                    <hr>
                                    <!-- <div class="text-center fs-6">
                                        @if (Route::has('password.request'))
                                            <a class="small text-success" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div> -->
                                    <div class="text-center">
                                        <a class="small text-success" href="{{ route('register') }}">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection