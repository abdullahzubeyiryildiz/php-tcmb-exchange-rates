# TCMB Exchange Rates PHP Class

This repository contains a PHP class named `TcmbExchange` that allows you to fetch exchange rate data provided by the Central Bank of the Republic of Turkey (TCMB). You can get exchange rates for specific currencies, historical rates, and a list of all available currencies.

## Features

- Get exchange rates for specific currencies
- Get historical exchange rates for specific dates
- Get a list of all available currencies
- Easy to use and integrate into your PHP projects

## Usage

1. Clone or download this repository
2. Copy the `TcmbExchange` class into your project
3. Use the class to fetch exchange rates as needed. Here are some examples:


##### NOTE: The TCMB updates the exchange rates on business days only. The rates will not be updated on weekends and public holidays. <br><br>Make sure to handle exceptions if you are using a user-supplied date. The getExchangeRates function expects the date to be in the 'Y-m-d' format.

```php
// Get exchange rates for specific currencies
$rates = TcmbExchange::getExchangeRates(['USD', 'EUR', 'GBP']);
echo json_encode($rates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Get historical exchange rates for a specific date
$rates = TcmbExchange::getExchangeRates([], '2021-09-01');
echo json_encode($rates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Get a list of all available currencies
$currencies = TcmbExchange::getAllCurrencies();
echo json_encode($currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
```