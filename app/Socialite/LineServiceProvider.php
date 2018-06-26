<?php

namespace App\Socialite;

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class LineServiceProvider extends SocialiteServiceProvider
{
  public function register()
  {
    $this->app->singleton(Factory::class, function($app) {
      return new LineManager($app);
    });
  }
}