# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/geo-location)
[![Total Downloads](https://img.shields.io/packagist/dt/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/geo-location)

Adds URL formatting and redirection with trailing slash to Laravel framework.

## Installation

### Step 1: Install package

To get started with Laravel Geo Location, use Composer command to add the package to your composer.json project's dependencies:

```shell
    composer require trinityrank/geo-location
```

### Step 2: Migration

- You need to publish migration from package

```shell
    php artisan vendor:publish --provider="Trinityrank\GeoLocation\GeoLocationServiceProvider" --tag="geolocation-migration"
```

- And then you need to run migration for alltenant(s)

```shell
    php artisan tenant:artisan "migrate"
```

- Or only for one speciffic tenant

```shell
    php artisan tenant:artisan "migrate" --tenant=[--TENANT-ID--]
```

### Step 3: Operaters Model database

Add this fields to '$fillable' inside Operaters model
    
```shell
    public $fillable = [
        ...
        'geolocation_option',
        'geolocation_countries',
    ];
```

### Step 4: Add field

Add field to your (Operater) resource into "fields" method

```shell
    use Trinityrank\GeoLocation\GeoLocationPanel;
    
    ...
    
    GeoLocationPanel::make()
```