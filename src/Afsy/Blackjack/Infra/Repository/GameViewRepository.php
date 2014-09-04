<?php

namespace Afsy\Blackjack\Infra\Repository;

class GameViewRepository
{
    private $em;

    private $internalRepository;

    public function __construct($em)
    {
        $this->em = $em;
        $this->internalRepository = $em->getRepository('Afsy\Blackjack\Domain\Model\GameView');
    }

    public function find($id)
    {
        return $this->internalRepository->find($id);
    }
}
