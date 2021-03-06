<?php

namespace App\Controller;

use App\Exception\ApiException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SecurityController extends BaseController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @param Request $request
     * @param UserProviderInterface $userProvider
     * @param UserPasswordHasherInterface $passwordHasher
     * @param JWTTokenManagerInterface $JWTManager
     *
     * @return JsonResponse
     *
     * @throws ApiException
     */
    public function login(
        Request $request,
        UserProviderInterface $userProvider,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTManager
    ): JsonResponse {
        $identifier = $request->get('email');
        /** @var InMemoryUser $user */
        $user = $userProvider->loadUserByIdentifier($identifier);

        $password = $request->get('password');
        if (!$passwordHasher->isPasswordValid($user, $password)) {
            $this->error('Password is not valid.');
        }

        return $this->success($JWTManager->create($user));
    }
}
