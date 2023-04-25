<?php

namespace App\Form;

use App\Entity\Feedback;
use Sbyaute\StarRatingBundle\Form\StarRatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;

class FeedbackWriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,)
            ->add('text', TextareaType::class, [
                'help' => 'Осталось символов: 1000',
                'attr' => [
                    'rows' => 7,
                ],
                'constraints' => [
                    new Length([
                        'max' => 1000,
                    ])
                ]])
            ->add('rating',  StarRatingType::class,[
                'required' => false,
                'stars' => 5,
            ])
            ->add('image', FileType::class,[
                'multiple' => 'multiple',
                'required' => false,
                'mapped' => false,
                'help' => 'Максимальное количество фотографий: 3 (выбрано: 0)',
                'constraints' => [
                    new All(new Image([
                        'maxSize' => "5M"
                    ])),
                    new Count(null, null, 3)],
            ])
            ->add('status', TextType::class,)
            ->add('createAt', HiddenType::class, [
                'required' => false
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
