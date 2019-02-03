<?php
namespace Anaxago\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class InterestException extends \Exception
{}

/**
 * @ORM\Entity(repositoryClass="Anaxago\CoreBundle\Repository\InterestRepository")
 * @ORM\Table(name="interest")
 */
class Interest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")}
     * )
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Project")
     * @ORM\JoinTable(name="project",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")}
     * )
     * @ORM\Column(type="integer")
     */
    private $idProject;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $amount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param int $idUser
     *
     * @return Project
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idProject
     *
     * @param int $idProject
     *
     * @return Project
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;

        return $this;
    }

    /**
     * Get idProject
     *
     * @return int
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * Set amount
     *
     * @param int $amount
     *
     * @return Project
     */
    public function setAmount($amount)
    {
        if ($amount <= 0) {
            throw new InterestException("Amount must be > 0", 1);
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
