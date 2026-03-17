<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly InvoiceRepository $invoiceRepository,
    ) {
    }

    #[Route('/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $invoice = new Invoice();
        $invoice->setInvoiceDate(new \DateTimeImmutable('today'));

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();

            $this->addFlash('success', 'Invoice created successfully.');

            return $this->redirectToRoute('app_invoice_show', ['id' => $invoice->getId()]);
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
        ]);
    }
}
