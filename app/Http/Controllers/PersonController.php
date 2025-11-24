<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonStoreRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Person;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::paginate(10);
        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(PersonStoreRequest $request)
    {
        Person::create($request->validated());

        return redirect()->route('people.index')
            ->with('success', 'Person created successfully.');
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return view('people.edit', compact('person'));
    }

    public function update(PersonUpdateRequest $request, $id)
    {
        $person = Person::findOrFail($id);
        $person->update($request->validated());

        return redirect()->route('people.index')
            ->with('success', 'Person updated successfully.');
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect()->route('people.index')
            ->with('success', 'Person deleted successfully.');
    }
}
