<?php

namespace App\Form;

use App\Entity\MainPage;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\Translation\TranslatorInterface;

class MainPageType extends AbstractType
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
            ->add('mainText', CKEditorType::class,
                [
                    'attr' => [
                        'rows' => 5
                    ],
                    'label' => $this->translator->trans('general.mainText'),
                    'constraints' => [
                        new Length([
                            'max' => 2000,
                        ])
                    ]
                ])
            ->add('advantage1',TextareaType::class,[
                'label' => $this->translator->trans('general.advantage1'),
                'constraints' => [
                    new Length([
                        'max' => 1000,
                    ])
                ]
            ])
            ->add('advantage2',TextareaType::class,[
                'label' => $this->translator->trans('general.advantage2'),
                'constraints' => [
                    new Length([
                        'max' => 1000,
                    ])
                ]
            ])
            ->add('advantage3',TextareaType::class,[
                'label' => $this->translator->trans('general.advantage3'),
                'constraints' => [
                    new Length([
                        'max' => 1000,
                    ])
                ]
            ])
            ->add('images', FileType::class,
                [
                    'multiple' => 'multiple',
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [new All(new Image([
                        'maxRatio' => 16/9,
                        'minRatio' => 16/9,
                        'maxRatioMessage' => 'Соотношение сторон должно быть 16:9',
                        'minRatioMessage' => 'Соотношение сторон должно быть 16:9']))],
                    'label' => $this->translator->trans('general.images'),
                ])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('general.save')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MainPage::class,
        ]);
    }
}
