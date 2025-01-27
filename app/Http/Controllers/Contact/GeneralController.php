<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\GeneralRequest;
use App\Models\ContactGeneral;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneralController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //dd(getStep());
        Inertia::share('step', getStep());
        return inertia('Contact/General/Step');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GeneralRequest $request)
    {
        $contactGeneral = ContactGeneral::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactGeneral->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactGeneral $contactGeneral)
    {
        Inertia::share('step', getStep($contactGeneral));
        $contactGeneral->company;
        $contactGeneral->person;
        $contactGeneral->detail;
        if($contactGeneral->company == null){
            unset($contactGeneral->company);
        }
        if($contactGeneral->person == null){
            unset($contactGeneral->person);
        }
        if($contactGeneral->detail == null){
            unset($contactGeneral->detail);
        }
        return inertia('Contact/General/Step', compact('contactGeneral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeneralRequest $request, ContactGeneral $contactGeneral)
    {
        $contactGeneral->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactGeneral->id]);
    }
}
