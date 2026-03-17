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
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'scale' => 2,
                'html5' => true,
            ])
            ->add('vatAmount', NumberType::class, [
                'label' => 'VAT amount',
                'scale' => 2,
                'html5' => true,
            ])
            ->add('totalWithVat', NumberType::class, [
                'label' => 'Total with VAT',
                'scale' => 2,
                'html5' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLine::class,
        ]);
    }
}
