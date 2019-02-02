<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiController
 *
 * @package Anaxago\CoreBundle\Controller
 */
class ApiController extends Controller
{
    /**
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
}
