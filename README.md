# Cash Machine

Simple Cash Machine api.

## Setting up the application

To run this application, you must have composer installed in your host machine.
With composer installed, just execute the following command on terminal, inside the project root folder.

```
$ composer install -o
```

## Running the API

The following command will start a simple http server in your localhost:9000

```
$ php -S localhost:9000 index.php
```

Now access this url in your browser *http://localhost:9000/withdraw?amount=some_amount*

## Testing the application

Execute this command to run the test

```
$ vendor/bin/phpunit --bootstrap vendor/autoload.php test/
```