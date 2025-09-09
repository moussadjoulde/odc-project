<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        // Code pour afficher le formulaire de création d'un utilisateur
    }

    public function store(Request $request)
    {
        // Code pour enregistrer un nouvel utilisateur
    }

    public function show(User $user)
    {
        // Charger les relations nécessaires
        $user->load('roles', 'permissions');

        return view('admin.users.show', compact('user'));
    }

    public function revokeAllPermissions(User $user)
    {
        $user->syncPermissions([]);
        $user->syncRoles([]);
        return back()->with('success', 'Toutes les permissions ont été révoquées');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name'
        ]);

        // Mise à jour des informations de base
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        // Gestion de la photo de profil
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
            $user->save();
        }

        // Synchronisation des rôles
        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('users.edit', $user)->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy($id)
    {
        // Code pour supprimer un utilisateur
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'nullable|exists:roles,name']);

        $user->syncRoles($request->role ? [$request->role] : []);

        return back()->with('role_updated', "Rôle de {$user->name} mis à jour avec succès");
    }

    public function sendVerification(User $user)
    {
        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Email de vérification envoyé');
    }

    public function exportCSV()
    {
        // Code pour exporter la liste des utilisateurs au format CSV
    }

    public function resetPassword(User $user)
    {
        Password::sendResetLink(['email' => $user->email]);

        return back()->with('success', "Lien de réinitialisation envoyé à {$user->email}");
    }

    // Suspendre / Activer un compte
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back()->with('success', "Le compte de {$user->name} a été " .
            ($user->is_active ? 'activé' : 'suspendu'));
    }
}
