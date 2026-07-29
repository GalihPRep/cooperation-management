@extends('layouts.app')
@section('content')
@if(session()->has("success")) <div class="alert alert-success" role="alert">{{ session("success") }}</div> @endif
<div class="mb-3">
    <h1>Status</h1>
    <a href="/statuses/create" role="button" class="btn btn-primary">Buat status</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $x)
            <tr>
                <td>{{ $x->name }}</td>
                <td>
                    <a href="statuses/{{ $x->id }}/edit" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                    <form action="/statuses/{{ $x->id }}" method="post" style="display:inline;">
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
@endsection