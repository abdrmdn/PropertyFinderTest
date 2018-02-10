<?php

namespace PropertyFinder\Tests;

use PHPUnit\Framework\MockObject\Stub\Exception;
use PHPUnit\Framework\TestCase;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCard;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCardEnum;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCards;
use PropertyFinder\api\pathDescriptor\pathDescriptor;

class PathDescriptorTest extends TestCase
{
    /**
     * @var
     */
    private $pathDescriptor;
    private $boardingCards;

    public function setUp()
    {
        $this->pathDescriptor = new pathDescriptor();
        /**
         * @todo mock later
         */
        $this->boardingCards = new BoardingCards([]);
    }

    /**
     *
     * @throws Exception
     */
    public function testItShouldAcceptEmptyBoardingCardsCollection()
    {
        $journey = [pathDescriptor::ARRIVED_TO_YOUR_DESTINATION];
        $this->assertEquals(
            $journey,
            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
        );
    }

    /**
     * Tests if pathDescriptor can describe one Boarding Card
     */
    public function testItShouldAcceptOneBoardingCard()
    {
        $this->addBoardingCard(
            [
                BoardingCardEnum::TYPE => 'flight',
                BoardingCardEnum::TRANSPORT_NUMBER => '7adf2',
                BoardingCardEnum::FROM => 'a',
                BoardingCardEnum::DESTINATION => 'b',
            ]
        );
        $journey =
            [
                'take flight from a to b.' . BoardingCard::NO_SEAT_ASSIGNMENT,
                pathDescriptor::ARRIVED_TO_YOUR_DESTINATION,
            ];
        $this->assertEquals(
            $journey,
            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
        );
    }

    private function addBoardingCard($array)
    {
        $this->boardingCards->addCard(new BoardingCard($array));
    }

//    /**
//     * Tests if pathDescriptor can describe without seat Boarding Cards
//     */
//    public function testItShouldAcceptOneBoardingCard()
//    {
//        $this->boardingCards->addCard(
//            [
//                BoardingCardEnum::TYPE => 'flight',
//                BoardingCardEnum::TRANSPORT_NUMBER => '7adf2',
//                BoardingCardEnum::FROM => 'a',
//                BoardingCardEnum::DESTINATION => 'b',
//            ]
//        );
//        $journey =
//            [
//                'take flight from a to b. ' . pathDescriptor::NO_SEAT_ASSIGNMENT,
//                pathDescriptor::ARRIVED_TO_YOUR_DESTINATION,
//            ];
//        $this->assertEquals(
//            $journey,
//            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
//        );
//    }
}
