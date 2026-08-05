@extends('layouts.app')

@section('content')
@if(session()->has("success"))
<div class="alert alert-success" role="alert">{{ session("success") }}</div>
@endif

<div class="mb-3 d-flex justify-content-between align-items-center">
    <h1>Kerjasama</h1>
    <a href="/documents/create" role="button" class="btn btn-primary">Buat kerjasama</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <form method="GET" action="{{ route('documents.index') }}">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <!-- Column Titles -->
                        <tr>
                            <th style="min-width: 160px;">Mitra kerjasama</th>
                            <th style="min-width: 480px;">Judul/maksud dan tujuan</th>
                            <th style="min-width: 160px;">Nomor dokumen</th>
                            <th style="min-width: 120px;">Jenis dokumen</th>
                            <th style="min-width: 180px;">Lingkup ruang</th>
                            <th style="min-width: 135px;">Waktu TTD</th>
                            <th style="min-width: 135px;">Waktu berakhir</th>
                            <th style="min-width: 120px;">Status</th>
                            <th style="min-width: 120px;">PIC</th>
                            <th style="min-width: 120px;">Bentuk</th>
                            <th style="min-width: 216px;">Keterangan</th>
                            <th style="min-width: 120px;">OTK</th>
                            <th style="min-width: 180px;">Rencana perpanjangan</th>
                            <th style="min-width: 120px;" class="text-center">Aksi</th>
                        </tr>
                        <!-- Per-Column Search Inputs -->
                        <tr class="bg-white">
                            <th><input type="text" name="mitra" value="{{ request('mitra') }}" class="form-control form-control-sm" placeholder="Cari Mitra..."></th>
                            <th><input type="text" name="title" value="{{ request('title') }}" class="form-control form-control-sm" placeholder="Cari Judul..."></th>
                            <th><input type="text" name="number" value="{{ request('number') }}" class="form-control form-control-sm" placeholder="Cari Nomor..."></th>
                            <th><input type="text" name="category" value="{{ request('category') }}" class="form-control form-control-sm" placeholder="Cari Jenis..."></th>
                            <th><input type="text" name="scope" value="{{ request('scope') }}" class="form-control form-control-sm" placeholder="Cari Lingkup..."></th>
                            <th><input type="text" name="signing" value="{{ request('signing') }}" class="form-control form-control-sm" placeholder="Cari Ttd..."></th>
                            <th><input type="text" name="expiry" value="{{ request('expiry') }}" class="form-control form-control-sm" placeholder="Cari Akhir..."></th>
                            <th><input type="text" name="status" value="{{ request('status') }}" class="form-control form-control-sm" placeholder="Cari Status..."></th>
                            <th><input type="text" name="pic" value="{{ request('pic') }}" class="form-control form-control-sm" placeholder="Cari PIC..."></th>
                            <th><input type="text" name="format" value="{{ request('format') }}" class="form-control form-control-sm" placeholder="Cari Bentuk..."></th>
                            <th><input type="text" name="note" value="{{ request('note') }}" class="form-control form-control-sm" placeholder="Cari Ket..."></th>
                            <th><input type="text" name="otk" value="{{ request('otk') }}" class="form-control form-control-sm" placeholder="Cari OTK..."></th>
                            <th><input type="text" name="extension" value="{{ request('extension') }}" class="form-control form-control-sm" placeholder="Cari Rencana..."></th>
                            <th class="text-center">
                                <div class="d-flex justify-content-left gap-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-secondary">
                                        Reset
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $x)
                        <tr>
                            <!-- 1. Mitra Kerjasama -->
                            <td>
                                @foreach($x->institutions as $y)
                                @if(!$y->bmkg)
                                <span class="badge bg-primary me-1 text-wrap text-start d-inline-block mb-1" style="white-space: pre-line;">{{ preg_replace('/; /', "\n", $y->name) }}</span>
                                @endif
                                @endforeach
                            </td>

                            <!-- 2. Judul -->
                            <td>{{ $x->title }}</td>

                            <!-- 3. Nomor Dokumen -->
                            <td>
                                @if(str_contains($x->number, ' '))
                                @foreach(explode(" ", $x->number) as $y) <span class="badge bg-outline-primary text-dark border">{{ $y }}</span> @endforeach
                                @else
                                <span class="badge bg-outline-primary text-dark border">{{ $x->number }}</span>
                                @endif
                            </td>

                            <!-- 4. Jenis Dokumen -->
                            <td>{{ $x->category?->name }}</td>

                            <!-- 5. Lingkup Ruang -->
                            <td>{{ strlen($x->scope) > 64 ? (substr($x->scope, 0, 64) . "…") : $x->scope }}</td>

                            <!-- 6. Waktu Ttd -->
                            <td>{{ $x->signing }}</td>

                            <!-- 7. Waktu Berakhir -->
                            <td>{{ $x->expiry }}</td>

                            <!-- 8. Status -->
                            <td>{{ $x->status?->name }}</td>

                            <!-- 9. PIC -->
                            <td>
                                @foreach($x->pics as $y)
                                <span class="badge rounded-pill bg-primary me-1 mb-1 d-inline-block">{{ $y->name }}</span>
                                @endforeach
                            </td>

                            <!-- 10. Bentuk Dokumen -->
                            <td>{{ $x->format?->name }}</td>

                            <!-- 11. Keterangan -->
                            <td>{{ $x->note }}</td>

                            <!-- 12. OTK -->
                            <td>
                                @foreach($x->institutions as $y)
                                @if($y->bmkg)
                                <span class="badge rounded-pill bg-primary me-1 mb-1 d-inline-block">{{ $y->name }}</span>
                                @endif
                                @endforeach
                            </td>

                            <!-- 13. Rencana Perpanjangan -->
                            <td>{{ $x->extension }}</td>

                            <!-- 14. Aksi -->
                            <td class="text-nowrap text-center">
                                <a href="{{ route('documents.show', $x->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="documents/{{ $x->id }}/edit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/documents/{{ $x->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method("delete")
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $items->links() }}
</div>
@endsection