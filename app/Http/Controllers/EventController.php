<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'asc')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }
        return view('events.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:jpo,salon',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'subjects' => 'nullable|string',
            'requirements' => 'nullable|string',
            'guides' => 'nullable|string',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:jpo,salon',
            'date' => 'required|date', // On ne met pas after_or_equal:today à l'update sinon on ne peut plus modifier l'historique
            'location' => 'required|string|max:255',
            'subjects' => 'nullable|string',
            'requirements' => 'nullable|string',
            'guides' => 'nullable|string',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Événement mis à jour.');
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        // Edge Case 4: Refus de suppression si inscriptions
        if ($event->users()->exists()) {
            return redirect()->back()->with('error', 'Cet événement a déjà des participants inscrits et ne peut être supprimé.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé.');
    }
}
