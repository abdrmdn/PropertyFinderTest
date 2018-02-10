<?php
namespace PropertyFinder\api\pathDescriptor\boardingCards\exceptions;

class BoardingCardBrokenChainException extends \Exception
{
    const BROKEN_CHAIN = 'Trip looks incomplete, or has a destination that isnt provided';

    public function __construct()
    {
        parent::__construct(self::BROKEN_CHAIN);
    }
}
