@extends('layouts.app')

@section('title', 'Create Person')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Create Person</h2>
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Back to list</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There are some errors in the form. Please check below.</strong>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('people.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            minlength="6"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum 6 characters.</div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary float-end" type="submit">Create</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
