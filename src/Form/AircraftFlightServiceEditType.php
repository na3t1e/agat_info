<?php

namespace App\Form;

use App\Entity\AircraftMaintenanceServiceEntity;
use App\Entity\FlightServiceEntity;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class AircraftFlightServiceEditType extends AbstractType

{

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
            ->add('title', TextType::class, [
                'label' => $this->translator->trans('general.name')])
            ->add('description', CKEditorType::class, [
                'required' => false,
                'label' => $this->translator->trans('general.description')])
            ->add('isVisible', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Да' => true,
                    'Нет' => false,
                ],
                'label' => $this->translator->trans('general.isVisible')])
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [new Image([
                    'maxRatio' => 16 / 9,
                    'minRatio' => 16 / 9,
                    'maxRatioMessage' => 'Соотношение сторон должно быть 16:9',
                    'minRatioMessage' => 'Соотношение сторон должно быть 16:9'])],
                'label' => $this->translator->trans('general.images')])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-dark-green bg-gradient text-white'
                ],
                'label' => $this->translator->trans('general.save')]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightServiceEntity::class,
        ]);
    }
}
