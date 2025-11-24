@extends('layouts.app')

@section('title', 'Edit Person')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Edit Person</h2>
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Back to list</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There are some errors in the form. Please check below.</strong>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('people.update', $person->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $person->name) }}"
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
                            value="{{ old('email', $person->email) }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 
                    <!-- Current Avatar -->
                    <div class="mb-3">
                        <label class="form-label">Current avatar</label>
                        <div>
                                @if($person->avatar)
                                <img src="{{ $person->avatar }}" alt="avatar" class="rounded-circle" width="80" height="80">
                            @else
                                <span class="text-muted">No avatar</span>
                            @endif
                        </div>
                    </div>

                    <!-- Avatar (replace) -->
                    <div class="mb-3">
                        <label class="form-label">Replace avatar (optional)</label>
                        <input type="file" name="avatar_file" accept="image/*" class="form-control">
                        <div class="form-text">Uploading will replace the current avatar.</div>
                    </div>
                    --}}


                    <button class="btn btn-primary float-end" type="submit">Update</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
