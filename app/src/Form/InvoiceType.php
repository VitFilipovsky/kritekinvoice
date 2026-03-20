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
    const string INPUT_INVOICE_DATE = 'invoiceDate';
    const string INPUT_INVOICE_NUMBER = 'invoiceNumber';
    const string INPUT_CUSTOMER_ID = 'customerId';
    const string INPUT_LINES = 'lines';

    const string LABEL_INVOICE_DATE = 'Invoice date';
    const string LABEL_INVOICE_NUMBER = 'Invoice number';
    const string LABEL_CUSTOMER_ID = 'Customer ID';
    const string LABEL_LINES = 'Invoice lines';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::INPUT_INVOICE_DATE, DateType::class, [
                'label' => self::LABEL_INVOICE_DATE,
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add(self::INPUT_INVOICE_NUMBER, IntegerType::class, [
                'label' => self::LABEL_INVOICE_NUMBER,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'placeholder' => 'e.g. 1001',
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add(self::INPUT_CUSTOMER_ID, IntegerType::class, [
                'label' => self::LABEL_CUSTOMER_ID,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'placeholder' => 'Customer ID',
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add(self::INPUT_LINES, CollectionType::class, [
                'label' => self::LABEL_LINES,
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
