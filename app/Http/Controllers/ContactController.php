<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact=Contact::all();

        return  $contact;
    }

    public function store(Request $request )
    {
        $contact = new Contact() ;
        $contact->name = $request['name'];
        $contact->email = $request['email'];
        $contact->message = $request['message'];
        $contact->save() ;
    }
}
