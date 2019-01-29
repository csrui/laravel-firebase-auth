<?php

namespace csrui\LaravelFirebaseAuth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Firebase\Auth\Token\Verifier;

class FirebaseAuthServiceProvider extends BaseServiceProvider {

  /**
  * Perform post-registration booting of services.
  *
  * @return void
  */
  public function boot()
  {
    $this->publishes([
        __DIR__ . '/config.php' => config_path('firebase.php'),
    ]);
  }

  /**
  * Register bindings in the container.
  *
  * @return void
  */
  public function register()
  {
    $this->app->singleton(Verifier::class, function ($app) {
      return new Verifier(config('firebase.project_id'));
    });
  }

}