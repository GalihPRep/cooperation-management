@extends('layouts.app')
@section('content')
<h1>Edit {{ $item->title }}</h1>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <a href="/pics" class="btn btn-primary">Kembali</a>
        </div>
        <form action="/pics/{{ $item->id }}" method="post">
            @csrf
            @method("put")
            <div class="mb-3">
                <label for="name" class="control-label">Nama</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $item->name) }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="control-label">Jabatan</label>
                <input id="role" name="role" type="text" class="form-control @error('role') is-invalid @enderror"
                    value="{{ old('role', $item->role) }}">
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="institution_id" class="control-label">Institusi</label>
                <select id="institution_id" name="institution_id" class="form-select">
                    @foreach($institutions as $x)
                    <option value="{{ $x->id }}"
                        {{ old('institution_id', $item->institution?->id) == $x->id ? 'selected' : '' }}>
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