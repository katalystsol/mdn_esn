# Katalyst MDN ESN

This package is designed to handle Mobile Device Numbers (MDN) and Electronic Serial Numbers for mobile devices. It is 
used to validate the numbers and convert ESNs to different formats.

## Install

Via Composer

``` bash
$ composer require katalyst/mdn_esn
```

## Usage

``` php
$mdn = new Katalyst\MdnEsn\Mdn($mobile_number, $mdn_length);
$validMdn = $mdn->isValid();

$esn = new Katalyst\MdnEsn\Esn($esn);
$validEsn = $esn->isValidFormat();
...
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/katalystsol/mdn_esn/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Don Cranford](https://github.com/katalystsol)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
