@extends('layouts.app')
@section('content')
<h1>Buat jenis dokumen</h1>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <a href="/categories" class="btn btn-primary">Kembali</a>
        </div>
        <form action="/categories" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="control-label">Nama</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <input type="submit" value="Simpan" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>
@endsection