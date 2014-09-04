<?php

namespace Afsy\Blackjack\Infra\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Afsy\Blackjack\Domain\Model\GameView;
use Afsy\Blackjack\Domain\Repository\GameViewRepository;

class ORMGameViewRepository implements GameViewRepository
{
    private $om;

    private $internalRepository;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->internalRepository = $om->getRepository('Afsy\Blackjack\Domain\Model\GameView');
    }

    public function find($id)
    {
        return $this->internalRepository->find($id);
    }

    public function save(GameView $gameView)
    {
        $this->om->persist($game);
        $this->om->flush();
    }
}
