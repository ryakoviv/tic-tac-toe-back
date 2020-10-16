<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Service\Game\GetGamesService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetGamesController extends AbstractController
{
    /**
     * @var GetGamesService
     */
    private $service;

    public function __construct(GetGamesService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Get(path="/api/v1/games")
     */
    public function execute(Request $httpRequest): View
    {
        $this->validateRequest($httpRequest);

        return View::create($this->service->get(), Response::HTTP_OK);
    }
}
