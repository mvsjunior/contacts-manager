@extends('layouts.app')

@section('title', 'People List')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">People</h1>
    <a href="{{ route('people.create') }}" class="btn btn-primary">
        Add New Person
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($people->count() === 0)
    <div class="alert alert-info">
        No people found.
    </div>
@else

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th width="32">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="100" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($people as $person)
                        <tr>
                            <td class="text-center">{{ $person->id }}</td>

                            <td >
                                @if($person->avatar)
                                    <img src="{{ $person->avatar }}"
                                            alt="avatar"
                                            class="rounded-circle"
                                            width="40" height="40">
                                @else
                                
                                    <img src="/assets/img/demo-user-pic.png"
                                            alt="avatar"
                                            class="rounded-circle d-block mx-auto"
                                            width="40" height="40">
                                @endif
                            </td>

                            <td>{{ $person->name }}</td>
                            <td>{{ $person->email }}</td>

                            <td class="d-flex justify-center gap-2" >
                                <a href="{{ route('people.show', $person->id) }}"
                                    class="btn btn-sm btn-secondary">
                                    Details
                                </a>

                                <a href="{{ route('people.edit', $person->id) }}"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('people.destroy', $person->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this person?');">
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

    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $people->links() }}
    </div>

@endif

@endsection
