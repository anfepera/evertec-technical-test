

## Placetopay Integration for shop

the implementation of the project consists of providing a purchase method for a store,
using the placetopay payment gateway.

This project was developed with Php 8.1.4 , Laravel Framework 9.0 and mariaDB 10.6.

Configuration
=============
En the .env.example file, the PLACE_TO_PAY_LOGIN, PLACE_TO_PAY_TRAN_KEY and PLACE_TO_PAY_URL constants
should be assign. Please copy .env.example file to .env file and change values of constants.


Installation
============
```
:~$ git clone https://gitlab.com/anfepera/evertec-technical-test.git
:~$ cd evertec-technical-test}
:~$ cp .env.example .env // change configuration
:~$ composer install
:~$ php artisan migrate
:~$ php artisan db:seed
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
