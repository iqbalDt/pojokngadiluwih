<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as LaravelAuthenticatable;
use Kreait\Laravel\Firebase\Auth\User as FirebaseUser;

/**
 * Wrapper for a Firebase authenticated user.
 *
 * Laravel's `auth()->user()` will return an instance of this class.
 * It implements the `Authenticatable` contract by delegating to the
 * underlying `FirebaseUser` object.
 */
class User implements LaravelAuthenticatable
{
    /** @var FirebaseUser */
    public $firebaseUser;

    public function __construct(FirebaseUser $firebaseUser)
    {
        $this->firebaseUser = $firebaseUser;
    }

    public function getAuthIdentifierName()
    {
        return 'uid';
    }

    public function getAuthIdentifier()
    {
        return $this->firebaseUser->uid();
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value) {}

    public function getRememberTokenName()
    {
        return null;
    }

    public function __get($name)
    {
        return $this->firebaseUser->__get($name);
    }

    public function __call($method, $parameters)
    {
        return $this->firebaseUser->$method(...$parameters);
    }

    public function __toString(): string
    {
        return $this->firebaseUser->email() ?? $this->firebaseUser->uid();
    }
}
