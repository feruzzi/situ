@extends('layouts.dashboard.dashboard-admin')
@section('content')
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
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>5</td>
                            <td>57</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>5</td>
                            <td>57</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-modal id="primary" class="primary">
        <x-slot name="modal_title">Tambah Jenis Surat Baru</x-slot>
        <x-slot name="modal_body">
            <form action="{{ url('master-letter/add') }}">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label for="letter_id">ID Surat</label>
                        <input type="text" class="form-control" name="letter_id" id="letter_id" placeholder="ID Surat">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <input type="text" class="form-control" name="letter_name" id="letter_name"
                            placeholder="Nama Surat">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <select class="form-control" name="letter_type" id="letter_type">
                            <option value="letter_in">Surat Masuk</option>
                            <option value="letter_out">Surat Keluar</option>
                        </select>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="modal_action">
            lanjut
        </x-slot>
    </x-modal>
@endsection
