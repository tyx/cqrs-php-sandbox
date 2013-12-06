<?php

namespace Afsy\Bundle\BlackjackBundle\Controller;

use Rhumsaa\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Afsy\Domain\Blackjack\Command\DealCardCommand;
use Afsy\Domain\Blackjack\Command\StartGameCommand;
use Afsy\Domain\Blackjack\Command\StopDealCardCommand;

class GameController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AfsyBlackjackBundle:Game:index.html.twig');
    }

    public function showAction($id)
    {
        $game = $this
            ->get('doctrine')
            ->getRepository('Afsy\Bundle\BlackjackBundle\Entity\Game')
            ->find(Uuid::fromString($id))
        ;

        return $this->render('AfsyBlackjackBundle:Game:show.html.twig', ['game' => $game]);
    }

    public function startAction(Request $request)
    {
        $gameId = Uuid::uuid1();

        $this->get('command_bus')->handle(new StartGameCommand($gameId, 2));

        return $this->redirect($this->generateUrl('game_show', ['id' => $gameId]));
    }

    public function continueAction($id)
    {
        $id = Uuid::fromString($id);

        $this->get('command_bus')->handle(new DealCardCommand($id));

        return $this->redirect($this->generateUrl('game_show', ['id' => $id]));
    }

    public function stopAction($id)
    {
        $id = Uuid::fromString($id);

        $this->get('command_bus')->handle(new StopDealCardCommand($id));

        return $this->redirect($this->generateUrl('game_show', ['id' => $id]));
    }
}
