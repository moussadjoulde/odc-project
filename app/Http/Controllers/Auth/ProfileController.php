<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation du champ name
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Récupérer l'utilisateur
        $user = User::findOrFail($id);

        // Mettre à jour le nom
        $user->name = $request->input('name');
        $user->save();

        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Vérifie si l'utilisateur authentifié correspond bien
        if ($user->id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        // Déconnexion avant suppression
        Auth::logout();

        // Suppression du compte
        $user->delete();

        // Redirection
        return redirect()->route('home')->with('success', 'Votre compte a été supprimé avec succès.');
    }
}
