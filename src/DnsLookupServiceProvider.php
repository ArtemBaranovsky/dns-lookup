<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Factories\DnsResolverFactory;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class DnsLookupServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DnsLookup::class, function ($app) {
            $dnsResolverFactory = $app->make(DnsResolverFactory::class);
            $logger = $app->make(LoggerInterface::class);
            return new DnsLookup($dnsResolverFactory, $logger);
        });

        $this->app->alias(DnsLookup::class, 'dnslookup');
    }
}
