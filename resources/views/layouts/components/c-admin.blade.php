<ul class="menu">
    <li class="sidebar-title">Menu</li>

    <li class="sidebar-item {{ $set_active == 'dashboard' ? 'active' : '' }}">
        <a href="{{ url('dashboard') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-title">Master Data</li>
    <li class="sidebar-item  {{ $set_active == 'users' ? 'active' : '' }}">
        <a href="{{ url('dashboard/users') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-user-group"></i>
            <span>Pengguna</span>
        </a>
    </li>
    <li class="sidebar-item  {{ $set_active == 'master_letters' ? 'active' : '' }}">
        <a href="{{ url('master-letters') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-archive"></i>
            <span>Surat</span>
        </a>
    </li>
    <li class="sidebar-item  {{ $set_active == 'users' ? 'active' : '' }}">
        <a href="{{ url('dashboard/users') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-tag"></i>
            <span>Barang</span>
        </a>
    </li>
    <hr>
    <li class="sidebar-title">Persuratan</li>
    <li class="sidebar-item  has-sub">
        <a href="#" class="sidebar-link">
            <i class="icon dripicons dripicons-enter"></i>
            <span>Surat Masuk</span>
        </a>
        <ul class="submenu {{ $type == 'Surat Masuk' ? 'active' : '' }}">
            @foreach ($in_letters as $in)
                <li class="submenu-item {{ $letter == $in->letter_id ? 'active' : '' }}">
                    <a
                        href="{{ url('letters/' . $in->letter_type . '/' . $in->letter_id) }}">{{ $in->letter_name }}</a>
                </li>
            @endforeach
        </ul>
    </li>
    <li class="sidebar-item  has-sub">
        <a href="#" class="sidebar-link">
            <i class="icon dripicons dripicons-exit"></i>
            <span>Surat Keluar</span>
        </a>
        <ul class="submenu {{ $type == 'Surat Keluar' ? 'active' : '' }}">
            @foreach ($out_letters as $out)
                <li class="submenu-item {{ $letter == $out->letter_id ? 'active' : '' }}">
                    <a
                        href="{{ url('letters/' . $out->letter_type . '/' . $out->letter_id) }}">{{ $out->letter_name }}</a>
                </li>
            @endforeach
        </ul>
    </li>
    <hr>
    <li class="sidebar-title">Barang</li>
    <li class="sidebar-item {{ $set_active == 'cities' ? 'active' : '' }}">
        <a href="{{ url('dashboard/cities') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-enter"></i>
            <span>Barang Keluar</span>
        </a>
    </li>
    <li class="sidebar-item {{ $set_active == 'cities' ? 'active' : '' }}">
        <a href="{{ url('dashboard/cities') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-to-do"></i>
            <span>Peminjaman Barang</span>
        </a>
    </li>
    <hr>
    <li class="sidebar-item">
        <a href="{{ url('logout/auth') }}" class='sidebar-link text-danger fw-bold'>
            <i class="icon dripicons dripicons-exit text-danger"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>
