<?php

namespace App\Controller;

use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'game')]
    public function index(Request $request, GameService $game): Response
    {
        $requestContent = json_decode($request->getContent());
        $gameStatus = $game->play($requestContent->board, 'x');
        return $this->json($gameStatus);
    }
}
