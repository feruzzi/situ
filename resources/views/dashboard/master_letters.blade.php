@extends('layouts.dashboard.dashboard-admin')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    @endpush
    @push('footer')
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="{{ asset('assets/js/toast.js') }}"></script>
        <script>
            var table = $('#master-surat').DataTable({
                autoWidth: false,
                columnDefs: [{
                    searchable: false,
                    targets: 0,
                }, ],
                order: [
                    [0, 'asc']
                ],
                ajax: "{{ url('api/master-letter') }}",
                columns: [{
                        data: null,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'letter_id',
                    },
                    {
                        data: 'letter_name',
                    },
                    {
                        data: 'letter_type'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-sm icon btn-warning me-2 edit-m-letter" data-id=${data.id}><i class="dripicons dripicons-document-edit"></i></button>
                                <button class="btn btn-sm icon btn-danger delete-m-letter" data-id=${data.id} data-name=${data.letter_name}><i class="dripicons dripicons-trash"></i></button>
                            </div>`
                        }
                    },

                ]
            });

            table.on('xhr', function() {
                var json = table.ajax.json();
                // alert(json.data.length + ' row(s) were loaded');
            });
            //!! refresh every 10 seconds
            // setInterval(function() {
            //     $("#master-surat").DataTable().ajax.reload();
            // }, 10000);
        </script>
        <script>
            const add = () => {
                $('code').remove();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('api/master-letter/store') }}",
                    data: {
                        letter_id: $('#letter_id').val(),
                        letter_name: $('#letter_name').val(),
                        letter_type: $('#letter_type').val()
                    },
                    success: function(res) {
                        console.log('ok');
                        toastSuccess(res.message);
                        $('#primary').modal('hide')
                        $("#master-surat").DataTable().ajax.reload();
                    },
                    error: function(err) {
                        console.log(err.responseJSON);
                        console.warn(err.responseJSON.errors);
                        $.each(err.responseJSON.errors, function(i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<code class="text-danger">' + error[0] + '</code>'));
                        });
                    }
                })
            }
            $(document).on('click', ".edit-m-letter", function(e) {
                var id = $(this).data('id');
                $('#edit-modal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: 'api/master-letter/show/' + id,
                    success: function(res) {
                        console.log(res.data)
                        $('#letter_id_edit').val(res.data.letter_id)
                        $('#letter_name_edit').val(res.data.letter_name)
                        $('#letter_type_edit').val(res.data.letter_type)
                        $(document).off('click', '.confirm-edit').on('click', '.confirm-edit', function() {
                            $.ajax({
                                type: 'PUT',
                                url: 'api/master-letter/update/' + id,
                                data: {
                                    letter_id: $('#letter_id_edit').val(),
                                    letter_name: $('#letter_name_edit').val(),
                                    letter_type: $('#letter_type_edit').val()
                                },
                                success: function(res) {
                                    console.log("update = " + res)
                                    toastSuccess(res.message);
                                    $('#edit-modal').modal('hide')
                                    $("#master-surat").DataTable().ajax.reload();
                                },
                                error: function(err) {
                                    console.log(err.responseJSON);
                                    console.warn(err.responseJSON.errors);
                                    $.each(err.responseJSON.errors, function(i, error) {
                                        var el = $(document).find('[name="' +
                                            i + '"]');
                                        el.after($('<code class="text-danger">' +
                                            error[0] + '</code>'));
                                    });
                                }
                            })
                        })
                    }
                })

            })
            $(document).on('click', ".delete-m-letter", function(e) {
                var id = $(this).data('id');
                var name = $(this).data('name');
                console.log(id)
                $('#delete-modal').modal('show');
                $("#letter-preview").text(name)
                $(document).off('click', '.confirm-delete').on('click', '.confirm-delete', function() {
                    $.ajax({
                        type: 'DELETE',
                        url: 'api/master-letter/destroy/' + id,
                        success: function(res) {
                            console.log('del');
                            toastSuccess(res.message);
                            $('#delete-modal').modal('hide');
                            $("#master-surat").DataTable().ajax.reload();
                        }
                    })
                })
            })
        </script>
    @endpush
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Master Surat</h3>
                <p class="text-subtitle text-muted">Master Surat</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Master Surat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="d-flex">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#primary">Tambah Jenis
                Surat</a>
        </div>
        <div class="card my-3 p-3">
            <div class="table-responsive my-3">
                <table class="table" id="master-surat">
                    <thead>
                        <th>No.</th>
                        <th>ID Surat</th>
                        <th>Nama Surat</th>
                        <th>Jenis Surat</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-modal id="primary" class="primary" fnc="onclick=add()">
        <x-slot name="modal_title">Tambah Jenis Surat Baru</x-slot>
        <x-slot name="modal_body">
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label for="letter_id">ID Surat</label>
                    <input type="text" class="form-control" name="letter_id" id="letter_id" placeholder="ID Surat">
                </div>
                <div class="col-sm-12 col-md-6">
                    <input type="text" class="form-control" name="letter_name" id="letter_name" placeholder="Nama Surat">
                </div>
                <div class="col-sm-12 col-md-6">
                    <select class="form-control" name="letter_type" id="letter_type">
                        <option value="Surat Masuk">Surat Masuk</option>
                        <option value="Surat Keluar">Surat Keluar</option>
                    </select>
                </div>
            </div>
        </x-slot>
        <x-slot name="modal_action">
            Simpan
        </x-slot>
    </x-modal>
    <x-modal id="edit-modal" class="warning confirm-edit" fnc="">
        <x-slot name="modal_title">Edit Surat</x-slot>
        <x-slot name="modal_body">
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label for="letter_id">ID Surat</label>
                    <input type="text" class="form-control" name="letter_id" id="letter_id_edit" placeholder="ID Surat"
                        disabled>
                </div>
                <div class="col-sm-12 col-md-6">
                    <input type="text" class="form-control" name="letter_name" id="letter_name_edit"
                        placeholder="Nama Surat">
                </div>
                <div class="col-sm-12 col-md-6">
                    <select class="form-control" name="letter_type" id="letter_type_edit">
                        <option value="Surat Masuk">Surat Masuk</option>
                        <option value="Surat Keluar">Surat Keluar</option>
                    </select>
                </div>
            </div>
        </x-slot>
        <x-slot name="modal_action">
            Update
        </x-slot>
    </x-modal>
    <x-modal id="delete-modal" class="danger confirm-delete" fnc="">
        <x-slot name="modal_title">Hapus Surat</x-slot>
        <x-slot name="modal_body">
            <p>Yakin untuk menghapus data surat <b id="letter-preview"></b></p>
        </x-slot>
        <x-slot name="modal_action">
            Hapus
        </x-slot>
    </x-modal>
@endsection
