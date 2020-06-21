<?php

namespace App\Application\Actions\Auth;

class JWTClaims
{
    private string $uid;

    public function __construct(string $username)
    {
        $this->uid = $username;
    }

    public function __invoke(): array
    {
        return get_object_vars($this);
    }
}
