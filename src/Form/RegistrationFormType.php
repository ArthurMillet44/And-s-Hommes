<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //FormBuilderInterface is a form template
        //We used it for a matter of practice and because it allows us to take charge of security.
        $builder
            ->add('surname', TextType::class, [
                'attr' => [
                    //Like an <input> tag, we define the different attributes.
                    'class' => 'input_register',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                    'placeholder' =>'Nom',
                ],
                'label' => false,

                //Constraint
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])

            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'input_register',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                    'placeholder' =>'Prénom',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])

            ->add('dateOfBirth', DateType::class, [
                //?
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'input_register'],
                'label' => 'Date de naissance',
                'label_attr' => ['class' => 'date'],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])

            ->add('email',EmailType::class,[
                'attr' => [
                    'class' => 'input_register',
                    'placeholder' => 'Email',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller

                //?
                'mapped' => false,
                'label'=> false,
                'attr' => [
                    'class' => 'input_register',
                    'autocomplete' => 'new-password',
                    'placeholder' => 'mot de passe',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])


            //?
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label_attr' => [
                    'class' => 'label_term'
                ],
                'attr' => [
                    'class' => 'check_box'
                ],
                'label' => "J'accepte les conditions générales d'utilisations.",
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'bouton_inscrire'
                ],

                'label' => 'S\'inscrire',
            ]);

        ;
    }

    //?
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
