<?php

namespace App\Form;

use App\Entity\AircraftMaintenanceServiceEntity;
use App\Entity\ConsultAircraftServiceEntity;
use App\Entity\FlightServiceEntity;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderFlightType extends AbstractType

{

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FIO', TextType::class, [
                'label' => $this->translator->trans('general.fio')])
            ->add('phone', TextType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.phone')])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.phone')])
            ->add('serviceType', EntityType::class, [
                'required' => true,
                'class' => FlightServiceEntity::class,
                'choice_label' => 'title',
//                'choices' => [
//                    'airChemical' => 'Авиационно-химические работы',
//                    'airPhoto' => 'Воздушные съемки',
//                    'airVisual' => 'Аэровизуальные работы',
//                    'airWood' => 'Лесоавиационные работы',
//                    'airMedical' => 'Работы с целью оказания медицинской помощи',
//                    'airConnection' => 'Транспортно-связные работы',
//                    'other' => 'Другое'
//                ],
                'label' => $this->translator->trans('general.serviceType')])
            ->add('aproxDate', DateType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.aproxDate')])
            ->add('aproxTime', TimeType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.aproxTime')])
            ->add('aproxPlace', TextType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.aproxPlace')])
            ->add('more', TextareaType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.more')])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-dark-blue bg-gradient text-white'
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