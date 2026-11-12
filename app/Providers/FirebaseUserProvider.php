<?php

namespace App\Providers;

use App\Services\FirebaseService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class FirebaseUserProvider implements UserProvider
{
    public function __construct(private FirebaseService $firebase) {}

    public function retrieveById(mixed $identifier): ?Authenticatable
    {
        if (! is_string($identifier) && ! is_int($identifier)) {
            return null;
        }

        return $this->firebase->findAdminById((string) $identifier);
    }

    /** @param string $token */
    public function retrieveByToken(mixed $identifier, #[\SensitiveParameter] $token): ?Authenticatable
    {
        if (! is_string($token)) {
            return null;
        }

        $user = $this->retrieveById($identifier);
        $rememberToken = $user?->getRememberToken();

        if (! is_string($rememberToken) || ! hash_equals($rememberToken, $token)) {
            return null;
        }

        return $user;
    }

    /** @param string $token */
    public function updateRememberToken(Authenticatable $user, #[\SensitiveParameter] $token): void
    {
        if (! is_string($token)) {
            throw new InvalidArgumentException('The remember token must be a string.');
        }

        $this->firebase->updateAdminRememberToken((string) $user->getAuthIdentifier(), $token);
    }

    public function retrieveByCredentials(#[\SensitiveParameter] array $credentials): ?Authenticatable
    {
        $email = $credentials['email'] ?? null;

        if (! is_string($email)) {
            return null;
        }

        return $this->firebase->findAdminByEmail($email);
    }

    public function validateCredentials(Authenticatable $user, #[\SensitiveParameter] array $credentials): bool
    {
        $password = $credentials['password'] ?? null;
        $passwordHash = $user->getAuthPassword();

        return is_string($password)
            && is_string($passwordHash)
            && $passwordHash !== ''
            && Hash::check($password, $passwordHash);
    }

    public function rehashPasswordIfRequired(
        Authenticatable $user,
        #[\SensitiveParameter] array $credentials,
        bool $force = false,
    ): void {
        $password = $credentials['password'] ?? null;
        $passwordHash = $user->getAuthPassword();

        if (! is_string($password) || ! is_string($passwordHash) || $passwordHash === '') {
            return;
        }

        if (! $force && ! Hash::needsRehash($passwordHash)) {
            return;
        }

        $this->firebase->updateAdminPassword(
            (string) $user->getAuthIdentifier(),
            Hash::make($password),
        );
    }
}
