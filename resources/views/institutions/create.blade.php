@extends('layouts.app')
@section('content')
<h1>Buat institusi</h1>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <a href="/institutions" class="btn btn-primary">Kembali</a>
        </div>
        <form action="/institutions" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="control-label">Nama</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="sector_id" class="control-label">K/L/PD/badan·hukum/perorangan</label>
                <select id="sector_id" name="sector_id" class="form-select">
                    @foreach($sectors as $x)
                    <option value="{{ $x->id }}"
                        {{ old('sector_id') == $x->id ? 'selected' : '' }}>
                        {{ $x->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <input id="bmkg" name="bmkg" type="checkbox" class="form-check-input @error('bmkg') is-invalid @enderror", value="1">
                <label for="bmkg" class="form-check-label">Anggota BMKG</label>
                @error('bmkg') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="country_id" class="control-label">Negara</label>
                <select id="country_id" name="country_id" class="form-select">
                    @foreach($countries as $x)
                    <option value="{{ $x->id }}"
                        {{ old('country_id') == $x->id ? 'selected' : '' }}>
                        {{ $x->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" value="Simpan" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>
@endsection