<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\Interest;
use Anaxago\CoreBundle\Manager\InterestManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 *
 * @package Anaxago\CoreBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * Return the list of all projects
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    public function getProjectsAction(EntityManagerInterface $entityManager): JsonResponse
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();
        $response = [];
        foreach ($projects as $project) {
            $response[] = $project->getDataInArray();
        }

        return new JsonResponse([$response]);
    }

    /**
     * Create one interest for a user
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    public function setInterestAction(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        //only for authenticated user
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $interestManager = $this->container->get(InterestManager::class);

        try {
            $interestManager->createInterest(['idUser' => $user->getId(),
                                            'idProject' => $request->request->get('idProject'),
                                            'amount' => $request->request->get('amount')]);

            $response = 'Interest created';
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }

        return new JsonResponse($response);
    }

    /**
     * Return the list of all interests from a user
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    public function getInterestAction(EntityManagerInterface $entityManager): JsonResponse
    {
        //only for authenticated user
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $interestManager = $this->container->get(InterestManager::class);

        try {
            $response = $interestManager->getInterestByUser($user->getId());
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }

        return new JsonResponse($response);
    }
}
