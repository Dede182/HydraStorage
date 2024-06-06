# Hydra Storage


## Installation

You can install the package via composer:

```bash
composer require dede/hydrastorage
```


```bash
php artisan vendor:publish --tag="hydrastorage-config"
```


## Usage

```php
$option = (new MediaOption('import',20,400,400,'png')); // option you prefer

$media = $this->storeMedia($request->file('file'), 'new',true,$option); // store the image with prefer setting
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Htet-Shine-Htwe](https://github.com/Dede182)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
