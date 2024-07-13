<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{

    public function store(ContactRequest $request)
    {

        $contact = new Contact();
        $contact->store($request);

        return response()->json([
            'success' => 'true',
            'status' => 200
        ]);
    }

}
