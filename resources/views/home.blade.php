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