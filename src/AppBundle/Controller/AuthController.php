<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class AuthController
 */
class AuthController extends Controller
{
    /**
     * @Rest\Route("/api/auth", name="auth", methods={"POST"})
     */
    public function postAuthAction(Request $request)
    {
        $data = (array) json_decode($request->getContent());

        if (!empty($data['email'])) {
            /** @var User $user */
            $user = $this
                ->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $data['email']])
            ;

            if (!$user) {
                throw $this->createNotFoundException();
            }

            $isValid = $this
                ->get('security.password_encoder')
                ->isPasswordValid($user, $data['password']);

            if (!$isValid) {
                throw new BadCredentialsException();
            }

            $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
                    'email' => $user->getEmail(),
                    'exp' => time() + 3600 // 1 hour expiration
                ]);

        } else {
            throw new BadRequestHttpException("Invalid Json body.");
        }

        return new JsonResponse(['token' => $token]);
    }
}
