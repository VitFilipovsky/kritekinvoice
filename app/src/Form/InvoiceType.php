<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('invoiceDate', DateType::class, [
                'label' => 'Invoice date',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('invoiceNumber', IntegerType::class, [
                'label' => 'Invoice number',
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'placeholder' => 'e.g. 1001',
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('customerId', IntegerType::class, [
                'label' => 'Customer ID',
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'placeholder' => 'Customer ID',
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('lines', CollectionType::class, [
                'label' => 'Invoice lines',
                'entry_type' => InvoiceLineType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label_attr' => ['class' => 'form-label fw-semibold fs-5 mt-2'],
                'row_attr' => ['class' => 'mb-0'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            'attr' => [
                'class' => 'needs-validation',
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
