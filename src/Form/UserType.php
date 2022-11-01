<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    public function __construct(private AuthorizationCheckerInterface $accessControl)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
//                'maxlength' => 25,
                ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => $options['require_password'],
//                'maxlength' => 64,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
            ])
            ->add('email', EmailType::class, ['label' => 'Adresse email']);
        if ($this->accessControl->isGranted('ROLE_ADMIN')) {
            $builder->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => [
                    'Utilisateur/rice' => 'ROLE_USER',
                    'Administrateur/rice' => 'ROLE_ADMIN'
                ],
            ]);
            $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    if (in_array('ROLE_ADMIN', $rolesArray)) {
                        return 'ROLE_ADMIN';
                    }
                    return 'ROLE_USER';
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            ));
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPostSetData']
            );
        }
    }

    public function onPostSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();
        if ($data) {
            if ($data instanceof User) {
                if ($data->getPassword() === null) {
                    return;
                }
            }
            $form->remove('password');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'require_password' => false,
        ]);
        $resolver->setAllowedTypes('require_password', 'bool');
    }
}
