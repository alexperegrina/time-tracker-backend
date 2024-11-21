<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Infrastructure\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthenticationSuccessListener
{
    public function __construct(private readonly JWTTokenManagerInterface $jwtManager)
    {}

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $token = $event->getData()['token'];
        $tokenJwt = $this->jwtManager->parse($token);
        $ttl = $tokenJwt['exp'] - $tokenJwt['iat'];

        $data = [
            'token_type' => 'Bearer',
            'expires_in' => $ttl,
            'access_token' => $token,
        ];

        $event->setData($data);
    }
}