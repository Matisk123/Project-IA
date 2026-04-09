<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Utilise EventPolicy pour gérer automatiquement les droits d'accès
        // Manager : CRUD complet | Etudiant : Index & Show uniquement
        $this->authorizeResource(Event::class, 'event');
    }

    public function index()
    {
        // Tri par date pour afficher les événements les plus proches en premier
        $events = Event::orderBy('date', 'asc')->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
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
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:jpo,salon',
            // Note: pas de restriction after_or_equal:today ici pour permettre de modifier
            // la description d'un événement qui vient de se terminer (historique)
            'date' => 'required|date',
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
        // Regle metier : Interdire la suppression si des étudiants sont déjà investis
        // dans l'événement pour éviter de perdre l'historique des participations.
        if ($event->users()->exists()) {
            return redirect()->back()->with('error', 'Cet événement a déjà des participants inscrits et ne peut être supprimé.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé.');
    }
}
