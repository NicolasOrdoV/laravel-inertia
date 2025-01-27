<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\DetailRequest;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contact/Detail/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetailRequest $request)
    {
        //dd($request->validated());
        $contactDetail = ContactDetail::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactDetail->general->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactDetail $contactDetail)
    {
        return inertia('Contact/Detail/Form', compact('contactDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetailRequest $request, ContactDetail $contactDetail)
    {
        $contactDetail->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactDetail->general->id]);
    }
}
