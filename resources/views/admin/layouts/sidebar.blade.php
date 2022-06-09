<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: rgb(9,193,58);
background: linear-gradient(180deg, rgba(9,193,58,1) 0%, rgba(5,119,51,1) 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> --><img src="{{asset('assets/img/logo.png')}}" style="width:60px;">
        </div>
        <div class="sidebar-brand-text mx-3">IHYA CHARITY</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{last(request()->segments()) == 'admin' ? 'active':''}}">
        <a class="nav-link" href="{{route('admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Donasi
    </div>

    <li class="nav-item ">
        <a class="nav-link" href="{{route('proyek-owner.index')}}">
            <i class="fas fa-people-carry"></i>
            <span>Proyek Owner</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{route('proyek.index')}}">
            <i class="fas fa-people-carry"></i>
            <span>Proyek</span></a>
    </li>
 

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Zakat
        </div>
    <li class="nav-item ">
        <a class="nav-link" href="">
            <i class="fab fa-product-hunt"></i>
            <span>Product</span></a>
    </li>

    





    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>