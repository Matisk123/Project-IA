<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Gère l'inscription ou la désinscription d'un utilisateur à un événement.
     * Logique de bascule (toggle) basée sur l'existence de la relation en base.
     */
    public function toggle(Request $request, Event $event)
    {
        $user = Auth::user();

        // Regle metier : Une fois l'événement passé, les inscriptions sont verrouillées
        // pour figer le registre de présence historique.
        if ($event->date->isPast()) {
            return redirect()->back()->with('error', 'Impossible de modifier votre inscription pour un événement dont la date est dépassée.');
        }

        // Logique de bascule : si l'utilisateur est déjà inscrit, on le retire, sinon on l'ajoute.
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
