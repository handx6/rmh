<?php

namespace App\Form;

use App\Entity\DevisEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DevisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client_name', TextType::class, [
                'attr' => [
                    'class' => 'form'
                ],
                'label' => "Prénom & Nom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champs obligatoire !'
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 20,
                        'minMessage' => 'Minimum {{ limit }} caractère',
                        'maxMessage' => 'Maximum {{ limit }} caratère',
                    ])
                ]
            ])
            ->add('client_email', EmailType::class, [
                'attr' => [
                    '
                class' => 'form'
                ],
                'label' => "Email",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champs obligatoire !'
                    ])
                ]
            ])

            ->add('demand_type', ChoiceType::class, [
                'attr' => [
                    'class' => 'form'
                ],
                'label' => 'Sélectionne ta demande',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champs obligatoire !'
                    ]),
                ],
                'choices' => [
                    'NFT 1' =>  'NFT 1',
                    'NFT 2' =>  'NFT 2',
                    'NFT 3' =>  'NFT 3',
                    'NFT 4' =>  'NFT 4',
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form',
                    'style' => 'resize: none',
                ],
                'label' => 'Message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champs obligatoire !'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Minmum {{ limit }}',
                        'maxMessage' => 'Maximum {{ limit }}',

                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DevisEntity::class,
        ]);
    }
}
