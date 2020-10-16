<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Request\Game\StartGameRequest;
use App\Service\Game\StartGameService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StartGameController extends AbstractController
{
    /**
     * @var StartGameService
     */
    private $service;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(StartGameService $service, ValidatorInterface $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @Rest\Post(path="/api/v1/games")
     */
    public function execute(Request $httpRequest): View
    {
        $this->validateRequest($httpRequest);

        $request = new StartGameRequest();
        $body = $this->getBody($httpRequest);
        if (isset($body['board'])) {
            $request->setBoard($body['board']);
        }

        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return View::create($this->service->start($request), Response::HTTP_CREATED);
    }
}
