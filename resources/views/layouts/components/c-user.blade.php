<ul class="menu">
    <li class="sidebar-title">Menu</li>


    <li class="sidebar-item  {{ $set_active == 'perdinku' ? 'active' : '' }}">
        <a href="{{ url('perdinku') }}" class='sidebar-link'>
            <i class="icon dripicons dripicons-stack"></i>
            <span>PERDINKU</span>
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
