<?php
namespace Anaxago\CoreBundle\Manager;

use Anaxago\CoreBundle\Entity\Interest;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class ProjectManagerException extends \Exception
{}

class ProjectManager
{
    private $entityManager;
    private $interestRepository;
    private $userRepository;
    private $projectRepository;

    public function __construct (EntityManagerInterface $entityManager, Registry $doctrine) {
        $this->entityManager = $entityManager;
        $this->interestRepository = $doctrine->getRepository(Interest::class);
        $this->userRepository = $doctrine->getRepository(Project::class);
        $this->projectRepository = $doctrine->getRepository(User::class);
    }

    /**
     * Defined a project as founded
     * @param integer $idProject
     *
     * @return array
     */
    public function validateProject($idProject) {
        if ($idProject > 0) {
            $project = $this->projectRepository->find($idProject);
            //TODO : récupérer la somme des dons et si > founing, alors mettre le champs founded à true et envoyer les emails à chaque participant
        } else {
            throw new ProjectManagerException("Invalid argument : can't find project with id ".$idProject, 1);
        }
    }
}
