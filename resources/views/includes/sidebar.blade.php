<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MAPROD</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @role(['superadministrator', 'owner'])
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Dashboard
        </div>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endrole
    @role(['superadministrator', 'owner', 'karyawan'])
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Gudang
        </div>
        <li class="nav-item {{ request()->is('barang') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('barang') }}">
                <i class="fas fa-fw fa-inbox"></i>
                <span>Data Bakso</span></a>
        </li>
    @endrole
    {{-- @role(['superadministrator', 'owner', 'karyawan'])
      <li class="nav-item {{ request()->is('persediaan') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('persediaan')}}">
          <i class="fas fa-fw fa-inbox"></i>
          <span>Persediaan Bahan</span></a>
      </li> 
      @endrole --}}
    <!-- Divider -->
    @role(['superadministrator', 'owner', 'karyawan'])
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Pembelian
        </div>
        <li class="nav-item {{ request()->is('pembelian') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('pembelian') }}">
                <i class="fas fa-fw fa-shopping-basket"></i>
                <span>List Pengeluaran</span></a>
        </li>
    @endrole
    <!-- Divider -->
    @role(['superadministrator', 'owner', 'karyawan', 'kasir'])
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Penjualan
        </div>
        <li class="nav-item {{ request()->is('penjualan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('penjualan') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>List Penjualan</span></a>
        </li>
    @endrole
    @role(['superadministrator', 'owner', 'karyawan', 'kasir'])
        <li class="nav-item {{ request()->is('penjualan/transaksi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('penjualan/transaksi') }}">
                <i class="fa fa-cart-plus"></i>
                <span>Transaksi</span></a>
        </li>
    @endrole
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
