<?php

namespace App\Auth;

use Cake\Chronos\Chronos;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

final class JwtAuth
{
    private string $issuer;

    private int $lifetime;

    private string $privateKey;

    private string $publicKey;

    private Sha256 $signer;

    public function __construct(
        string $issuer,
        int $lifetime,
        string $privateKey,
        string $publicKey
    )
    {
        $this->issuer = $issuer;
        $this->lifetime = $lifetime;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->signer = new Sha256();
    }

    public function getLifetime(): int
    {
        return $this->lifetime;
    }

    public function createJwt(array $claims): string
    {
        $issuedAt = Chronos::now()->getTimestamp();

        $builder = (new Builder())->issuedBy($this->issuer)
            ->identifiedBy(uuid_create(), true)
            ->issuedAt($issuedAt)
            ->canOnlyBeUsedAfter($issuedAt)
            ->expiresAt($issuedAt + $this->lifetime);

        foreach ($claims as $name => $value) {
            $builder = $builder->withClaim($name, $value);
        }

        return $builder->getToken($this->signer, new Key($this->privateKey));
    }

    public function createParsedToken(string $token): Token
    {
        return (new Parser())->parse($token);
    }

    public function validateToken(string $accessToken): bool
    {
        $token = $this->createParsedToken($accessToken);

        if (!$token->verify($this->signer, $this->publicKey)) {
            return false;
        }

        $data = new ValidationData();
        $data->setCurrentTime(Chronos::now()->getTimestamp());
        $data->setIssuer($token->getClaim('iss'));
        $data->setId($token->getClaim('jti'));

        return $token->validate($data);
    }
}
