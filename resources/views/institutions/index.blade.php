@extends('layouts.app')
@section('content')
@if(session()->has("success")) <div class="alert alert-success" role="alert">{{ session("success") }}</div> @endif
<div class="mb-3">
    <h1>Institusi</h1>
    <a href="/institutions/create" role="button" class="btn btn-primary">Buat institusi</a>
</div>
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
<div class="w-full overflow-x-auto overflow-y-max max-h-[500px] border border-gray-200 rounded-lg"></div>
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>K/L/PD/badan·hukum/perorangan</th>
            <th>Anggota BMKG</th>
            <th>Negara</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $x)
        <tr>
            <td style="white-space: pre-line;">{{ preg_replace('/[;] /', "\n", $x->name) }}</td>
            <td>{{ $x->sector?->name }}</td>
            <td>{{ $x->bmkg ? "Ya" : "Tidak" }}</td>
            <td>{{ $x->country?->name }}</td>
            <td>
                <a href="institutions/{{ $x->id }}/edit" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="/institutions/{{ $x->id }}" method="post" style="display:inline;">
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
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
@endsection