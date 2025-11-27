<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;
use App\Models\Person;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function index($personId)
    {
        $person = Person::with('contacts')->findOrFail($personId);
        return view('contacts.index', compact('person'));
    }

    public function create(Request $request)
    {
        $personId = $request->query('person_id');
        $person = Person::findOrFail($personId);
        return view('contacts.create', compact('person'));
    }

    // public function store(ContactStoreRequest $request, $personId)
    // {
    //     $person = Person::findOrFail($personId);
    //     $person->contacts()->create($request->validated());

    //     return redirect()->route('contacts.index', $personId)
    //         ->with('success', 'Contact created successfully.');
    // }

    public function store(ContactStoreRequest $request)
    {
        $request->validate([
            'country_code' => 'required|string',
            'number' => 'required|digits:9',
        ]);

        $person = Person::find($request->person_id);
        Contact::create([
            'person_id' => $person->id,
            'country_code' => $request->country_code,
            'number' => $request->number,
        ]);

        return redirect()
            ->route('people.show', $person)
            ->with('success', 'Contact successfully created.');
    }

    public function fetchCountries(Request $request)
    {
        $search = $request->query('q', '');

        if ($search) {
            $url = "https://restcountries.com/v3.1/name/" . urlencode($search);
        } else {
            $url = "https://restcountries.com/v3.1/all";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return response()->json([], 200);
        }

        // Normaliza dados
        $countries = collect($response->json())
            ->map(function ($item) {
                $name = $item['name']['common'] ?? null;
                $codes = $item['idd']['root'] ?? '';
                $suffixes = $item['idd']['suffixes'][0] ?? '';

                if (!$name || !$codes) {
                    return null;
                }

                $fullCode = str_replace('+', '', $codes . $suffixes);

                return [
                    'name' => $name,
                    'calling_code' => $fullCode,
                    'label' => "{$name} ({$fullCode})"
                ];
            })
            ->filter()
            ->values();

        return response()->json($countries);
    }

    public function searchCountries(Request $request)
    {
        $query = empty($request->get('q', '')) ? 'all' : $request->get('q', '');

        // Chamada à API externa
        $url = $query == 'all' ? ("https://restcountries.com/v3.1/" . urlencode($query) . "?fields=name,idd") : ("https://restcountries.com/v3.1/name/" . urlencode($query) . "?fields=name,idd");

        $response = @file_get_contents($url);

        if (!$response) {
            return response()->json([]);
        }

        $countries = json_decode($response, true);

        if (!is_array($countries)) {
            return response()->json([]);
        }

        // Tratamento dos países
        $result = [];

        foreach ($countries as $country) {
            if (!isset($country['name']['common'])) continue;
            if (!isset($country['idd']['root'])) continue;
            if (!isset($country['idd']['suffixes'][0])) continue;

            $root = $country['idd']['root'];        // ex: "+3"
            $suffix = $country['idd']['suffixes'][0]; // ex: "51"
            $callingCode = str_replace("+", "", $root . $suffix); // "351"

            $result[] = [
                "label" => $country['name']['common'] . " (" . $callingCode . ")",
                "calling_code" => $callingCode,
            ];
        }

        return response()->json($result);
    }

    public function edit(Request $request)
    {
        // $person  = Person::findOrFail($request->id);
        $contact = Contact::with(['person'])->find($request->id);
        $person = $contact->person;

        return view('contacts.edit', compact('person', 'contact'));
    }

    public function update(ContactUpdateRequest $request)
    {
        $personId = $request->person_id;
        $contactId = $request->contact_id;
        $contact = Contact::where('person_id', $personId)->findOrFail($contactId);
        $contact->update($request->validated());

        return response()->redirectTo('people/show/'.$personId)
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Request $request)
    {
        $contact = Contact::with('person')->findOrFail($request->id);
        $person = $contact->person;
        $contact->delete();

        return response()->redirectTo('people/show/'.$person->id)
            ->with('success', 'Contact deleted successfully.');
    }
}
