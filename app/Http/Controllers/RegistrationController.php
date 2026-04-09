<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function toggle(Request $request, Event $event)
    {
        $user = Auth::user();
        
        // Edge Case 2: Un manager ne s'inscrit pas
        if ($user->role === 'manager') {
            return redirect()->back()->with('error', 'Action réservée aux élèves. Les managers ne peuvent pas participer.');
        }

        // Edge Case 1: Pas d'inscription pour les événements passés
        if ($event->date->isPast()) {
            return redirect()->back()->with('error', 'Impossible de modifier votre inscription pour un événement dont la date est dépassée.');
        }
        
        if ($event->users()->where('user_id', $user->id)->exists()) {
            $event->users()->detach($user->id);
            $message = 'Vous êtes désinscrit de cet événement.';
        } else {
            $event->users()->attach($user->id);
            $message = 'Vous vous êtes inscrit à cet événement.';
        }

        return redirect()->back()->with('success', $message);
    }
}
