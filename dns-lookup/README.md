# DnsLookup Library

The DnsLookup library is a PHP package that provides DNS lookup functionality. It allows you to retrieve DNS records for a given domain name in various output formats.

## Requirements & Dependencies
    "php": "^8.2",
    "monolog/monolog": "^3.3"

## Installation

You can install the library using Composer. Run the following command in your project directory:

```php
composer require artembaranovskyi/dns-lookup
```
## Usage
To use the DnsLookup library, follow these steps:

1. Include the Composer autoloader in your PHP script:
```php
require 'vendor/autoload.php';
```
2. Create an instance of the DnsLookup class, providing the required dependencies:
```php
use ArtemBaranovskyi\DnsLookup\DnsLookup;
use ArtemBaranovskyi\DnsLookup\Factories\DnsResolverFactory;
use ArtemBaranovskyi\DnsLookup\Formatters\ArrayOutputFormatter;
use Psr\Log\NullLogger;

// Create a DnsResolverFactory instance
$dnsResolverFactory = new DnsResolverFactory();

// Create a logger (in this example, we're using NullLogger)
$logger = new NullLogger();

// Create an instance of DnsLookup
$dnsLookup = new DnsLookup($dnsResolverFactory, $logger);
```
3. Call the getDnsRecords method to retrieve DNS records:
```php
// Specify the domain and output format
$domain = 'example.com';
$format = 'array'; // Available formats: 'array', 'collection', 'json'

// Get the DNS records
$dnsRecords = $dnsLookup->getDnsRecords($domain, $format);

// Use the DNS records as needed
var_dump($dnsRecords);
```

## Available Output Formats
The getDnsRecords method accepts a format parameter, which determines the output format of the DNS records. The following formats are supported:

    array: Returns an array of DNS records.
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
