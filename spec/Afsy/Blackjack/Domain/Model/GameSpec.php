<?php

namespace spec\Afsy\Blackjack\Domain\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use LiteCQRS\EventStore\EventStream;
use Rhumsaa\Uuid\Uuid;
use Afsy\Blackjack\Domain\Event\GameCreated;
use Afsy\Blackjack\Domain\Model\Card;
use Afsy\Blackjack\Domain\Model\Player;
use Afsy\Blackjack\Domain\Model\DiscardPile;

class GameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Uuid::uuid1());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Afsy\Blackjack\Domain\Model\Game');
    }

    function it_starts_with_4_cards(DiscardPile $discardPile, Card $card, Player $human, Player $bank)
    {
        $discardPile->dealToPlayer($human, 0)->willReturn($card)->shouldBeCalledTimes(1);
        $discardPile->dealToPlayer($bank, 0)->willReturn($card)->shouldBeCalledTimes(1);
        $discardPile->dealToPlayer($human, 1)->willReturn($card)->shouldBeCalledTimes(1);
        $discardPile->dealToPlayer($bank, 1)->willReturn($card)->shouldBeCalledTimes(1);

        $this->start(array($human, $bank), $discardPile);
    }

    function it_doesnt_allow_to_deal_while_game_is_not_started()
    {
        $this->shouldThrow(new \LogicException('Game should be started.'))->during('dealCard');
    }

    function it_deals_1_card(EventStream $eventStream, DiscardPile $discardPile, Player $human, Player $bank, Card $card)
    {
        $this->givenGameIsCreated($eventStream, $discardPile, $human, $bank);
        $discardPile->dealToPlayer($human, 2)->willReturn($card)->shouldBeCalledTimes(1);

        $this->dealCard();
    }

    private function givenGameIsCreated(EventStream $eventStream, DiscardPile $discardPile, Player $human, Player $bank)
    {
        $eventStream->getUuid()->willReturn(Uuid::uuid1());
        $eventStream->getIterator()->willReturn(
            new \ArrayIterator(array(new GameCreated(array($human->getWrappedObject(), $bank->getWrappedObject()), $discardPile->getWrappedObject(), 2)))
        );
        $this->loadFromEventStream($eventStream);
    }
}
