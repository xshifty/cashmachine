# Cash Machine

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xshifty/cashmachine/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xshifty/cashmachine/build-status/master) 
[![Build Status](https://scrutinizer-ci.com/g/xshifty/cashmachine/badges/build.png?b=master)](https://scrutinizer-ci.com/g/xshifty/cashmachine/build-status/master)

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
$ composer run
```

Now access this url in your browser *http://localhost:9000/withdraw?amount=some_amount*

## Testing the application

Execute this command to run the test

```
$ composer test
```
