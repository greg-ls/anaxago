<?php declare(strict_types = 1);

namespace Anaxago\CoreBundle\Listener\Doctrine;

use Anaxago\CoreBundle\Entity\Interest;
use Anaxago\CoreBundle\Manager\InterestManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * User: gls
 * Date: 03/02/18
 */
class ProjectFoundedListener implements EventSubscriber
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $interestManager;

    /**
     * ProjectFoundedListener constructor.
     *
     * @param InterestManager $interestManager
     */
    public function __construct(/*InterestManager $interestManager*/)
    {
        //$this->interestManager = $interestManager;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return ['postPersist', 'postUpdate'];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        // we only listen User entity
        if (!$entity instanceof User) {
            return;
        }

        $this->validateProjectFounded($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        // we only listen User entity
        if (!$entity instanceof Interest) {
            return;
        }

        $this->validateProjectFounded($entity);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(\get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    /**
     * @param User $user
     */
    private function validateProjectFounded(Interest $interest): void
    {
        if (!$interest->getFounded()) {
            return;
        }

        //méthode qui doit calculer la somme des sommes investies et qui met à jour le champs founded du project si cette somme atteint le champs founding
        $this->interestManager->validateProject();
    }
}
