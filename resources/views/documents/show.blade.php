@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ $document->title }}</h1>
    <p>{{ $document->scope }}</p>
</div>
@if(Str::endsWith($document->file, '.pdf'))
<div class="mb-3">
    <a href="{{ asset('storage/' . $document->file) }}" target="_blank" class="btn btn-primary">
        📄 View PDF Document
    </a>
</div>
@else
<div class="mb-3">
    <img src="{{ asset('storage/' . $document->file) }}" alt="Uploaded Image">
</div>
@endif
<div class="mb-3">
    <a href="{{ route('documents.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection