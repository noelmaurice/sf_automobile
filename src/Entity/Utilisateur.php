<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 *
 * @UniqueEntity(
 *     fields = {"username"},
 *     message ="Cet identifiant existe déjà"
 * )
 *
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    /**
     * @Assert\EqualTo(propertyPath="password", message="Le mot de passe ne correspond pas")
     */
    private $checkPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return [$this->roles];
    }

    /**
     * @param mixed $roles
     * @return Utilisateur
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getCheckPassword()
    {
        return $this->checkPassword;
    }

    /**
     * @param mixed $checkPassword
     * @return Utilisateur
     */
    public function setCheckPassword($checkPassword)
    {
        $this->checkPassword = $checkPassword;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
