<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\CompanyRequest;
use App\Models\ContactCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contact/Company/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        //dd($request->validated());
        $contactCompany = ContactCompany::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactCompany->general->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactCompany $contactCompany)
    {
        return inertia('Contact/Company/Form', compact('contactCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, ContactCompany $contactCompany)
    {
        $contactCompany->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactCompany->general->id]);
    }
}
