<?php

namespace App\Form;

use App\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', null, [
                'mapped' => false,
                'attr' => [
                    'class' => 'd-none'
                ],
                'label_attr' => [
                    'class' => 'd-none'
                ]
            ])
            ->add('name', TextType::class)
            ->add('text', TextareaType::class)
            ->add('rating', StarRatingType::class, [
                'required' => false,
                'stars' => 5,
            ])
            ->add('image', FileType::class, [
                'multiple' => 'multiple',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new All(new Image([
                        'maxSize' => "5M"
                    ])),
                    new Count(null, null, 3)],
                'help' => 'Выбрано файлов: 0',])
            ->add('createAt', DateType::class, [
                'required' => false,
                'input' => 'datetime_immutable',
            ])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('general.save')]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
