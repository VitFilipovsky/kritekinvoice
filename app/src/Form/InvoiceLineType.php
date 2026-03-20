<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\InvoiceLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceLineType extends AbstractType
{
    const string INPUT_DESCRIPTION = 'description';
    const string INPUT_QUANTITY = 'quantity';
    const string INPUT_AMOUNT = 'amount';
    const string INPUT_VAT_AMOUNT = 'vatAmount';
    const string INPUT_TOTAL_WITH_VAT = 'totalWithVat';

    const string LABEL_DESCRIPTION = 'Description';
    const string LABEL_QUANTITY = 'Quantity';
    const string LABEL_AMOUNT = 'Amount';
    const string LABEL_VAT_AMOUNT = 'VAT amount (%)';
    const string LABEL_TOTAL_WITH_VAT = 'Total with VAT';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::INPUT_DESCRIPTION, TextareaType::class, [
                'label' => self::LABEL_DESCRIPTION,
                'required' => false,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 2,
                    'placeholder' => 'Item or service description (optional)',
                ],
                'row_attr' => ['class' => 'col-12 mb-3'],
            ])
            ->add(self::INPUT_QUANTITY, IntegerType::class, [
                'label' => self::LABEL_QUANTITY,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'data-invoice-line-total-target' => self::INPUT_QUANTITY,
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add(self::INPUT_AMOUNT, NumberType::class, [
                'label' => self::LABEL_AMOUNT,
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'data-invoice-line-total-target' => self::INPUT_AMOUNT,
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add(self::INPUT_VAT_AMOUNT, NumberType::class, [
                'label' => self::LABEL_VAT_AMOUNT,
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'data-invoice-line-total-target' => self::INPUT_VAT_AMOUNT,
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add(self::INPUT_TOTAL_WITH_VAT, NumberType::class, [
                'label' => self::LABEL_TOTAL_WITH_VAT,
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control bg-light',
                    'readonly' => true,
                    'data-invoice-line-total-target' => self::INPUT_TOTAL_WITH_VAT,
                ],
                'row_attr' => ['class' => 'col-md-6 mb-0'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLine::class,
            'attr' => ['class' => 'row g-2'],
        ]);
    }
}
