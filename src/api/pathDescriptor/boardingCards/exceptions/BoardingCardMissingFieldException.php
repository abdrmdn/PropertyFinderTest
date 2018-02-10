<?php
namespace PropertyFinder\api\pathDescriptor\boardingCards\exceptions;

class BoardingCardMissingFieldException extends \Exception
{
    const MISSING_FIELD = 'one of the non-optional fields is missing';

    public function __construct()
    {
        parent::__construct(self::MISSING_FIELD);
    }
}
