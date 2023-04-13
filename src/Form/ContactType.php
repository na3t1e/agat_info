<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number1', TextType::class, ['required' => false])
            ->add('number2', TextType::class, ['required' => false])
            ->add('email', TextType::class, ['required' => false])
            ->add('tg', TextType::class, ['required' => false])
            ->add('wa', TextType::class, ['required' => false])
            ->add('workTime', TextType::class, ['required' => false])
            ->add('address', TextType::class, ['required' => false])
            ->add('area', TextType::class, ['required' => false])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
