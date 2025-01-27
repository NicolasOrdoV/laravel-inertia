<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\PersonRequest;
use App\Models\ContactPerson;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contact/Person/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request)
    {
        //dd($request->validated());
        $contactPerson = ContactPerson::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactPerson->general->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactPerson $contactPerson)
    {
        return inertia('Contact/Person/Form', compact('contactPerson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonRequest $request, ContactPerson $contactPerson)
    {
        $contactPerson->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactPerson->general->id]);
    }
}
