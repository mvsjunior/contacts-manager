@extends('layouts.app')

@section('title', 'Edit Contact')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Edit Contact</h5>
                </div>

                <div class="card-body">

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                        @csrf

                        <input type="hidden" name="person_id" value="{{ $person->id }}">
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">

                        {{-- COUNTRY --}}
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select id="country-select" name="country_code" class="form-select" required>
                                {{-- Preloaded selected country --}}
                                @if($contact->country_code && $contact->country_name)
                                    <option value="{{ $contact->country_code }}" selected>
                                        {{ $contact->country_name }} ({{ $contact->country_code }})
                                    </option>
                                @endif
                            </select>
                        </div>

                        {{-- NUMBER --}}
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input 
                                type="text" 
                                name="number" 
                                class="form-control" 
                                maxlength="9" 
                                pattern="[0-9]{9}" 
                                value="{{ old('number', $contact->number) }}" 
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">Update Contact</button>
                        <a href="{{ route('people.show', $person->id) }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    $('#country-select').select2({
        theme: "bootstrap-5",
        placeholder: "Search a country...",
        allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ route('api.countries.search') }}",
            delay: 300,
            dataType: 'json',
            data: function (params) {
                return { q: params.term || '' };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.calling_code,
                        text: item.label
                    }))
                };
            }
        }
    });

    // Handle old value after validation error
    const oldCode = "{{ old('country_code') }}";
    const oldLabel = "{{ old('country_label') ?? '' }}";

    if (oldCode) {
        const option = new Option(oldLabel || oldCode, oldCode, true, true);
        $('#country-select').append(option).trigger('change');
    }

});
</script>
@endsection
