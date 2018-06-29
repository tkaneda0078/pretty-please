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
    'profile',
    // 'openid',
    // 'email'
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
    $response = $this->getHttpClient()->get(
      'https://api.line.me/v2/profile',
      [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
        ],
      ]
    );
    return json_decode($response->getBody()->getContents(), true);
  }

  protected function mapUserToObject(array $user)
  {
    return (new User())->setRaw($user)->map([
      'id' => $user['userId'] ?? $user['sub'] ?? null,
      'nickname' => null,
      'name' => $user['displayName'] ?? $user['name'] ?? null,
      'avatar' => $user['pictureUrl'] ?? $user['picture'] ?? null,
      'email' => $user['email'] ?? null,
    ]);
  }

  protected function parseAccessToken($body)
  {
    return json_decode($body, true);
  }
}
