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
            var letter = {!! json_encode($letter) !!}
            var table = $('#surat').DataTable({
                autoWidth: false,
                columnDefs: [{
                    searchable: false,
                    targets: 0,
                }, ],
                order: [
                    [0, 'asc']
                ],
                ajax: "{{ url('api/letter') }}" + "/" + letter,
                columns: [{
                        data: null,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'letter_code'
                    },
                    {
                        data: 'date_created',
                    },
                    {
                        data: 'title',
                    },
                    {
                        data: 'description',
                    },
                    {
                        data: 'from',
                    },
                    {
                        data: 'to',
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-sm icon btn-primary me-2 view-file" data-id=${data.id} data-file=${data.file_path}><i class="icon dripicons dripicons-photo"></i></button>                                
                            </div>`
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-sm icon btn-primary me-2 upload-m-letter" data-id=${data.id} data-name=${data.letter_code}><i class="icon dripicons dripicons-upload"></i></button>
                                <button class="btn btn-sm icon btn-warning me-2 edit-m-letter" data-id=${data.id}><i class="dripicons dripicons-document-edit"></i></button>
                                <button class="btn btn-sm icon btn-danger delete-m-letter" data-id=${data.id} data-name=${data.letter_code}><i class="dripicons dripicons-trash"></i></button>
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
            //     $("#surat").DataTable().ajax.reload();
            // }, 10000);
        </script>
        <script>
            $(document).on('click', '.add-btn', function(e) {
                $("#add-modal").modal("show");
                $(document).off('click', '.store-btn').on('click', '.store-btn', function() {
                    $('code').remove();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('api/letter/store') }}",
                        data: {
                            letter_code: $('#letter_code').val(),
                            letter_id: letter,
                            title: $('#title').val(),
                            date_created: $('#date_created').val(),
                            description: $('#description').val(),
                            from: $('#from').val(),
                            to: $('#to').val(),
                            file_path: $('#file_path').val()
                        },
                        success: function(res) {
                            console.log('ok');
                            toastSuccess(res.message);
                            $('#add-modal').modal('hide')
                            $("#surat").DataTable().ajax.reload();
                        },
                        error: function(err) {
                            console.log(err.responseJSON);
                            console.warn(err.responseJSON.errors);
                            $.each(err.responseJSON.errors, function(i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<code class="text-danger">' + error[0] +
                                    '</code>'));
                            });
                        }
                    })
                })
            })
            $(document).on('click', ".edit-m-letter", function(e) {
                var id = $(this).data('id');
                $('#edit-modal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: "{{ url('api/letter/show/') }}" + "/" + id,
                    success: function(res) {
                        console.log(res.data)
                        $('#letter_code_edit').val(res.data.letter_code),
                            $('#title_edit').val(res.data.title),
                            $('#date_created_edit').val(res.data.date_created),
                            $('#description_edit').val(res.data.description),
                            $('#from_edit').val(res.data.from),
                            $('#to_edit').val(res.data.to),
                            $('#file_path_edit').val(res.data.file_path)
                        $(document).off('click', '.confirm-edit').on('click', '.confirm-edit', function() {
                            $.ajax({
                                type: 'PUT',
                                url: "{{ url('api/letter/update/') }}" + "/" + id,
                                data: {
                                    letter_code: $('#letter_code_edit').val(),
                                    title: $('#title_edit').val(),
                                    date_created: $('#date_created_edit').val(),
                                    description: $('#description_edit').val(),
                                    from: $('#from_edit').val(),
                                    to: $('#to_edit').val(),
                                    file_path: $('#file_path_edit').val()
                                },
                                success: function(res) {
                                    console.log("update = " + res)
                                    toastSuccess(res.message);
                                    $('#edit-modal').modal('hide')
                                    $("#surat").DataTable().ajax.reload();
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
                        url: "{{ url('api/letter/destroy/') }}" + "/" + id,
                        success: function(res) {
                            console.log('del');
                            toastSuccess(res.message);
                            $('#delete-modal').modal('hide');
                            $("#surat").DataTable().ajax.reload();
                        }
                    })
                })
            })
            $(document).on('click', ".upload-m-letter", function(e) {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#upload-modal').modal('show');
                $("#upload-preview").text(name)
                $(document).ready(function() {
                    $('#uploadForm').submit(function(event) {
                        event.preventDefault();
                        var formData = new FormData();
                        formData.append('file_path', $('input[name="file_path"]')[0].files[0]);
                        console.log(formData);
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('api/letter/upload/') }}" + "/" + id,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                toastSuccess(res.message);
                                $('#upload-modal').modal('hide');
                                $("#surat").DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    });
                });

            })
            $(document).on('click', ".view-file", function(e) {
                $('#preview-modal').modal('show');
                $("#file-preview").attr("src", " ");
                var src = "{{ url('uploads') }}" + "/" + $(this).data('file')
                console.log(src)
                $("#file-preview").attr("src", src);
            })
        </script>
    @endpush
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $type }} / {{ $letter_name }}</h3>
                <p class="text-subtitle text-muted">{{ $type }} / {{ $letter_name }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $type }} / {{ $letter_name }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="d-flex">
            <a href="#" class="btn btn-primary add-btn">Tambah Surat</a>
        </div>
        <div class="card my-3 p-3">
            <div class="table-responsive my-3">
                <table class="table" id="surat">
                    <thead>
                        <th>No.</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Judul Surat</th>
                        <th>Deskripsi</th>
                        <th>Dari</th>
                        <th>Kepada</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-modal id="add-modal" class="primary store-btn" fnc="">
        <x-slot name="modal_title">Tambah Surat Baru</x-slot>
        <x-slot name="modal_body">
            <div class="row">
                <div class="col-sm-12">
                    <label for="letter_code">Nomor Surat</label>
                    <input type="text" class="form-control" name="letter_code" id="letter_code" placeholder="Judul">
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="date_created">Tanggal</label>
                    <input type="date" class="form-control" name="date_created" id="date_created"
                        placeholder="Tanggal Surat">
                </div>
                <div class="col-sm-12 col-md-8 mb-3">
                    <label for="title">Judul</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Judul">
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="from">Dari</label>
                    <input type="text" class="form-control" name="from" id="from" placeholder="Dari">
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="to">Kepada</label>
                    <input type="text" class="form-control" name="to" id="to" placeholder="Kepada">
                </div>
                {{-- <div class="col-sm-12 mb-3">
                    <label for="file_path">Upload</label>
                    <input type="file" class="form-control" name="file_path" id="file_path" placeholder="Upload File">
                </div> --}}
                <div class="col-sm-12">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
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
                <div class="col-sm-12">
                    <label for="letter_code">Nomor Surat</label>
                    <input type="text" class="form-control" name="letter_code" id="letter_code_edit" placeholder="Judul">
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="date_created">Tanggal</label>
                    <input type="date" class="form-control" name="date_created" id="date_created_edit"
                        placeholder="Tanggal Surat">
                </div>
                <div class="col-sm-12 col-md-8 mb-3">
                    <label for="title">Judul</label>
                    <input type="text" class="form-control" name="title" id="title_edit" placeholder="Judul">
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="from">Dari</label>
                    <input type="text" class="form-control" name="from" id="from_edit" placeholder="Dari">
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="to">Kepada</label>
                    <input type="text" class="form-control" name="to" id="to_edit" placeholder="Kepada">
                </div>
                {{-- <div class="col-sm-12 mb-3">
                    <label for="file_path">Upload</label>
                    <input type="file" class="form-control" name="file_path" id="file_path_edit"
                        placeholder="Upload File">
                </div> --}}
                <div class="col-sm-12">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" name="description" id="description_edit" cols="30" rows="5"></textarea>
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
    <form id="uploadForm" enctype="multipart/form-data">
        <x-modal id="upload-modal" class="warning confirm-upload" fnc="">
            <x-slot name="modal_title">Upload File</x-slot>
            <x-slot name="modal_body">
                <p>Upload File untuk Surat <b id="upload-preview"></b></p>
                <input type="file" class="form-control" id="file_path" name="file_path">
            </x-slot>
            <x-slot name="modal_action">
                Upload
            </x-slot>
        </x-modal>
    </form>
    <x-modal id="preview-modal" class="warning" fnc="">
        <x-slot name="modal_title">Preview File</x-slot>
        <x-slot name="modal_body">
            <p>Preview File untuk Surat <b id="upload-preview"></b></p>
            <iframe id="file-preview" style="width:100%"></iframe>
        </x-slot>
        <x-slot name="modal_action">
            Ok
        </x-slot>
    </x-modal>
@endsection
