@extends('layouts.app')
@section('content')
@if(session()->has("success")) <div class="alert alert-success" role="alert">{{ session("success") }}</div> @endif
<div class="mb-3">
    <h1>Jenis dokumen</h1>
    <a href="/categories/create" role="button" class="btn btn-primary">Buat jenis dokumen</a>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <form method="GET" action="{{ route('categories.index') }}">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                        <tr class="bg-white">
                            <th><input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm" placeholder="Find name..."></th>
                            <th class="text-center">
                                <div class="d-flex justify-content-left gap-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
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
                            <td>
                                <a href="categories/{{ $x->id }}/edit" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                <form action="/categories/{{ $x->id }}" method="post" style="display:inline;">
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
@endsection