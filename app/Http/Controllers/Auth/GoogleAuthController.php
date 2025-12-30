<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google authentication page
     * This is the first step: user clicks "Login with Google"
     */
    public function redirectToGoogle()
    {
        // Socialite::driver('google') uses Google OAuth config
        // redirect() sends user to Google's login page
        return Socialite::driver('google')->redirect();
    }
    
    /**
     * Handle callback from Google after user authorizes
     * This is the second step: Google redirects back to our app
     */
    /**
     * Handle callback from Google after user authorizes
     * This is the second step: Google redirects back to our app
     */
    public function handleGoogleCallback()
    {
        try {
            // FIX: Add this variable to help the IDE understand the driver type
            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver('google');

            // Get user info from Google
            $googleUser = $driver->stateless()->user();
            
            // Check if user already exists in our database
            // First check by Google ID
            $user = User::where('google_id', $googleUser->getId())->first();
            
            // If not found by Google ID, check by email
            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();
            }
            
            // If user exists, update their Google ID
            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                // Create new user if doesn't exist
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null,             // No password for Google users
                    'role' => 'user',              // Default role
                    'email_verified_at' => now(),  // Auto-verify Google emails
                ]);
            }
            
            // Log the user in
            Auth::login($user);
            
            // Redirect to dashboard after successful login
            return redirect()->intended('dashboard');
            
        } catch (Exception $e) {
            // Optional: Log the error for debugging
            // \Log::error('Google Login Error: ' . $e->getMessage());
            
            return redirect('login')->with('error', 'Unable to login with Google. Please try again.');
        }
    }
}