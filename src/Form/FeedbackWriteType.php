<?php

namespace App\Form;

use App\Entity\Feedback;
use Sbyaute\StarRatingBundle\Form\StarRatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Contracts\Translation\TranslatorInterface;

class FeedbackWriteType extends AbstractType
{
    private TranslatorInterface $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('general.fio'),
                'attr' => [
                    'class' => 'border-blue'
                ],
            ])

            ->add('text', TextareaType::class, [
                'label' => $this->translator->trans('general.text'),
                'help' => 'Осталось символов: 1000',
                'attr' => [
                    'rows' => 7,
                    'class' => 'border-blue'
                ],
                'constraints' => [
                    new Length([
                        'max' => 1000,
                    ])
                ]])
            ->add('rating', StarRatingType::class, [
                'label' => $this->translator->trans('general.rating'),
                'required' => true,
                'stars' => 5,
                'constraints' => [
                    new GreaterThanOrEqual(0),
                    new LessThanOrEqual(5)
                ]
            ])
            ->add('images', FileType::class, [
                'label' => $this->translator->trans('general.images'),
                'multiple' => 'multiple',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'border-blue'
                ],
                'help' => 'Максимальное количество фотографий: 3 (выбрано: 0)',
                'constraints' => [
                    new All(new Image([
                        'maxSize' => "5M"
                    ])),
                    new Count(null, null, 3, null, null, null, 'Максимальное количество фото: 3. Заполните заново')],
            ])
            ->add('status', HiddenType::class, [
                'required' => false
            ])
            ->add('createAt', HiddenType::class, [
                'required' => false
            ])
            ->add('pd_agreement', CheckboxType::class, ['required' => true,
                'label' => $this->translator->trans('general.pd_agreement'),'label_html' => true])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('general.save'),
                'attr' => [
                    'disabled' => true,
                    'class' => 'btn-dark-blue'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
