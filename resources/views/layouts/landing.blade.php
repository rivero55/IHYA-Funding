<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--========== BOX ICONS ==========-->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <!--========== CSS ==========-->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

    * {
        font-family: 'Poppins', sans-serif !important;
    }

    a {
        text-decoration: none !important;
    }
    </style>
    @stack('css')
    @yield('css')
    <title>Ihya Charity - @yield('title')</title>
    <link rel="icon" href="{{asset('assets/img/logo.png')}}" type="image/png">

</head>

<body>

    <!--========== SCROLL TOP ==========-->
    <a href="#" class="scrolltop" id="scroll-top">
        <i class='bx bx-chevron-up scrolltop__icon'></i>
    </a>

    <!--========== HEADER ==========-->
    <header class="l-header d-flex align-items-center" id="header">
        <nav class="nav navbar navbar-expand-lg bd-container">
            <div class="container-fluid">
                <img class="img-fluid" src="{{asset('assets/img/logo.png')}}" style="width:50px;"></img>
                <a href="{{route('landing')}}" class="nav__logo navbar-brand ps-2">IHYA CHARITY</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapseCustom" aria-controls="navbarCollapseCustom" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapseCustom">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
                    <ul class="nav__list">
                        <li class="nav__item"><a href="{{route('landing')}}"
                                class="nav__link {{ Route::is('landing') ? 'active-link' : '' }}">Home</a></li>
                        <li class="nav__item "><a href="{{route('donation')}}" class="nav__link {{ Route::is('donation') ? 'active-link' : '' }}">Donasi</a></li>
                        <li class="nav__item"><a href="{{route('funding.index')}}" class="nav__link {{ Route::is('funding.index') ? 'active-link' : '' }} ">Galang Dana</a></li>
                        <!-- <li class="nav__item"><a href="#about" class="nav__link">Zakat</a></li> -->
                        <li class="nav__item"><a href="{{route('donasiku.index')}}" class="nav__link {{ Route::is('donasiku.index') ? 'active-link' : '' }} ">Donasiku</a></li>
                        @guest
                        <li class="nav__item"><a href="{{route('login')}}" class="nav__link">Login</a></li>
                        @else
                        <li class="nav__item dropdown nav__link">
                    <a class="nav__item dropdown-toggle nav__link" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{Auth::user()->getPhotoProfile()}}" height="25" width="25" alt="" loading="lazy"
                            class="rounded-circle me-1" />
                        {{Auth::user()->name}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                        <li><a class="dropdown-item" href="">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        
                    </ul>
                </li>
                        @endguest
                        <li><i class='bx bx-moon change-theme' id="theme-button"></i></li>
                    </ul>
                </div>


                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')

    <!--========== FOOTER ==========-->
    <footer class="footer section bd-container" id="footer">
        <div class="footer__container bd-grid">
            <div class="footer__content">
                <a href="#" class="footer__logo">IHYA</a>
                <span class="footer__description">Project</span>
                <div>
                    <a href="#" class="footer__social"><i class='bx bxl-facebook'></i></a>
                    <a href="#" class="footer__social"><i class='bx bxl-instagram'></i></a>
                    <a href="#" class="footer__social"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Layanan Kami</h3>
                <ul>
                    <li><a href="#" class="footer__link">Pembagian Makanan</a></li>
                    <li><a href="#" class="footer__link">List Donatur</a></li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Informasi</h3>
                <ul>
                    <li><a href="#" class="footer__link">List Donatur</a></li>
                    <li><a href="#" class="footer__link">Kontak Kami</a></li>

                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Alamat</h3>
                <ul>
                    <li>Telkom University</li>

                </ul>
            </div>
        </div>

        <p class="footer__copy">&#169; 2022 Ihya Digital</p>
    </footer>

    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {!! Toastr::message() !!}
@stack('js')

</html>