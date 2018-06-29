<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialAccountsService;
use Illuminate\Http\Request;
use Socialite;

class SocialAccountController extends Controller
{

    public function redirectToProvider($provider)
    {
        return Socialite::with($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, SocialAccountsService $accountService, $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $account = $accountService->find($socialUser, $provider);
            if (!$account) {
                $accountService->associate($request->user(), $socialUser, $provider);
            }

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}
