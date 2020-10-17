<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Request\Game\DeleteGameRequest;
use App\Service\Game\DeleteGameService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteGameController extends AbstractController
{
    /**
     * @var DeleteGameService
     */
    private $service;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(DeleteGameService $service, ValidatorInterface $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @Rest\Delete(path="/api/v1/games/{gameId}")
     */
    public function execute(string $gameId, Request $httpRequest): View
    {
        $this->validateRequest($httpRequest);

        $request = (new DeleteGameRequest())->setGameId($gameId);
        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }
        $this->service->delete($request);

        return View::create(null, Response::HTTP_OK);
    }
}
