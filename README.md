# 3D Bin Packager
![build](https://github.com/latuconsinafr/3d-bin-packager/actions/workflows/ci-workflow.yml/badge.svg)
[![codecov](https://codecov.io/gh/latuconsinafr/3d-bin-packager/branch/main/graph/badge.svg?token=6T6HY94VGP)](https://codecov.io/gh/latuconsinafr/3d-bin-packager)

This package contains a PHP implementation to solve 3d bin packing problems based on [gedex](https://github.com/gedex/bp3d) implementation on Go and [enzoruiz](https://github.com/enzoruiz/3dbinpacking) implementation on Python with some modifications to make it more modular.

## Installation

Install by adding the package as a [Composer](https://getcomposer.org)
requirement:

```bash
$ composer require latuconsinafr/3d-bin-packager
```

## Usage

There's an example inside the root project `example.php`. Just simply type the command `php example.php` in the project's root and it would display the time elapsed and corresponding results with the number of lower bounds and the list of the bins (support for json encode cause every class implements the `\JsonSerializable` interface).

First of all, you have to initialize the packager object:

```php
$packager = new Packager(2, SortType::DESCENDING);
```

The packager constructor takes two parameters:
- Precision: The number of digits after the decimal point. It will be used for number of digits to round to.
- Sort type: With two types available `SortType::ASCENDING` and `SortType::DESCENDING`. This sort type will be used to sort the bins and the items volume inside the packager based on the chosen sort type (whether it is ascending or descending)

After you initialized the packager, you can start to add the bin(s) or the item(s) into the packager with these 4 following methods:

```php
// To add the bin one by one
$packager->addBin(new Bin('your-bin-identifier', 4, 4.5, 5.221, 50));

// Or if you wish to add all the bins at once
$packager->addBins([
    new Bin('your-first-bin-identifier', 2.22, 5.4, 20, 100),
    new Bin('your-second-bin-identifier', 1, 2, 1.5, 10)
]);

// It would be the same for the item(s)
$packager->addItem(new Item('item-id-1', 2, 2, 2, 5));

$packager->addItems([
    new Item('item-id-2', 1, 4.225, 2, 5),
    new Item('item-id-3', 2, 5, 2, 2.525),
    new Item('item-id-4', 1, 3.5, 3, 10),
    new Item('item-id-5', 3.551, 2, 2, 12.5)
]);
```

Then to pack all the item(s) to all the bin(s):

```php
$packager->withFirstFit()->pack()
```

To get the result and other details after the packing are listed below:
- To get all the bin(s) after the packing you can use either the `$packager->getBins()` or the `$packager->getIterableBins()` to return the `ArrayIterator` data type. You can see the id, length, height and etc for the bins inside the iterable and also all the fitted items inside the `fittedItems` property. 
- Due to the first fit method, the packing process would try to fit as much items as possible to the first bin and if there's no more space inside the bin, all the remaining items would be listed inside the `unfittedItems` property and move to the next bin. You can also see the total fitted or unfitted volume and weight via `getTotalFittedVolume()`, `getTotalFittedWeight()`, etc.
- The identifier is used to make every single bin and item unique.
- You can also see the total of all bin(s) and item(s) from the Packager class with `getTotalBinsVolume()`, `getTotalBinsWeight()`, etc.
- You can get further detailed information about the fitted item inside the bin such as the current rotation type which is applied to fit the item into the bin via `getRotationType()` (you can see the `RotationCombinationType::class` for the rotation list).
- You can serialize the resulted bins to see something like this:
```json
{
    "bin-id": {
        "id": "bin-id",
        "length": 8,
        "breadth": 5,
        "height": 8,
        "volume": 320,
        "weight": 100,
        "fittedItems": [
            {
                "id": "item-id",
                "length": 3.1,
                "breadth": 5,
                "height": 4,
                "volume": 62,
                "weight": 2,
                "rotationType": 0, // You can get the rotation type of any item inside the bin
                "position": { // You can also get the detailed position of any item inside the bin
                    "x-axis": 0,
                    "y-axis": 0,
                    "z-axis": 0
                }
            }
            ...
        ],
        "totalFittedVolume": 212.23,
        "totalFittedWeight": 65.83,
        ...
    }
}
```
- You can also get the corresponding position of any item inside the bin which is represented by the x-axis, y-axis and z-axis using `getPosition()`. In case you want to plot or use it for further analysis.
- You can check the phpdoc or the code for further information.

## Modifications 

```php

declare(strict_types=1);

 use Latuconsinafr\BinPackager\BinPackager3D\Bin;
 use Latuconsinafr\BinPackager\BinPackager3D\BinShema;
 use Latuconsinafr\BinPackager\BinPackager3D\Item;
 use Latuconsinafr\BinPackager\BinPackager3D\Packager;
 use Latuconsinafr\BinPackager\BinPackager3D\Types\SortType;
/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 */


require_once __DIR__ . '/vendor/autoload.php';
 
//you can add shema of the bins
$packager = new Packager(2, SortType::DESCENDING);
// add custom bins as shema  
// new Bin('Stock 4 DWB', length, height, breadth, weight),
$packager->addBinShemas([
    new BinShema('Stock 4 DWB', 29.3, 22.8, 29.8, 4.98),
    new BinShema('Stock 5 DWB', 29.8, 29.9, 44.9, 10),
    new BinShema('Stock 6 DWB', 29.3, 44.8, 60.8, 20),
]);
// add new items as much as you need
$packager->addItem(new Item("AU2814", 8, 6, 8, 0.3));
$packager->addItem(new Item("SB-6070", 3, 5, 5, 1));
$packager->addItem(new Item("AU1313", 23, 6, 8, 0.8));
$packager->addItem(new Item("AU1410", 41, 5, 7, 0.7));
$packager->addItem(new Item("AU1913", 11.5, 10, 10, 0.6));
$packager->addItem(new Item("AU2016", 44, 9, 36, 3.4));
$packager->addItem(new Item("AU2113", 11, 6, 6, 0.13));
$packager->addItem(new Item("OPT3179", 19, 11, 8, 1.52));
$packager->addItem(new Item("VW5720", 3, 5, 5, 1));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));

while ($packager->withFirstFit()->pack()) {
};
$packager->createParcels();
echo "Packed Parcells \n<br>";
echo '<pre>';
$str =  json_decode(json_encode($packager, JSON_PRETTY_PRINT), true);
print_r($str['bin']);
echo '</pre>';
echo "All data\n <br>";
echo '<pre>';
$str =  json_decode(json_encode($packager, JSON_PRETTY_PRINT), true);
print_r($str);
echo '</pre>';
die;


```


## Credits
- https://github.com/enzoruiz/3dbinpacking
- https://github.com/gedex/bp3d

## License
This package is under [MIT](https://github.com/latuconsinafr/3d-bin-packager/blob/main/LICENSE) license.
