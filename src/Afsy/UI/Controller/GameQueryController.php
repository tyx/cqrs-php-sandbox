<?php

namespace Afsy\UI\Controller;

use Rhumsaa\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Afsy\App\GameViewQuery;

class GameQueryController
{
    private $gameViewQuery;

    private $templating;

    public function __construct(GameViewQuery $gameViewQuery, EngineInterface $templating)
    {
        $this->gameViewQuery = $gameViewQuery;
        $this->templating = $templating;
    }

    public function indexAction()
    {
        return $this->templating->renderResponse('AfsyBlackjackBundle:Game:index.html.twig');
    }

    public function showAction($id)
    {
        $g = $this->gameViewQuery->requestGameView(Uuid::fromString($id));

        return $this->templating->renderResponse(
            'AfsyBlackjackBundle:Game:show.html.twig',
            [
                'game' => $g
            ]
        );
    }
}
