* Lots of improvements can be made, but based on requirements, 'less is more'
* We can provide different type of boarding cards (plane, bus, etc.) to our service and use a strategy pattern with a factory. but since I’m actually a bit busy, i assumed all output is the same.
* Assumed we’re gonna be using at least composer to do some autoload, other-wise what are we? from stone-age? :P
* Ofcourse done using php7
* We could use a proper collection instead of the basic collection passed as Boarding Cards if we used an extension.
* For future if cards get more complicated, each can have their own validators which can be triggered validated in the boardingCardsCollection. for now a check obligatory fields would suffice.plus we’re not making fancy stuff now, so a missing field exception would be enough here.
* Log can be super useful in the future and can be injected as a dependency in pathDescriptor
* BoardingCardValidator config can be loaded properly on injection from a proper cardConfig in the future, for now its very minimal
* Having a proper router would’ve been very good , but since not much, its not needed.


##How to run the test:
Just Run the command :
```
vendor/bin/phpunit
```
phpunit config already set, so no need to provide anything for the command.


##Check on browser:
Run php server on index.php
and it will connect to the only controller.


##Whats missing:
* UI to play around with the api
* proper boarding cards types
* boarding cards factory
* proper controllers handling
* some other small improvements

reason: got too busy with other stuff. 
Thanks for understanding.
