<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    #[Route('/', name: 'app_customer')]
    public function index(
        Request $request,
        CustomerRepository $customerRepository
    ): Response {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customerRepository->add($customer, true);

            return $this->redirectToRoute('app_customer');
        }

        return $this->renderForm('customer/list.html.twig', [
            'form' => $form,
            'customers' => $customerRepository->findAll(),
        ]);
    }
}
