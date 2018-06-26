<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class LineProvider extends AbstractProvider implements ProviderInterface
{
   /**
   * The scopes being requested.
   *
   * @var array
   */
  protected $scopes = [
    'openid',
  ];
  
  protected function getAuthUrl($state)
  {
    return $this->buildAuthUrlFromBase('https://access.line.me/oauth2/v2.1/authorize', $state);
  }

  protected function getTokenUrl()
  {
    return 'https://api.line.me/oauth2/v2.1/token';
  }

  public function getAccessToken($code)
  {
    $response = $this->getHttpClient()->post($this->getTokenUrl(), [
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ],
      'form_params' => [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $this->redirectUrl,
        'client_id' => $this->clientId,
        'client_secret' => $this->clientSecret,
      ],
    ]);
    return $this->parseAccessToken($response->getBody());
  }

  protected function getUserByToken($token)
  {
    $response = $this->getHttpClient()->get('https://api.line.me/v1/profile', [
      'headers' => [
        'X-Line-ChannelToken' => $token['access_token'],
      ],
    ]);
    return json_decode($response->getBody(), true);
  }

  protected function mapUserToObject(array $user)
  {
    return (new User())->setRaw($user)->map([
      'id' => $user['mid'],
      'name' => $user['displayName'],
    ]);
  }

  protected function parseAccessToken($body)
  {
    return json_decode($body, true);
  }
}
