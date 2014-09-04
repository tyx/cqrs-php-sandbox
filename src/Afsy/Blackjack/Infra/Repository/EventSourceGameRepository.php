<?php

namespace Afsy\Blackjack\Infra\Repository;

use LiteCQRS\EventStore\EventSourceRepository;
use Afsy\Blackjack\Domain\Model\Game;
use Afsy\Blackjack\Domain\Repository\GameRepository;

class EventSourceGameRepository implements GameRepository
{
    private $eventSourceRepository;

    public function __construct(EventSourceRepository $eventSourceRepository)
    {
        $this->eventSourceRepository = $eventSourceRepository;
    }

    public function find($id)
    {
        return $this->eventSourceRepository->find('Afsy\Blackjack\Domain\Model\Game', $id);
    }

    public function save(Game $game)
    {
        $this->eventSourceRepository->save($game);
    }
}
