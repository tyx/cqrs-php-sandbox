[Outdated] To see a fresher example of CQRS - EventSourcing real world app : https://github.com/shouze/parkedLife

cqrs-php-sandbox
================

Sandbox to play with CQRS and DDD principle with PHP and Symfony2.

All CQRS Stuff is provided by [LiteCQRS](https://github.com/beberlei/litecqrs-php).

It requires PHP 5.4.

What it is exactly ?
--------------------

A little Blackjack browser game ! 

Game are very good to teach about multiples business rules. I decided to make one to have a better experience while I tryed to learn DDD and CQRS stuff.

As I love PHP (sic) and Symfony2, the game is build with these 2 tools and try to make the bigger efforts to offering real solutions to real issues.

The way it works
----------------

All the code come from my different reading, don't take it for other that my small experience.

Mysql, through Doctrine ORM, is used :
- to store the events
- to store the projection

Yes, I love Mysql too : )

The specifications can be found in `spec` folder and run via `bin/phpspec run --format=pretty`

Want to see in real world ?
---------------------------
Just run a couple of command : 
```
composer install
bower install
grunt
app/console doctrine:database:create
app/console doctrine:schema:create
```

You can now open your browser to the localhost you defined and play to Blackjack !
