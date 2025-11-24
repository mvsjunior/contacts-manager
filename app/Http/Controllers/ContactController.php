<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;
use App\Models\Person;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index($personId)
    {
        $person = Person::with('contacts')->findOrFail($personId);
        return view('contacts.index', compact('person'));
    }

    public function create($personId)
    {
        $person = Person::findOrFail($personId);
        return view('contacts.create', compact('person'));
    }

    public function store(ContactStoreRequest $request, $personId)
    {
        $person = Person::findOrFail($personId);
        $person->contacts()->create($request->validated());

        return redirect()->route('contacts.index', $personId)
            ->with('success', 'Contact created successfully.');
    }

    public function edit($personId, $contactId)
    {
        $person  = Person::findOrFail($personId);
        $contact = Contact::where('person_id', $personId)->findOrFail($contactId);

        return view('contacts.edit', compact('person', 'contact'));
    }

    public function update(ContactUpdateRequest $request, $personId, $contactId)
    {
        $contact = Contact::where('person_id', $personId)->findOrFail($contactId);
        $contact->update($request->validated());

        return redirect()->route('contacts.index', $personId)
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy($personId, $contactId)
    {
        $contact = Contact::where('person_id', $personId)->findOrFail($contactId);
        $contact->delete();

        return redirect()->route('contacts.index', $personId)
            ->with('success', 'Contact deleted successfully.');
    }
}
