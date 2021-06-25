<?php

namespace App\Controller\api;

use App\Entity\UserAccount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserAccountController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Retourne la liste des comptes utilisateur
     * @Route("/api/v1/accounts", methods={"GET"}, name="api_v1_accounts_list")
     */
    public function listUserAccount(): JsonResponse
    {
        $userAccounts = $this->getDoctrine()->getRepository(UserAccount::class)->findAll();
        $response['data'] = [];
        foreach ($userAccounts as $userAccount) {
            $response['data'][] = $this->getUserAccountArraySerialized($userAccount);
        }
        return new JsonResponse($response);
    }

    /**
     * Retourne le compte utilisateur demandé
     * @Route("/api/v1/account/{uid}", methods={"GET"}, name="api_v1_account_get_by_uid")
     */
    public function getUserAccountByUid(string $uid): JsonResponse
    {
        $userAccount = $this->getDoctrine()->getRepository(UserAccount::class)->findOneBy(['uid' => $uid]);
        if (null !== $userAccount) { 
            return new JsonResponse([
                'data' => $this->getUserAccountArraySerialized($userAccount),
            ]);
        } else {
            return new JsonResponse([
                    'error' => 'User not found!'
                ],
                404
            );
        }
    }

    /**
     * Ajoute un compte utilisateur
     * @Route("/api/v1/account", methods={"POST"}, name="api_v1_account_add")
     */
    public function addUserAccount(): JsonResponse
    {
        $doctrine = $this->getDoctrine();
        $userAccount = $doctrine->getRepository(UserAccount::class)->findOneBy(['uid' => $uid]);
        if (null !== $userAccount) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($userAccount);
            $entityManager->flush();
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse([
                    'error' => 'User not found!'
                ],
                404
            );
        }
    }

    /**
     * Supprime un compte utilisateur
     * @Route("/api/v1/account/{uid}", methods={"DELETE"}, name="api_v1_account_delete_by_uid")
     */
    public function deleteUserAccount(string $uid): JsonResponse
    {
        $doctrine = $this->getDoctrine();
        $userAccount = $doctrine->getRepository(UserAccount::class)->findOneBy(['uid' => $uid]);
        if (null !== $userAccount) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($userAccount);
            $entityManager->flush();
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse([
                    'error' => 'User not found!'
                ],
                404
            );
        }
    }


    /**
     * Retourne un objet stdClass représentant les données sérialisées
     */
    private function getUserAccountArraySerialized(UserAccount $userAccount, string $group = 'user_account_show'): \stdClass
    {
        return json_decode($this->serializer->serialize(
            $userAccount,
            'json',
            [
                'groups' => $group,
            ]
        ));
    }
}