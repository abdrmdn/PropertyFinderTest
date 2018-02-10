<?php

namespace PropertyFinder\Tests;

use PHPUnit\Framework\TestCase;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCard;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCardEnum;
use PropertyFinder\api\pathDescriptor\boardingCards\BoardingCards;
use PropertyFinder\api\pathDescriptor\boardingCards\exceptions\BoardingCardMissingFieldException;

class BoardingCardsTest extends TestCase
{

    /**
     * @var BoardingCards
     */
    private $boardingCards;

    /**
     *
     */
    public function setUp()
    {
        $this->boardingCards = new BoardingCards();
    }

    /**
     * Should be able to create a BoardingCards Collection
     */
    public function testShouldCreateBoardingCard()
    {
        $this->assertInstanceOf(BoardingCards::class, new BoardingCards());
    }

    /**
     * Should be able to add a BoardingCard to the collection
     */
    public function testShouldAddABoardingCardToTheCollection()
    {
        $boardingCardArr = [
            BoardingCardEnum::TYPE => 'flight',
            BoardingCardEnum::TRANSPORT_NUMBER => '7adf2',
            BoardingCardEnum::FROM => 'a',
            BoardingCardEnum::DESTINATION => 'b',
        ];
        $this->addBoardingCard($boardingCardArr);
        $boardingCard = new BoardingCard($boardingCardArr);
        $this->assertEquals($boardingCard, $this->boardingCards->toArray()[0]);
    }

    /**
     * If the BoardingCard didn't have all the proper fields it should give an error
     *
     * @expectedException PropertyFinder\api\pathDescriptor\boardingCards\exceptions\BoardingCardMissingFieldException
     * @expectedExceptionMessage one of the non-optional fields is missing
     */
    public function testShouldValidateMissingFields()
    {
        $boardingCardArr = [
            BoardingCardEnum::TYPE => 'flight',
            BoardingCardEnum::DESTINATION => 'b',
        ];
        $this->addBoardingCard($boardingCardArr);
    }

    /**
     * @param $boardingCardArr
     */
    private function addBoardingCard($boardingCardArr)
    {
        $this->boardingCards->addCard(new BoardingCard($boardingCardArr));
    }
}
