*we can proved different type of boarding cards (plane, bus, etc.) to our service and use a strategy pattern with a factory. but figured, no need to assume stuff business didn’t provide. so i assumed the cards are the same type.
*Assumed we’re gonna be using at least composer to do some autoload, other-wise what are we? from stone-age? :P
*Ofcourse we’re doing it php7
*We could use a proper collection instead of the basic collection passed as Boarding Cards if we used an extension.
*for future if cards get more complicated, each can have their own validators which can be triggered validated in the boardingCardsCollection. for now a check obligatory fields would suffice.plus we’re not making fancy stuff now, so a missing field exception would be enough here.
*Log can be super useful in the future and can be injected as a dependency in pathDescriptor
*BoardingCardValidator config can be loaded properly on injection from a proper cardConfig in the future, for now its very minimal
*BoardingCard would’ve been better done in strategy, but since I’m actually a bit busy, i assumed all output is the same.
*having a proper router would’ve been very good , but since not much, its not needed.
