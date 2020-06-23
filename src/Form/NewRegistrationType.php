<?php

namespace App\Form;

use App\Entity\User5;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class NewRegistrationType extends AbstractType
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
        ->add("name", TextType::class, $this->getConfiguration('name',"your name ..."))
      
            ->add('email', EmailType::class, $this->getConfiguration('email',"exemple : oficina@gmail.com"))
            ->add("username",TextType::class, $this->getConfiguration('username',"your username ..."))
            ->add("phone",TextType::class, $this->getConfiguration('phone',"exemple :(+216) ********"))
            // ->add('roles')
            ->add('Avatar', FileType::class , [
                'label' => 'AVATAR',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Avatar',
                    ])
                ],

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                
            ])
            // ...
        
            ->add('Bio',TextType::class, $this->getConfiguration('bio',"your bio ..."))
            ->add('Field',TextType::class, $this->getConfiguration('Field(if you are a teacher)',"example: Development.."))
           
            ->add('password', PasswordType::class,$this->getConfiguration('password',"********"))
            ->add('passwordconfirm', PasswordType::class,$this->getConfiguration('passwordconfirm',"********"))
          

            
            //->add('userRoles')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User5::class,
        ]);
    }
}
