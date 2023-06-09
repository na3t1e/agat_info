<?php

namespace App\Form;

use App\Entity\Feedback;
use Sbyaute\StarRatingBundle\Form\StarRatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class FeedbackType extends AbstractType
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
            ->add('name', TextType::class,[
                'label' => $this->translator->trans('general.name')
            ])
            ->add('text', TextareaType::class,[
                'label' => $this->translator->trans('general.text')
            ])
            ->add('rating', NumberType::class, [
                'required' => false,
                'label' => $this->translator->trans('general.rating')])
            ->add('images', FileType::class, [
                'multiple' => 'multiple',
                'required' => false,
                'mapped' => false,
                'label' => $this->translator->trans('general.images')]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
