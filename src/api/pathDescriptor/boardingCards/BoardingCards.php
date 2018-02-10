<?php
namespace PropertyFinder\api\pathDescriptor\boardingCards;


use PropertyFinder\api\pathDescriptor\boardingCards\exceptions\BoardingCardBrokenChainException;

class BoardingCards
{
    /**
     * @var bool
     */
    private $ordered;

    /**
     * @var array
     */
    private $cards;
    private $originalCards;
    private $cardsConnector;

    const NON_OPTIONAL_FIELDS = [BoardingCardEnum::TYPE, BoardingCardEnum::DESTINATION, BoardingCardEnum::FROM];

    public function __construct()
    {
        $this->cards = [];
        $this->ordered = false;
        $this->cardsConnector[BoardingCardEnum::FROM] = '';
        $this->cardsConnector[BoardingCardEnum::DESTINATION] = '';
    }

    /**
     * @param BoardingCard $card
     *
     * @throws exceptions\BoardingCardMissingFieldException
     */
    public function addCard(BoardingCard $card)
    {
        BoardingCardValidator::validateCard($card);
        $this->ordered = false;
        $this->cards[] = $card;
        $this->connectCard($card);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->cards;
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        $cardsArr = [];
        foreach ($this->cards as $card) {
            $cardsArr[] = $card->getRaw();
        }

        return $cardsArr;
    }

    /**
     * with the process hapening in addCard->connectCard, the complexity should be around ~2n
     * Especialy if we remove unnecessory processes like copying and stuff
     *
     * @throws \PropertyFinder\api\pathDescriptor\boardingCards\exceptions\BoardingCardBrokenChainException
     */
    public function orderCards()
    {
        if (!$this->ordered) {
            $this->originalCards = $this->cards;
            $tmpCardsConnector = $this->cardsConnector;
            if (count($tmpCardsConnector[BoardingCardEnum::DESTINATION]) > 1 ||
                count($tmpCardsConnector[BoardingCardEnum::FROM]) > 1
            ) {
                throw new BoardingCardBrokenChainException();
            }
            $this->cards = [];
            $fromCard = $destCard = $nextCard = '';

            //to get the keys for dest and from
            foreach ($tmpCardsConnector[BoardingCardEnum::FROM] as $fromKey => $nan) {
                $nextCard = $fromCard = $fromKey;
            }
            foreach ($tmpCardsConnector[BoardingCardEnum::DESTINATION] as $destkey => $nan) {
                $destCard = $destkey;
            }

            while (isset($tmpCardsConnector[$nextCard]) && $nextCard !== $destCard) {
                $currentCard = $nextCard;
                $cardToUnset = 0;

                foreach ($tmpCardsConnector[$currentCard] as $key => $tmpCard) {
                    if ($tmpCard->getFrom() == $currentCard) {
                        $cardToUnset = $key;
                    }
                }
                $this->cards[] = $tmpCardsConnector[$currentCard][$cardToUnset];
                $nextCard = $tmpCardsConnector[$currentCard][$cardToUnset]->getDestination();
                unset($tmpCardsConnector[$currentCard][$cardToUnset]);
                if (count($tmpCardsConnector[$currentCard]) == 0) {
                    unset($tmpCardsConnector[$currentCard]);
                }
            }

            $this->ordered = true;
        }
    }

    private function connectCard(BoardingCard $card)
    {
        if (isset($this->cardsConnector[$card->getFrom()])) {
            $this->cardsConnector[$card->getFrom()][] = $card;
            unset($this->cardsConnector[BoardingCardEnum::DESTINATION][$card->getFrom()]);
        } else {
            $this->cardsConnector[$card->getFrom()] = [];
            $this->cardsConnector[$card->getFrom()][] = $card;
            $this->cardsConnector[BoardingCardEnum::FROM][$card->getFrom()] = '-';
        }

        if (isset($this->cardsConnector[$card->getDestination()])) {
            $this->cardsConnector[$card->getDestination()][] = $card;
            unset($this->cardsConnector[BoardingCardEnum::FROM][$card->getDestination()]);
        } else {
            $this->cardsConnector[$card->getDestination()] = [];
            $this->cardsConnector[$card->getDestination()][] = $card;
            $this->cardsConnector[BoardingCardEnum::DESTINATION][$card->getDestination()] = '-';
        }

    }

    private function validateNext($tmpCardsConnector, $FROM)
    {
//        if(!isset()$tmpCardsConnector[BoardingCardEnum::FROM]
    }
}
