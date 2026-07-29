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
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Institusi</th>
            <th>Aksi</th>
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
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
@endsection