<?php

namespace App\Form;

use App\Entity\User5;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    /**
     *  @param string $label
     * @param string $placeholder
     * $param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options=[])
    {
        return array_merge([
            'label' =>$label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options );
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TextType::class, $this->getConfiguration('Name',"Votre nom"))
            ->add('Email',EmailType::class , $this->getConfiguration('Email',"Votre email"))
            ->add('Username',TextType::class,$this->getConfiguration('Username',"Votre username" ))
            ->add('Phone',TextType::class , $this->getConfiguration('numero',"Votre numero"))
            ->add('Password',PasswordType::class, $this->getConfiguration('password',"Votre password")) 
            ->add("passwordconfirm", PasswordType::class);
        
    
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'Name' => 'baha',
            'Email' => 'register-form-email',
            'Username' => 'register-form-username',
            'Phone' => 'register-form-phone',
            'Password' => 'register-form-password',
        ]);
    }
}
