<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=20, unique=true)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="pw", type="string", length=255)
     */
    private $pw;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20)
     */
    private $role;


    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->usuario;
    }
    public function getPassword()
    {
        // TODO: Implement getUsername() method.
        return $this->pw;
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return array($this->getRole());
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString()
    {
        return $this->getUsuario();
    }

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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set pw
     *
     * @param string $pw
     *
     * @return Usuario
     */
    public function setPw($pw)
    {
        $this->pw = $pw;

        return $this;
    }

    /**
     * Get pw
     *
     * @return string
     */
    public function getPw()
    {
        return $this->pw;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     *
     * @return Usuario
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get admin
     *
     * @return bool
     */
    public function getRole()
    {
        return $this->role;
    }
}

