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
        $journey = [];
        $this->assertEquals(
            $journey,
            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
        );
    }

    /**
     * Tests if pathDescriptor can describe one Boarding Card with different cases
     *
     * @dataProvider provideTestItShouldAcceptOneBoardingCard
     *
     * @param $boardingCardArray
     * @param $expectedJourney
     */
    public function testItShouldAcceptOneBoardingCards($boardingCardArray, $expectedJourney)
    {
        $this->addBoardingCard($boardingCardArray);

        $this->assertEquals(
            $expectedJourney,
            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
        );
    }

    public function provideTestItShouldAcceptOneBoardingCard()
    {
        return [
            [
                'boardingCardArray' => [
                    BoardingCardEnum::TYPE => 'flight',
                    BoardingCardEnum::FROM => 'a',
                    BoardingCardEnum::DESTINATION => 'b',
                    BoardingCardEnum::TRANSPORT_NUMBER => '7adf2',
                ],
                'expectedJourney' => [
                    'take flight 7adf2 from a to b.' . BoardingCard::NO_SEAT_ASSIGNMENT,
                    pathDescriptor::ARRIVED_TO_YOUR_DESTINATION,
                ],
            ],
            [
                'boardingCardArray' => [
                    BoardingCardEnum::TYPE => 'flight',
                    BoardingCardEnum::FROM => 'a',
                    BoardingCardEnum::DESTINATION => 'b',
                    BoardingCardEnum::GATE => '23',
                ],
                'expectedJourney' => [
                    'take flight from a to b. Gate 23, ' . BoardingCard::NO_SEAT_ASSIGNMENT,
                    pathDescriptor::ARRIVED_TO_YOUR_DESTINATION,
                ],
            ],
        ];
    }

    /**
     * Tests if pathDescriptor can reorder multiple Boarding Cards then describes them
     *
     * @dataProvider provideTestItShouldAcceptAndReOrderBoardingCards
     *
     * @param $boardingCardsArray
     * @param $expectedJourney
     */
    public function testItShouldAcceptAndReOrderBoardingCards($boardingCardsArray, $expectedJourney)
    {
        foreach ($boardingCardsArray as $boardingCardArray) {
            $this->addBoardingCard($boardingCardArray);
        }

        $this->assertEquals(
            $expectedJourney,
            $this->pathDescriptor->describeUnorderedBoardingCards($this->boardingCards)
        );
    }

    public function provideTestItShouldAcceptAndReOrderBoardingCards()
    {
        return [
            [
                '$boardingCardsArray' => [
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
                ],
                'expectedJourney' => [
                    'take flight a->b from a to b.' . BoardingCard::NO_SEAT_ASSIGNMENT,
                    'take flight b->c from b to c.' . BoardingCard::NO_SEAT_ASSIGNMENT,
                    'take flight c->d from c to d.' . BoardingCard::NO_SEAT_ASSIGNMENT,
                    pathDescriptor::ARRIVED_TO_YOUR_DESTINATION,
                ],
            ],
        ];
    }

    //test not connected flight


    private function addBoardingCard($array)
    {
        $this->boardingCards->addCard(new BoardingCard($array));
    }
}
