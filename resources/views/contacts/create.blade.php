@extends('layouts.app')

@section('title', 'Create Contact')

@section('content')
<div class="container mt-4">

    <h2>Create Contact for: <strong>{{ $person->name }}</strong></h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some errors:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contacts.store', $person->id) }}" method="POST">
        @csrf

        {{-- COUNTRY SEARCH --}}
        <div class="mb-3">
            <label for="country_search" class="form-label">Country</label>

            <input type="text" 
                   id="country_search" 
                   class="form-control" 
                   placeholder="Search country..."
                   autocomplete="off">

            <input type="hidden" name="country_code" id="country_code">

            <div id="country_results"
                 class="list-group mt-1"
                 style="max-height: 200px; overflow-y: auto; display:none;">
            </div>

            <small class="text-muted">Type a country name to search.</small>
        </div>

        {{-- NUMBER --}}
        <div class="mb-3">
            <label for="number" class="form-label">Number (9 digits)</label>
            <input type="text"
                   name="number"
                   id="number"
                   value="{{ old('number') }}"
                   maxlength="9"
                   class="form-control"
                   placeholder="123456789"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Save Contact</button>

        <a href="{{ route('people.show', $person->id) }}" class="btn btn-secondary">
            Back to Person
        </a>
    </form>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const input = document.querySelector("#country_search");
    const results = document.querySelector("#country_results");
    const hiddenCode = document.querySelector("#country_code");

    let searchTimeout = null;

    input.addEventListener("input", function () {

        const query = this.value.trim();

        hiddenCode.value = ""; // limpa quando o usuário edita

        if (query.length < 2) {
            results.style.display = "none";
            results.innerHTML = "";
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetch("https://restcountries.com/v3.1/name/" + query)
                .then(res => res.json())
                .then(data => {
                    results.innerHTML = "";
                    
                    if (!Array.isArray(data)) {
                        results.style.display = "none";
                        return;
                    }

                    data.forEach(country => {
                        if (!country.idd || !country.name) return;

                        const name = country.name.common;
                        const code = country.idd?.root && country.idd?.suffixes?.length 
                            ? country.idd.root.replace("+", "") + country.idd.suffixes[0] 
                            : null;

                        if (!code) return;

                        const item = document.createElement("button");
                        item.type = "button";
                        item.classList.add("list-group-item", "list-group-item-action");
                        item.textContent = `${name} (${code})`;

                        item.addEventListener("click", function () {
                            input.value = `${name} (${code})`;
                            hiddenCode.value = code;
                            results.style.display = "none";
                        });

                        results.appendChild(item);
                    });

                    results.style.display = results.innerHTML.trim() ? "block" : "none";

                })
                .catch(() => {
                    results.style.display = "none";
                });

        }, 300); // debounce
    });
});
</script>
@endsection
