<?php
namespace Anaxago\CoreBundle\Manager;

use Anaxago\CoreBundle\Entity\Interest;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class InterestManagerException extends \Exception
{}

class InterestManager
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
     * Create one interest
     * @param array $params
     *
     * @return Interest
     */
    public function createInterest($params) {
        if (array_key_exists('idUser', $params) && $params['idUser'] > 0
            && array_key_exists('idProject', $params) && $params['idProject'] > 0
            && array_key_exists('amount', $params) && $params['amount'] > 0) {

            //check parameters
            $user = $this->userRepository->find($params['idUser']);
            if (!$user) {
                throw new InterestManagerException("Invalid argument : can't find user with id ".$params['idUser'], 1);
            }

            $project = $this->projectRepository->find($params['idProject']);
            if (!$project) {
                throw new InterestManagerException("Invalid argument : can't find project with id ".$params['idProject'], 1);
            }

            //parameters ok, we create Interest
            $interest = new Interest();
            $interest->setIdUser($params['idUser']);
            $interest->setIdProject($params['idProject']);
            $interest->setAmount($params['amount']);

            $this->entityManager->persist($interest);
            $this->entityManager->flush();

            return $interest;
        } else {
            throw new InterestManagerException("Invalid argument : interest has not been created", 1);
        }
    }

    /**
     * Returns all interest from a user
     * @param integer $idUser
     *
     * @return array
     */
    public function getInterestByUser($idUser) {
        if ($idUser > 0) {
            return $this->interestRepository->findAllByUser($idUser);
        } else {
            throw new InterestManagerException("Invalid argument : can't find user with id ".$idUser, 1);
        }
    }
}
