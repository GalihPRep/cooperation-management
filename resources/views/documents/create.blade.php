@extends('layouts.app')
@section('content')
<h1>Buat kerjasama</h1>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <a href="{{ route('documents.index') }}" class="btn btn-primary">Kembali</a>
        </div>
        <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="partner" class="control-label">Mitra kerjasama</label>
                <input id="partner" name="partner" type="hidden"
                    value="{{ old('partner') }}">
                <div id="partner-badges" class="d-inline-flex"></div>
                <select id="partner-select" class="form-select">
                    <option value="" selected>…</option>
                    @foreach($partners as $x)
                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="control-label">Judul/maksud dan tujuan</label>
                <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="number" class="control-label">Nomor dokumen</label>
                <input id="number" name="number" type="text" class="form-control @error('number') is-invalid @enderror"
                    value="{{ old('number') }}">
                @error('number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="control-label">Jenis dokumen</label>
                <select id="category_id" name="category_id" class="form-select">
                    @foreach($categories as $x)
                    <option value="{{ $x->id }}"
                        {{ old('category_id') == $x->id ? 'selected' : '' }}>
                        {{ $x->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="scope" class="control-label">Ruang lingkup</label>
                <textarea id="scope" name="scope" type="text" class="form-control @error('scope') is-invalid @enderror">{{ old('scope') }}</textarea>
                @error('scope') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="signing" class="control-label">Waktu penandatanganan</label>
                <input id="signing" name="signing" type="date" class="form-control @error('signing') is-invalid @enderror"
                    value="{{ old('signing') }}">
                @error('signing') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="expiry" class="control-label">Waktu berakhirnya perjanjian</label>
                <input id="expiry" name="expiry" type="date" class="form-control @error('expiry') is-invalid @enderror"
                    value="{{ old('expiry') }}">
                @error('expiry') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="status_id" class="control-label">Status</label>
                <select id="status_id" name="status_id" class="form-select">
                    @foreach($statuses as $x)
                    <option value="{{ $x->id }}"
                        {{ old('status_id') == $x->id ? 'selected' : '' }}>
                        {{ $x->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pic" class="control-label">Pic</label>
                <input id="pic" name="pic" type="hidden"
                    value="{{ old('pic') }}">
                <div id="pic-badges" class="d-inline-flex"></div>
                <select id="pic-select" class="form-select">
                    <option value="" selected>…</option>
                    @foreach($pics as $x)
                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="format_id" class="control-label">Dokumen</label>
                <select id="format_id" name="format_id" class="form-select">
                    @foreach($formats as $x)
                    <option value="{{ $x->id }}"
                        {{ old('format_id') == $x->id ? 'selected' : '' }}>
                        {{ $x->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="note" class="control-label">Keterangan</label>
                <input id="note" name="note" type="text" class="form-control @error('note') is-invalid @enderror"
                    value="{{ old('note') }}">
                @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="division" class="control-label">OTK</label>
                <input id="division" name="division" type="hidden"
                    value="{{ old('division') }}">
                <div id="division-badges" class="d-inline-flex"></div>
                <select id="division-select" class="form-select">
                    <option value="" selected>…</option>
                    @foreach($divisions as $x)
                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="extension" class="control-label">Rencana perpanjangan/tidak</label>
                <input id="extension" name="extension" type="text" class="form-control @error('extension') is-invalid @enderror"
                    value="{{ old('extension') }}">
                @error('extension') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Choose File:</label>
                <input id="file" name="file" type="file" class="form-control @error('file') is-invalid @enderror" />
            </div>
            <div class="mb-3">
                <input type="submit" value="Simpan" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>
@endsection
@push("scripts")
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const _partner = document.getElementById('partner');
        const _partnerSelect = document.getElementById("partner-select");
        const _partnerBadges = document.getElementById("partner-badges");

        // Helper to get array of selected IDs and to update the hidden input string!
        const _Partner = {
            getValue: () => _partner.value ? _partner.value.split(',') : [],
            setValue: (ids) => {
                _partner.value = ids.filter(Boolean).join(',')
            }
        };

        // Create a badge element!
        const _PartnerBadge = (id, text) => {
            const span = document.createElement('span');
            span.className = 'badge rounded-pill bg-primary me-1 cp-pointer';
            span.style.cursor = 'pointer';
            span.innerHTML = `${text} <span class="ms-1">&times;</span>`;
            span.addEventListener('click', () => {
                _Partner.setValue(_Partner.getValue().filter(x => x !== id));
                span.remove();
            });
            return span;
        };

        // Handle dropdown selection!
        _partnerSelect.addEventListener('change', (event) => {
            const value = event.target.value;
            const text = event.target.options[_partnerSelect.selectedIndex].text;
            if (!value) return;
            let ids = _Partner.getValue();
            if (!ids.includes(value)) {
                ids.push(value);
                _Partner.setValue(ids);
                _partnerBadges.appendChild(_PartnerBadge(value, text));
            }

            // Reset select index!
            _partnerSelect.selectedIndex = 0;
        });

        // Optional: re-render badges if old validation input exists!
        // Warning: simplifying this will prevent the badges from re-rendering!
        if (_partner.value) _Partner.getValue().forEach(id => {
            const option = _partnerSelect.querySelector(`option[value="${id}"]`);
            if (option) _partnerBadges.appendChild(_PartnerBadge(id, option.text));
        });

        const _pic = document.getElementById('pic');
        const _picSelect = document.getElementById("pic-select");
        const _picBadges = document.getElementById("pic-badges");

        // Helper to get array of selected IDs and to update the hidden input string!
        const _Pic = {
            getValue: () => _pic.value ? _pic.value.split(',') : [],
            setValue: (ids) => {
                _pic.value = ids.filter(Boolean).join(',')
            }
        };

        // Create a badge element!
        const _PicBadge = (id, text) => {
            const span = document.createElement('span');
            span.className = 'badge rounded-pill bg-primary me-1 cp-pointer';
            span.style.cursor = 'pointer';
            span.innerHTML = `${text} <span class="ms-1">&times;</span>`;
            span.addEventListener('click', () => {
                _Pic.setValue(_Pic.getValue().filter(x => x !== id));
                span.remove();
            });
            return span;
        };

        // Handle dropdown selection!
        _picSelect.addEventListener('change', (event) => {
            const value = event.target.value;
            const text = event.target.options[_picSelect.selectedIndex].text;
            if (!value) return;
            let ids = _Pic.getValue();
            if (!ids.includes(value)) {
                ids.push(value);
                _Pic.setValue(ids);
                _picBadges.appendChild(_PicBadge(value, text));
            }

            // Reset select index!
            _picSelect.selectedIndex = 0;
        });

        // Optional: re-render badges if old validation input exists!
        // Warning: simplifying this will prevent the badges from re-rendering!
        if (_pic.value) _Pic.getValue().forEach(id => {
            const option = _picSelect.querySelector(`option[value="${id}"]`);
            if (option) _picBadges.appendChild(_PicBadge(id, option.text));
        });

        const _division = document.getElementById('division');
        const _divisionSelect = document.getElementById("division-select");
        const _divisionBadges = document.getElementById("division-badges");

        // Helper to get array of selected IDs and to update the hidden input string!
        const _Division = {
            getValue: () => _division.value ? _division.value.split(',') : [],
            setValue: (ids) => {
                _division.value = ids.filter(Boolean).join(',')
            }
        };

        // Create a badge element!
        const _DivisionBadge = (id, text) => {
            const span = document.createElement('span');
            span.className = 'badge rounded-pill bg-primary me-1 cp-pointer';
            span.style.cursor = 'pointer';
            span.innerHTML = `${text} <span class="ms-1">&times;</span>`;
            span.addEventListener('click', () => {
                _Division.setValue(_Division.getValue().filter(x => x !== id));
                span.remove();
            });
            return span;
        };

        // Handle dropdown selection!
        _divisionSelect.addEventListener('change', (event) => {
            const value = event.target.value;
            const text = event.target.options[_divisionSelect.selectedIndex].text;
            if (!value) return;
            let ids = _Division.getValue();
            if (!ids.includes(value)) {
                ids.push(value);
                _Division.setValue(ids);
                _divisionBadges.appendChild(_DivisionBadge(value, text));
            }

            // Reset select index!
            _divisionSelect.selectedIndex = 0;
        });

        // Optional: re-render badges if old validation input exists!
        // Warning: simplifying this will prevent the badges from re-rendering!
        if (_division.value) _Division.getValue().forEach(id => {
            const option = _divisionSelect.querySelector(`option[value="${id}"]`);
            if (option) _divisionBadges.appendChild(_DivisionBadge(id, option.text));
        });
    });
</script>
@endpush