

## Placetopay Integration for shop

the implementation of the project consists of providing a purchase method for a store,
using the placetopay payment gateway.

This project was developed with Php 8.1.4 , Laravel Framework 9.5.1 and mariaDB 10.6.

Configuration
=============
En the .env.example file, the PLACE_TO_PAY_LOGIN, PLACE_TO_PAY_TRAN_KEY and PLACE_TO_PAY_URL constants
should be assign. Please copy .env.example file to .env file and change values of constants.


Installation
============
```
:~$ git clone https://github.com/anfepera/evertec-technical-test.git
:~$ cd evertec-technical-test
:~$ cp .env.example .env // change configuration
:~$ composer install
:~$ php artisan migrate
:~$ php artisan db:seed
```

Testing
============
You should be create database test and configure it in .env.testing file.
```
:~$ cp .env.example .env.testing
```
Change configuration the PLACE_TO_PAY_LOGIN, PLACE_TO_PAY_TRAN_KEY and PLACE_TO_PAY_URL constants
should be assign (Fake values) in .env.testing file

Run test:
```
:~$ ./vendor/bin/phpunit
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
