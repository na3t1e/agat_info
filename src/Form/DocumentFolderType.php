<?php

namespace App\Form;

use App\Entity\DocumentFolder;
use App\Entity\Menu;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class DocumentFolderType extends AbstractType
{

    private TranslatorInterface $translator;

    /**

     * @param TranslatorInterface $translator
     */
    public function __construct( TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    /**
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', null, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'd-none'
                ],
                'label_attr' => [
                    'class' => 'd-none'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('general.title'),
            ])
            ->add('isEnabled', CheckboxType::class,[
                'required' => false,
                'label' => $this->translator->trans('general.isEnabled')
            ])
            ->add('save', SubmitType::class,[
                'label' => $this->translator->trans('general.save')
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentFolder::class,
        ]);
    }
}
