<?php

namespace App\Form;

use App\Entity\Contact;

use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderType extends AbstractType
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
            ->add('fio', TextType::class, ['required' => true,
                'label' => $this->translator->trans('general.fio')])
            ->add('phone', TextType::class, ['required' => true,
                'label' => $this->translator->trans('general.phone')])
            ->add('email', EmailType::class, ['required' => true,
                'label' => $this->translator->trans('general.email')])
            ->add('serviceType', TextType::class, [
                'required' => true,
                'label' => $this->translator->trans('general.serviceType')
            ])
            ->add('save', SubmitType::class, ['label' => $this->translator->trans('general.save')]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
