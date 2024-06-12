<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@csi-corporation\.com$/|unique:employes',
            'password' => 'required|string|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/|confirmed',
            'role' => 'required|string|in:admin,user',
            'birthdate' => 'required|date|before:today',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|regex:/^\+\d{1,3}\d{9,15}$/',
            'family_situation' => 'required|string|in:célibataire,marié(e),divorcé(e),veuf(ve)',
            'number_of_children' => 'required|integer|min:0',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prénom est requis.',
            'email.regex' => 'L\'adresse e-mail doit appartenir au domaine csi-corporation.com.',
            'password.regex' => 'Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et faire au moins 6 caractères.',
            'role.in' => 'Le rôle doit être soit "admin" soit "user".',
            'birthdate.before' => 'La date de naissance doit être antérieure à la date actuelle.',
            'telephone.regex' => 'Le format du numéro de téléphone est incorrect (ex: +123456789012).',
            'family_situation.in' => 'La situation familiale doit être soit "célibataire", "marié(e)", "divorcé(e)" ou "veuf(ve)".',
        ]);

        $nom = trim($request->nom);
        $prenom = trim($request->prenom);
        $email = trim($request->email);
        $password = $request->password;
        $role = $request->role;
        $birthdate = $request->birthdate;
        $adresse = trim($request->adresse);
        $telephone = trim($request->telephone);
        $family_situation = trim($request->family_situation);
        $number_of_children = intval($request->number_of_children);

        if (strpos($password, $nom) !== false || strpos($password, $prenom) !== false) {
            return back()->withErrors(['password' => 'Erreur : le mot de passe ne doit pas contenir le nom ou le prénom']);
        }

        $hashedPassword = Hash::make($password);

        DB::beginTransaction();

        try {
            $employe = Employe::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role,
                'birthdate' => $birthdate,
                'adresse' => $adresse,
                'telephone' => $telephone,
                'family_situation' => $family_situation,
                'number_of_children' => $number_of_children,
            ]);

            if ($role == 'admin') {
                Admin::create([
                    'id_employe' => $employe->id,
                    'email' => $email,
                    'password' => $hashedPassword,
                ]);
            } else {
                User::create([
                    'id_employe' => $employe->id,
                    'email' => $email,
                    'password' => $hashedPassword,
                ]);
            }

            DB::commit();

            return redirect()->route('login')->with('success', 'Inscription réussie !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()]);
        }
    }
}
