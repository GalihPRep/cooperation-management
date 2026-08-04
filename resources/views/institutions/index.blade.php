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
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <form method="GET" action="{{ route('institutions.index') }}">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <tr>
                            <th style="min-width: 240px;">Nama</th>
                            <th style="min-width: 120px;">Sektor</th>
                            <th style="min-width: 120px;">Anggota BMKG</th>
                            <th style="min-width: 120px;">Negara</th>
                            <th style="min-width: 120px;">Aksi</th>
                        </tr>
                        <tr class="bg-white">
                            <th><input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm" placeholder="Find name..."></th>
                            <th><input type="text" name="sector" value="{{ request('sector') }}" class="form-control form-control-sm" placeholder="Find sector..."></th>
                            <th>
                                <select name="bmkg" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="1" {{ request('bmkg') === '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ request('bmkg') === '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </th>
                            <th><input type="text" name="country" value="{{ request('country') }}" class="form-control form-control-sm" placeholder="Find country..."></th>
                            <th class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('institutions.index') }}" class="btn btn-sm btn-outline-secondary">
                                        Reset
                                    </a>
                                </div>
                            </th>
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
        </form>
    </div>
</div>
<div class="container md-4">
    <div class="row justify-content-start mt-2">
        <div class="col-md-6 col-lg-4">{{ $items->links() }}</div>
    </div>
</div>
@endsection