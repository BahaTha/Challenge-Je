<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints as Assert;


class PasswordUpdate
{
   
   

    
    private $Oldpassword;
    /**
    * @Assert\Length(min=5 , minMessage="at least 5")
    */


    private $NewPassword;

       /**
    * @Assert\EqualTo(propertyPath="NewPassword", message="Please confirm your password")
    */
    private $ConfirmPassword;

  
    public function getOldpassword(): ?string
    {
        return $this->Oldpassword;
    }

    public function setOldpassword(string $Oldpassword): self
    {
        $this->Oldpassword = $Oldpassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->NewPassword;
    }

    public function setNewPassword(string $NewPassword): self
    {
        $this->NewPassword = $NewPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->ConfirmPassword;
    }

    public function setConfirmPassword(string $ConfirmPassword): self
    {
        $this->ConfirmPassword = $ConfirmPassword;

        return $this;
    }
}
