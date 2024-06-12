<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Employe;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employes,email',
            'password' => 'required|min:8|string',
        ], [
            'email.exists' => 'Erreur : email inconnu',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $employe = Employe::where('email', $user->email)->first();
            logger()->info('Logged in successfully as '. (isset($employe->role)? $employe->role : 'Unknown'));
            if ($employe && $employe->role == 'admin') {
                Log::info('Redirecting to admin dashboard');
                return redirect()->route('dashboard.admin');
            } else {
                Log::info('Redirecting to user dashboard');
                return redirect()->route('dashboard.user');
            }
        }

        return back()->withErrors(['error' => 'Invalid email or password. Please try again.']);
    }

    protected function authenticate(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return true;
        }

        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}