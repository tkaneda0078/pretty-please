<?php

namespace App;

use App\User;
use App\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountsService
{
    /**
     * SocialAccounts情報を見つける
     *
     * @param ProviderUser $providerUser
     * @param [type] $provider
     * @return void
     */
    public function find(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        return $account ? $account->user : null;
    }

    /**
     * userとSocialAccounts情報を紐付ける
     *
     * @param User $user
     * @param ProviderUser $providerUser
     * @param [string] $provider
     * @return void
     */
    public function associate(User $user, ProviderUser $providerUser, $provider)
    {
        $user->accounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }
}