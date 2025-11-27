@extends('layouts.app')

@section('title', 'Person Details')

@section('content')
<div class="container mt-4">

    {{-- Back --}}
    <a href="{{ route('people.index') }}" class="btn btn-secondary mb-3">
        ← Back to List
    </a>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Person Details</h5>
            <div>
                <a href="{{ route('people.edit', $person->id) }}" class="btn btn-sm btn-primary">Edit</a>

                <form action="{{ route('people.destroy', $person->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this person?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <h6><strong>ID:</strong> {{ $person->id }}</h6>
            <h6><strong>Name:</strong> {{ $person->name }}</h6>
            <h6><strong>Email:</strong> {{ $person->email }}</h6>

            @if($person->avatar)
                <div class="mt-3">
                    <strong>Avatar:</strong>
                    <div>
                        <img src="data:image/png;base64,{{ $person->avatar }}" alt="Avatar"
                             class="img-thumbnail" style="max-width: 150px;">
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- CONTACTS --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Contacts</h5>
            <a href="{{ route('contacts.create', ['person_id' => $person->id]) }}" class="btn btn-sm btn-success">
                Add New Contact
            </a>
        </div>

        <div class="card-body">
            @if($person->contacts->count() === 0)
                <p class="text-muted">No contacts registered.</p>
            @else
                <div class="table-responsive table-sm">
                    <table class="table table-bordered table-striped small">
                        <thead class="table-light">
                            <tr>
                                <th width='42' class="text-center">ID</th>
                                <th width='150'>Country Code</th>
                                <th >Number</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($person->contacts as $contact)
                                <tr>
                                    <td align="center">{{ $contact->id }}</td>
                                    <td>{{ $contact->country_code }}</td>
                                    <td>{{ $contact->number }}</td>
                                    <td>
                                        <a href="{{ route('contacts.show', $contact->id) }}"
                                           class="btn btn-sm btn-info">
                                            View
                                        </a>

                                        <a href="{{ route('contacts.edit', $contact->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Edit
                                        </a>

                                        <form action="{{ route('contacts.destroy', $contact->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
