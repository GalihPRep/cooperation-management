@extends('layouts.app')
@section('content')
<div class="mb-3">
    <h1>Ringkasan kerjasama</h1>
</div>
<div class="mb-3">
    <h2>Dalam negeri</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Mitra</th>
                <th>Jumlah kerjasama</th>
                <th>Kerjasama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($institutions_internal as $x)
            <tr>
                <td style="white-space: pre-line;">{{ preg_replace('/[;] /', "\n", $x->name) }}</td>
                <td>{{ $x->documents_count }}</td>
                <td>
                    <ul>
                        @foreach($x->documents as $y)
                        <li>{{ $y->title }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mb-3">
    <h2>Luar negeri</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Mitra</th>
                <th>Negara</th>
                <th>Jumlah kerjasama</th>
                <th>Kerjasama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($institutions_foreign as $x)
            <tr>
                <td style="white-space: pre-line;">{{ preg_replace('/[;] /', "\n", $x->name) }}</td>
                <td>{{ $x->country?->name }}</td>
                <td>{{ $x->documents_count }}</td>
                <td>
                    <ul>
                        @foreach($x->documents as $y)
                        <li>{{ $y->title }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection