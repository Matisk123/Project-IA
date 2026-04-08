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
