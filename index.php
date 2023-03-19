<?php
class TcmbExchange
{
    private static $url = "https://www.tcmb.gov.tr/kurlar/";

    public static function getExchangeRates($currencies = [], $date = null)
    {
        $url = self::$url;

        if ($date === null) {
            $url .= "today.xml";
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $date);
            if ($date === false) {
                throw new InvalidArgumentException("Geçersiz tarih formatı. 'Y-m-d' formatında olmalıdır.");
            }
            $url .= $date->format('Ym/dmY') . ".xml";
        }

        $response = file_get_contents($url);

        if ($response === false) {
            return "API isteği başarısız.";
        } else {
            $xml = simplexml_load_string($response);

            if ($xml === false) {
                return "Döviz kuru verileri alınamadı.";
            } else {
                $exchangeRates = [];

                foreach ($xml->Currency as $currency) {
                    $currencyCode = (string)$currency['Kod'];
                    if (empty($currencies) || in_array($currencyCode, $currencies)) {
                        $exchangeRates[$currencyCode] = [
                            'name' => (string)$currency->Isim,
                            'buying' => (float)$currency->BanknoteBuying,
                            'selling' => (float)$currency->BanknoteSelling,
                        ];
                    }
                }

                return $exchangeRates;
            }
        }
    }

    public static function getAllCurrencies()
    {
        $url = self::$url . "today.xml";
        $response = file_get_contents($url);

        if ($response === false) {
            return "API isteği başarısız.";
        } else {
            $xml = simplexml_load_string($response);

            if ($xml === false) {
                return "Döviz kuru verileri alınamadı.";
            } else {
                $currencies = [];

                foreach ($xml->Currency as $currency) {
                    $currencyCode = (string)$currency['Kod'];
                    $currencies[] = $currencyCode;
                }

                return $currencies;
            }
        }
    }
}

// Kullanım örneği:
$rates = TcmbExchange::getExchangeRates(['USD', 'EUR', 'GBP']);
echo json_encode($rates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
 

$rates = TcmbExchange::getExchangeRates([], '2021-09-01');
//echo json_encode($rates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
 

$currencies = TcmbExchange::getAllCurrencies();
//echo json_encode($currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>