<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;



class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Length(min=2, max=50)
     */
    private $nomdefamille;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $prenom;

    /**
     * @var string|null
     * @Assert\Length(min=2, max=50)
     * @Assert\Email()
     */
    private $email;
    /**
     * @var string|null
     * @Assert\Regex(
     *     pattern="/[0-9]{10}/"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Length(min=3)
     */
    private $message;

    /**
     * @return string|null
     */
    public function getNomdefamille(): ?string
    {
        return $this->nomdefamille;
    }

    /**
     * @param string|null $nomdefamille
     * @return Contact
     */
    public function setNomdefamille(?string $nomdefamille): Contact
    {
        $this->nomdefamille = $nomdefamille;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string|null $prenom
     * @return Contact
     */
    public function setPrenom(?string $prenom): Contact
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return Contact
     */
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }



}