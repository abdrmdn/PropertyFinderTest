<?php
namespace PropertyFinder\api\pathDescriptor\boardingCards;


class BoardingCards
{
    /**
     * @var array
     */
    private $cards;

    const NON_OPTIONAL_FIELDS = [BoardingCardEnum::TYPE, BoardingCardEnum::DESTINATION, BoardingCardEnum::FROM];

    public function __construct()
    {
        $this->cards = [];
    }

    /**
     * @param BoardingCard $card
     *
     * @throws exceptions\BoardingCardMissingFieldException
     */
    public function addCard(BoardingCard $card)
    {
        BoardingCardValidator::validateCard($card);
        $this->cards[] = $card;
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
}
