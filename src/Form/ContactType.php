<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
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
            ->add('number1', TextType::class, ['required' => false,
                'label' => $this->translator->trans('general.number1')])
            ->add('number2', TextType::class, ['required' => false,
                'label' => $this->translator->trans('general.number2')])
            ->add('email', TextType::class, ['required' => false])
            ->add('tg', TextType::class, ['required' => false, 'label' => $this->translator->trans('general.tg')])
            ->add('wa', TextType::class, ['required' => false, 'label' => $this->translator->trans('general.wa')])
            ->add('workTime', TextType::class, ['required' => false, 'label' => $this->translator->trans('general.workTime')])
            ->add('address', TextType::class, ['required' => false, 'label' => $this->translator->trans('general.address')])
            ->add('area', TextType::class, ['required' => false,'label' => $this->translator->trans('general.area')])
            ->add('save', SubmitType::class, ['label' => $this->translator->trans('general.save')]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
