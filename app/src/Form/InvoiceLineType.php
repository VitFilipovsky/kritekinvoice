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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 2,
                    'placeholder' => 'Item or service description (optional)',
                ],
                'row_attr' => ['class' => 'col-12 mb-3'],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'data-invoice-line-total-target' => 'quantity',
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'data-invoice-line-total-target' => 'amount',
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add('vatAmount', NumberType::class, [
                'label' => 'VAT amount',
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'data-invoice-line-total-target' => 'vatAmount',
                ],
                'row_attr' => ['class' => 'col-md-4 mb-3'],
            ])
            ->add('totalWithVat', NumberType::class, [
                'label' => 'Total with VAT',
                'scale' => 2,
                'html5' => true,
                'label_attr' => ['class' => 'form-label fw-semibold'],
                'attr' => [
                    'class' => 'form-control bg-light',
                    'readonly' => true,
                    'data-invoice-line-total-target' => 'totalWithVat',
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
