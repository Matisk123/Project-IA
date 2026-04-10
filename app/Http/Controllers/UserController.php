<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs pour les administrateurs.
     */
    public function index()
    {
        // On récupère tous les utilisateurs sauf celui actuellement connecté
        // pour éviter qu'il s'auto-rétrograde par erreur.
        $users = User::where('id', '!=', Auth::id())->orderBy('name')->get();
        
        return view('users.index', compact('users'));
    }

    /**
     * Change le rôle d'un utilisateur.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:student,manager',
        ]);

        $user->update([
            'role' => $validated['role']
        ]);

        return redirect()->back()->with('success', "Le rôle de {$user->name} a été mis à jour.");
    }

    /**
     * Affiche le suivi des étudiants et leurs statistiques d'événements.
     */
    public function students()
    {
        // Vérification du rôle manager
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        $students = User::where('role', 'student')
            ->with('events')
            ->get()
            ->map(function($student) {
                $student->total_events = $student->events->count();
                $student->finished_events = $student->events->filter(fn($e) => $e->date->isPast())->count();
                return $student;
            });

        return view('users.students', compact('students'));
    }
}
