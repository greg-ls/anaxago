<?php
namespace Anaxago\CoreBundle\Manager;

use Anaxago\CoreBundle\Entity\Interest;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class InterestManagerException extends \Exception
{}

class InterestManager
{
    private $entityManager;
    private $interestRepository;

    public function __construct (EntityManagerInterface $entityManager, Registry $doctrine) {
        $this->entityManager = $entityManager;
        $this->interestRepository = $doctrine->getRepository(Interest::class);
    }

    public function createInterest($params) {
        if (isset($params['idUser']) 
            && isset ($params['idProject']) 
            && isset($params['amount'])) {
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

    public function getInterestByUser($idUser) {
        if ($idUser > 0) {
            return $this->interestRepository->findAllByUser($idUser);
        } else {
            throw new InterestManagerException("Invalid argument : can't find user with id ".$idUser, 1);
        }
    }
}
