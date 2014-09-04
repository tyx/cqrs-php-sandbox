<?php

namespace Afsy\UI\Controller;

use LiteCQRS\Commanding\CommandBus;
use Rhumsaa\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

use Afsy\App\Command;

class GameCommandController
{
    private $commandBus;

    private $router;

    public function __construct(CommandBus $commandBus, RouterInterface $router)
    {
        $this->commandBus = $commandBus;
        $this->router = $router;
    }

    public function startAction()
    {
        $id = Uuid::uuid1();

        $this->commandBus->handle(new Command\StartGameCommand($id, 2));

        return $this->renderGameShow($id);
    }

    public function continueAction($id)
    {
        $id = Uuid::fromString($id);

        $this->commandBus->handle(new Command\DealCardCommand($id));

        return $this->renderGameShow($id);
    }

    public function stopAction($id)
    {
        $id = Uuid::fromString($id);

        $this->commandBus->handle(new Command\StopDealCardCommand($id));

        return $this->renderGameShow($id);
    }

    private function renderGameShow($gameId)
    {
        return new RedirectResponse(
            $this->router->generate('game_show', ['id' => $gameId])
        );
    }
}
