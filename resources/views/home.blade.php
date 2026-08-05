@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <!-- Expanded from col-md-6 to col-lg-10 so the charts have much more room -->
        <div class="col-lg-10">
            <div class="row">
                <!-- First Chart Card (50% of parent width) -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title text-center">Kerjasama dalam/luar negeri</h5>
                            <canvas id="country-pie"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Second Chart Card (50% of parent width) -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title text-center">Tahun kedaluarsa kerjasama</h5>
                            <canvas id="expiry-pie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $documents->links() }}
</div>
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <form method="GET" action="{{ route('home.index') }}">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <!-- Column Titles -->
                        <tr>
                            <th style="min-width: 160px;">Mitra kerjasama</th>
                            <th style="min-width: 220px;">Judul/maksud dan tujuan</th>
                            <th style="min-width: 130px;">Waktu ttd</th>
                            <th style="min-width: 130px;">Waktu berakhir</th>
                            <th style="min-width: 120px;">Status</th>
                            <th style="min-width: 120px;" class="text-center">Aksi</th>
                        </tr>
                        <!-- Per-Column Search Inputs -->
                        <tr class="bg-white">
                            <th><input type="text" name="mitra" value="{{ request('mitra') }}" class="form-control form-control-sm" placeholder="Cari Mitra..."></th>
                            <th><input type="text" name="title" value="{{ request('title') }}" class="form-control form-control-sm" placeholder="Cari Judul..."></th>
                            <th><input type="text" name="signing" value="{{ request('signing') }}" class="form-control form-control-sm" placeholder="Cari Ttd..."></th>
                            <th><input type="text" name="expiry" value="{{ request('expiry') }}" class="form-control form-control-sm" placeholder="Cari Akhir..."></th>
                            <th><input type="text" name="status" value="{{ request('status') }}" class="form-control form-control-sm" placeholder="Cari Status..."></th>
                            <th class="text-center">
                                <div class="d-flex justify-content-left gap-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('home.index') }}" class="btn btn-sm btn-outline-secondary">
                                        Reset
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $x)
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
                            <td>{{ strlen($x->title) > 64 ? (substr($x->title, 0, 64) . "…") : $x->title }}</td>

                            <!-- 6. Waktu Ttd -->
                            <td>{{ $x->signing }}</td>

                            <!-- 7. Waktu Berakhir -->
                            <td>{{ $x->expiry }}</td>

                            <!-- 8. Status -->
                            <td>{{ $x->status?->name }}</td>

                            <!-- 14. Aksi -->
                            <td class="text-nowrap text-center">
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
    {{ $documents->links() }}
</div>
@endsection
@push('scripts')
<script>
    const _countryPie = document.getElementById('country-pie').getContext('2d');
    const _CountryPie = new Chart(_countryPie, {
        type: 'pie', // Menggunakan tipe pie
        data: {
            labels: ['Dalam negeri', 'Luar negeri'],
            datasets: [{
                data: @json($country),
                // backgroundColor: ['#00ff00', '#ff00ff'], // Warna bawaan Bootstrap (opsional)
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    const _expiryPie = document.getElementById('expiry-pie').getContext('2d');
    const _ExpiryPie = new Chart(_expiryPie, {
        type: 'pie', // Menggunakan tipe pie
        data: {
            labels: @json($expiry_year),
            datasets: [{
                data: @json($expiry_count),
                // backgroundColor: ['#0000ff', '#00ff00', '#ff0000', "#000000"], // Warna bawaan Bootstrap (opsional)
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endpush