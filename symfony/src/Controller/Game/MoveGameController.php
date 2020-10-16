<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Request\Game\MoveGameRequest;
use App\Service\Game\MoveGameService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MoveGameController extends AbstractController
{
    /**
     * @var MoveGameService
     */
    private $service;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(MoveGameService $service, ValidatorInterface $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @Rest\Put(path="/api/v1/games/{gameId}")
     */
    public function execute(string $gameId, Request $httpRequest): View
    {
        $this->validateRequest($httpRequest);

        $request = (new MoveGameRequest())->setGameId($gameId);
        $body = $this->getBody($httpRequest);
        if (isset($body['board'])) {
            $request->setBoard($body['board']);
        }

        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return View::create($this->service->move($request), Response::HTTP_CREATED);
    }
}
