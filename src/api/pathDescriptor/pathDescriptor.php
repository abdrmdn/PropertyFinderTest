<?php
namespace PropertyFinder\api\pathDescriptor;

use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCards;

class pathDescriptor
{
    const ARRIVED_TO_YOUR_DESTINATION = 'You have arrived at your final destination';

    /**
     * @param BoardingCards $boardingCards
     *
     * @return array
     * @throws boardingCards\exceptions\BoardingCardBrokenChainException
     */
    public function describeUnorderedBoardingCards(BoardingCards $boardingCards) : array
    {
        if (count($boardingCards->toArray()) == 0) {
            return [];
        }
        $boardingCards->orderCards();

        return $this->describeCards($boardingCards);
    }

    /**
     * @param BoardingCards $boardingCards
     *
     * @return array
     */
    private function describeCards(BoardingCards $boardingCards) : array
    {
        $humanlyDescribedCards = [];
        foreach ($boardingCards->toArray() as $boardingCard) {
            $humanlyDescribedCards[] = (string)$boardingCard;
        }
        $humanlyDescribedCards[] = $this->addArrivedDestinationAppendix();

        return $humanlyDescribedCards;
    }

    /**
     * @return string
     */
    private function addArrivedDestinationAppendix() : string
    {
        return self::ARRIVED_TO_YOUR_DESTINATION;
    }

    private function describeACard($boardingCard)
    {

    }
}
