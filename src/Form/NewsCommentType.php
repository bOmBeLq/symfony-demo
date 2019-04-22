<?php

namespace App\Form;

use App\Entity\NewsComment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsCommentType extends AbstractType
{

    /**
     * @var AuthorizationCheckerInterface
     */
    private $auth;

    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (!$this->auth->isGranted(User::ROLE_USER)) {
            $builder->add('author', null, [
                'attr' => [
                    'placeholder' => 'Author'
                ],
                'label' => false,
                'required' => true,
                // we are setting NotBland constraint here instead of in entity because field is added dynamically
                // so we would have to play with validation groups to make this field validate only in case user is not logged
                // simpler to just do it here
                'constraints' => [new NotBlank()]
            ]);
        }
        $builder->add('content', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Content'
            ],
            'label' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsComment::class,
        ]);
    }
}
