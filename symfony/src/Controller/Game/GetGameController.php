<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Request\Game\GetGameRequest;
use App\Service\Game\GetGameService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetGameController extends AbstractController
{
    /**
     * @var GetGameService
     */
    private $service;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(GetGameService $service, ValidatorInterface $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @Rest\Get(path="/api/v1/games/{gameId}")
     */
    public function execute(string $gameId, Request $httpRequest): View
    {
        $this->validateRequest($httpRequest);

        $request = (new GetGameRequest())->setGameId($gameId);
        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return View::create($this->service->get($request), Response::HTTP_OK);
    }
}
