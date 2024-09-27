<?php

namespace App\Controller;

use App\DTO\BadResponseDTO;
use App\DTO\PurchaseDTO;
use App\Service\BusinessLogic\PaymentService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class Purchase extends AbstractController
{
    /**
     * @param LoggerInterface $logger
     * @param PaymentService $paymentService
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly PaymentService $paymentService,
    ) {
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route(
        path: '/purchase',
        name: 'purchase',
        methods: ['POST']
    )]
    public function purchaseOrder(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response {
        try {
            $data = $serializer->deserialize(
                data: $request->getContent(),
                type: PurchaseDTO::class,
                format: 'json'
            );

            $data->validate($validator);

            $this->paymentService->processPayment($data);

            return $this->json(
                data: [
                    'status' => true,
                ],
                status: Response::HTTP_OK,
            );
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->json(
                data: new BadResponseDTO(
                    status: false,
                    errors: [$throwable->getMessage()]
                ),
                status: Response::HTTP_BAD_REQUEST,
            );
        }
    }
}