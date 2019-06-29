<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordEdit
{

    private $oldPassword;

    /**
     * @Assert\Length(
     *     min="6",
     *     minMessage="Votre mot de passe doit contenir au minimum 6 caractères !",
     *     max="12",
     *     maxMessage="Votre mot de passe doit contenir au maximum 12 caractères !"
     * )
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous n'avez pas confirmé correctement votre nouveau mot de passe !")
     */
    private $passwordConfirm;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }
}
