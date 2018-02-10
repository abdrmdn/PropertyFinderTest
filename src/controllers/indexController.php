<?php

namespace PropertyFinder\controllers;

use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCard;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCardEnum;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCards;
use PropertyFinder\api\pathDescriptor\pathDescriptor;

class indexController
{
    /**
     *
     */
    public static function index()
    {
        //passing test objects to our service
        $cardsArr = [
            [
                BoardingCardEnum::TYPE => 'flight',
                BoardingCardEnum::FROM => 'c',
                BoardingCardEnum::DESTINATION => 'd',
                BoardingCardEnum::TRANSPORT_NUMBER => 'c->d',
            ],
            [
                BoardingCardEnum::TYPE => 'flight',
                BoardingCardEnum::FROM => 'b',
                BoardingCardEnum::DESTINATION => 'c',
                BoardingCardEnum::TRANSPORT_NUMBER => 'b->c',
            ],
            [
                BoardingCardEnum::TYPE => 'flight',
                BoardingCardEnum::FROM => 'a',
                BoardingCardEnum::DESTINATION => 'b',
                BoardingCardEnum::TRANSPORT_NUMBER => 'a->b',
            ],
        ];
        $boardingCards = new BoardingCards();
        foreach ($cardsArr as $card) {
            $boardingCards->addCard(new BoardingCard($card));
        }
        $pathDesc = new pathDescriptor();

        //A builder can be done above for this process
        foreach ($pathDesc->describeUnorderedBoardingCards($boardingCards) as $journeyCard){
            echo $journeyCard."<br>";
        }

    }
}
