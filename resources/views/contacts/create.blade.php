@extends('layouts.app')

@section('content')
<style>
    <!-- Custom CSS to make Select2 look like Bootstrap 5 form-control -->
<style>
/* container */
.select2-container--default .select2-selection--single {
    height: calc(2.25rem + 2px); /* match .form-control height */
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    background-color: #fff;
    box-shadow: none;
}

/* text alignment and font */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5;
    color: #212529;
    padding-left: 0;
}

/* caret spacing */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px);
    right: 0.5rem;
}

/* make the dropdown items same font/size */
.select2-container .select2-results__option {
    padding: 0.5rem 0.75rem;
}

/* when Select2 is focused (bootstrap style) */
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
}

/* ensure width 100% like .form-select */
.select2-container {
    width: 100% !important;
}
</style>
<div class="container mt-4">
    <h2>Create Contact</h2>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <input type="hidden" name="person_id" value="{{ $person->id }}">

        {{-- Country dropdown --}}
        <div class="mb-3">
            <label class="form-label">Country</label>
            <select id="country-select" name="country_code" class="form-select"></select>

            @error('country_code')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Number --}}
        <div class="mb-3">
            <label class="form-label">Number (9 digits)</label>
            <input 
                type="text" 
                class="form-control"
                name="number"
                maxlength="9"
                value="{{ old('number') }}"
                required
            >

            @error('number')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Save Contact</button>
        <a href="{{ route('people.show', $person->id) }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection


@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    {{-- JQuery (necessário para Select2) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
$(document).ready(function () {
    $('#country-select').select2({
        placeholder: "Search a country...",
        allowClear: true,
        ajax: {
            url: "{{ route('api.countries.search') }}",
            delay: 300,
            dataType: 'json',
            data: function (params) {
                return { q: params.term || '' };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.calling_code,
                            text: item.label
                        };
                    })
                };
            }
        }
    });

    // If there's an old value (validation), preselect it
    const oldCode = "{{ old('country_code') }}";
    const oldLabel = "{{ old('country_label') ?? '' }}"; // set this in controller/session if possible
    if (oldCode) {
        // create option and mark as selected
        const option = new Option(oldLabel || oldCode, oldCode, true, true);
        $('#country-select').append(option).trigger('change');
    }
});
</script>

@endsection
