<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        //$contacts = Contact::all();
        $companies = $user->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies','');
        //\DB::enableQueryLog();
        //$contacts = Contact::latestFirst()->MyCustomFilter()->paginate(10);
        $contacts = $user->contacts()->latestFirst()->paginate(10);
        //dd(\DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

        //2 ways
        //Contact::create($request->all() + ['user_id' => auth()->id()]);
        $request->user()->contacts()->create($request->all());

        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfully');
    }

    public function create()
    {
        $contact = new Contact();
        $companies = auth()->user->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies','');
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $companies = auth()->user->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies','');
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        $contact = Contact::findOrFail($id);
        $contact->updated($request->all());

        return redirect()->route('contacts.index')->with('message', 'Contact has been updated successfully');
    }
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('message', 'Contact has been deleted successfully');
    }
}
