Wordpacks is a web app which allows users to store the definitions for words in lists, making it handy to use whilst reading or trying to improve your vocabulary. A user can use the wordpacks dictionary (a modifed websters dictionary) or add a word with their own definition.

## Prerequistes
* MongoDB with PHP's MongoDB driver
* Composer
* My MongoDB dictionary -> https://github.com/loukel/MongoDB-Dictionary and imported into to the database with the collection name 'dictionary'
  *Note: make sure to create database named wordpacks*
 
 ## Installation / To test
1. `git clone https://github.com/loukel/wordpacks`
2. `composer install`
3. `cp .example.env .env`
4. `php artisan key:generate`
5. `php artisan migrate`
To test: `php artisan serve` and go to link
