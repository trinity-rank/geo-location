# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/geo-location)
[![Total Downloads](https://img.shields.io/packagist/dt/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/geo-location)

Choose to show or hide Operaters by choosing the countries from list.

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

- Add field to your (Operater) resource into "fields" method

```shell
    use Trinityrank\GeoLocation\GeoLocationPanel;
    
    ...
    
    GeoLocationPanel::make()
```

- Or if you use conditional fields than just add this into "fields" method
```shell
    $this->getGeoLocationPanel('GeoLocation Page Settings', 'geolocation')
```

### Step 5: If you are using conditional fields

Add this in tenant config

```shell
    'conditional_fields' => [
        ...

        'operater' => [
            'geolocation' => [
                'visible' => true
            ]
        ]

        ...
    ]
```

### Step 6: Frontend part

- Without token

```shell
    use Trinityrank\GeoLocation\GeoLocationOperater;

    ...

    $operaters = GeoLocationOperater::list($operaters_array);
```

- With token

Add new variable in .ENV file

```shell
    GEOLOCATION_API_TOKEN=[--Replace-this-with-website-token--]
```

You can connect with 'config/main.php' file

```shell
    'geolocation_api_token' => env('GEOLOCATION_API_TOKEN', null),
```

Then we can use our Geo Location

```shell
    use Trinityrank\GeoLocation\GeoLocationOperater;

    ...

    $operaters = GeoLocationOperater::list($operaters_array, $api_token);
```