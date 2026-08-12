@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ $document->title }}</h1>
    <p>{{ $document->scope }}</p>
</div>
<div class="mb-3">
    <a href="{{ route('documents.index') }}" class="btn btn-primary">Kembali</a>
</div>
<div class="mb-3">
    <iframe src="{{ asset('storage/' . $document->file) }}" width="100%" height="600px"></iframe>
</div>
@endsection