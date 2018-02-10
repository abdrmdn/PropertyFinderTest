<?php
/**
 * Created by PhpStorm.
 * User: abidul.rmdn
 * Date: 11/02/2018
 * Time: 12:50 AM
 */

namespace PropertyFinder\api\pathDescriptor\boardingCards;


class BoardingCard
{
    /**
     * @var array
     */
    private $card;
    const NO_SEAT_ASSIGNMENT = ' No seat assignment.';

    public function __construct(array $card)
    {
        $this->card = $card;
    }

    public function getRaw()
    {
        return $this->card;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $desc =
            'take ' .
            $this->card[BoardingCardEnum::TYPE] .
            ' from ' .
            $this->card[BoardingCardEnum::FROM] .
            ' to ' .
            $this->card[BoardingCardEnum::DESTINATION] . '.';

        if (isset($this->card[BoardingCardEnum::SEAT_NUMBER])) {
            $desc .= 'Seat ' . $this->card[BoardingCardEnum::SEAT_NUMBER];
        } else {
            $desc .= self::NO_SEAT_ASSIGNMENT;
        }

        return $desc;
    }
}
