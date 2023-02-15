</div>
</div>
</div>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        @yield('content')
    </div>

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2022 &copy; Syntax Error Teams</p>
            </div>
            <div class="float-end">
                <p>With <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                        href="https://github.com/feruzzi">FRZ</a></p>
            </div>
        </div>
    </footer>
</div>
</div>
{{-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> --}}
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/extensions/autonumeric/autoNumeric.js') }}"></script>
<script src="{{ asset('assets/js/toast.js') }}"></script>
<script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
{{-- <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>> --}}
{{-- <script src="{{ asset('assets/js/pages/sweetalert2.js') }}"></script>> --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{-- @stack('footer-js') --}}
@stack('footer')
</body>

</html>
