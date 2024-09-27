<?php

namespace App\Controller;

use App\DTO\BadResponseDTO;
use App\DTO\CalculatePriceDTO;
use App\Service\BusinessLogic\CalculatePriceService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class CalculatePrice extends AbstractController
{
    /**
     * @param LoggerInterface $logger
     * @param CalculatePriceService $calculatePriceService
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CalculatePriceService $calculatePriceService,
    ) {
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route(
        path: '/calculate-price',
        name: 'calculate-price',
        methods: ['POST']
    )]
    public function calculateProductPrice(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response {
        try {
            $data = $serializer->deserialize(
                data: $request->getContent(),
                type: CalculatePriceDTO::class,
                format: 'json'
            );

            $data->validate($validator);

            return $this->json(
                data: [
                    'price' => $this->calculatePriceService->calculatePrice($data),
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