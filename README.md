# DnsLookup Library

The DnsLookup library is a PHP package that provides DNS lookup functionality. It allows you to retrieve DNS records for a given domain name in various output formats.

## Requirements & Dependencies
    "php": "^8.2",
    "monolog/monolog": "^3.0"

## Installation

You can install the library using Composer. Run the following command in your project directory:

```php
composer require artem-baranovskyi/dns-lookup
```
Then add package Service Provider to autoload in config/app.php:
```php
        /*
         * Package Service Providers...
         */
        DnsLookupServiceProvider::class,
``````
Also add package alias at Class Aliases section:
```php
    'aliases' => Facade::defaultAliases()->merge([
        'DnsLookup' => ArtemBaranovskyi\DnsLookup\Facades\DnsLookupFacade::class,
    ])->toArray(),
```

## Usage
To use the DnsLookup library, you can follow these options:

1. Use DnsLookup as a facade, providing desired output format:
```php
use ArtemBaranovskyi\DnsLookup\Facades\DnsLookupFacade;
...
    $domain = 'example.com';
    $dnsRecords = DnsLookupFacade::getDnsRecords($domain, 'array'); // use any from 'array', 'collection', 'json'
    dd($dnsRecords);
```

2. Get an instance of DnsLookup form Service Container, providing desired output format:

```php
use ArtemBaranovskyi\DnsLookup\Facades\DnsLookupFacade;

    $domain = 'example.com';
    $dnsLookup = app(DnsLookup::class);
    $dnsRecords = $dnsLookup->getDnsRecords($domain, 'array'); // use any from 'array', 'collection', 'json'
    dd($dnsRecords);
```

## Available Output Formats
The getDnsRecords method accepts a format parameter, which determines the output format of the DNS records. The following formats are supported:

    array: Returns an array of DNS records (default format)
    collection: Returns a DnsRecordCollection object containing the DNS records.
    json: Returns a JSON-encoded string of the DNS records.

## Error Handling

If an error occurs during the DNS lookup process, an Exception will be thrown with an error message. It's recommended to wrap the getDnsRecords call in a try-catch block to handle any potential exceptions:
```php
try {
    $dnsRecords = $dnsLookup->getDnsRecords($domain, $format);
    // Use the DNS records
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
```

## Contributing
Contributions to the DnsLookup library are welcome! If you encounter any issues or have suggestions for improvements, please open an issue or submit a pull request on [GitHub](https://github.com/your-username/dns-lookup).

## License

This library is open source and licensed under the MIT License.
