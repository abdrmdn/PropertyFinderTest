<?php

namespace PropertyFinder\api\pathDescriptor\boardingCards;


use PropertyFinder\api\pathDescriptor\boardingCards\exceptions\BoardingCardMissingFieldException;

class BoardingCardValidator
{
    const CONFIG = [
        'nonOptionals' => [
            BoardingCardEnum::FROM,
            BoardingCardEnum::DESTINATION,
            BoardingCardEnum::TYPE,
        ],
    ];

    /**
     * Checks:
     * - non optional fields are there
     *
     * @param $boardingCard
     *
     * @return bool
     * @throws BoardingCardMissingFieldException
     */
    public static function validateCard(BoardingCard $boardingCard)
    {
        $card = $boardingCard->getRaw();
        foreach (BoardingCardValidator::CONFIG['nonOptionals'] as $nonOpionalField) {
            if (!isset($card[$nonOpionalField])) {
                throw new BoardingCardMissingFieldException();
            }
        }

        return true;
    }
}
