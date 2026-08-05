@extends('layouts.app')
@section('content')
@if(session()->has("success")) <div class="alert alert-success" role="alert">{{ session("success") }}</div> @endif
<div class="mb-3">
    <h1>Penanggung jawab</h1>
    <a href="/pics/create" role="button" class="btn btn-primary">Buat penanggung jawab</a>
</div>
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <form method="GET" action="{{ route('pics.index') }}">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <tr>
                            <th style="min-width: 240px;">Nama</th>
                            <th style="min-width: 120px;">Jabatan</th>
                            <th style="min-width: 240px;">Institusi</th>
                            <th style="min-width: 120px;">Aksi</th>
                        </tr>
                        <tr class="bg-white">
                            <th><input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm" placeholder="Find name..."></th>
                            <th><input type="text" name="role" value="{{ request('role') }}" class="form-control form-control-sm" placeholder="Find role..."></th>
                            <th><input type="text" name="institution" value="{{ request('institution') }}" class="form-control form-control-sm" placeholder="Find institution..."></th>
                            <th class="text-center">
                                <div class="d-flex justify-content-left gap-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('pics.index') }}" class="btn btn-sm btn-outline-secondary">
                                        Reset
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $x)
                        <tr>
                            <td>{{ $x->name }}</td>
                            <td>{{ $x->role }}</td>
                            <td>{{ $x->institution?->name }}</td>
                            <td>
                                <a href="pics/{{ $x->id }}/edit" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/pics/{{ $x->id }}" method="post" style="display:inline;">
                                    @csrf
                                    @method("delete")
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('U sure bout that?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
@endsection