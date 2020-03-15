<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType,IntegerType, FileType};

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('cost', IntegerType::class)
            ->add('attack', IntegerType::class)
            ->add('HP', IntegerType::class)
            ->add('img', FileType::class)
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => function (Type $type) {
                    return $type->getGender();
                }
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
