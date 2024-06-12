<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Employe;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('auth.reset_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        if (!preg_match('/^[a-zA-Z0-9._%+-]+@csi-corporation\.com$/', $email)) {
            return back()->withErrors(['email' => 'Erreur : l\'email doit être terminé par @csi-corporation.com']);
        }

        $employe = Employe::whereEmail($email)->first();

        if (!$employe) {
            return back()->withErrors(['email' => 'Erreur : email inconnu']);
        }

        $token = bin2hex(random_bytes(16));
        $hashedToken = hash('sha256', $token);
        $expiration = Carbon::now()->addHour();

        try {
            DB::table('reset_password')->insert([
                'id_employe' => $employe->id,
                'token' => $hashedToken,
                'expiration' => $expiration,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erreur : une erreur s\'est produite. Veuillez réessayer plus tard.']);
        }

        $reset_link = route('confirm_reset_password', ['token' => $token]);

        try {
            Mail::send('emails.reset_password', [
                'user_name' => $employe->prenom,
                'reset_link' => $reset_link,
                'token' => $token,
            ], function ($message) use ($email) {
                $message->from('csi.international2010@gmail.com', 'Votre équipe de support');
                $message->subject('Réinitialisation du mot de passe');
                $message->to($email);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erreur : l\'envoi de l\'email a échoué. Veuillez réessayer plus tard.']);
        }

        return back()->with('success', 'Un lien de réinitialisation du mot de passe a été envoyé à votre adresse email.');
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        // Handle the actual password reset logic here
    }
}
