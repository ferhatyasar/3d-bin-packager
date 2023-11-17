<?php
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
 


$packager = new Packager(2, SortType::DESCENDING);
// add custom bins as shema  
// new Bin('Stock 4 DWB', length, height, breadth, weight),
$packager->addBinShemas([
    new BinShema('Stock 4 DWB', 29.3, 22.8, 29.8, 4.98),
    new BinShema('Stock 5 DWB', 29.8, 29.9, 44.9, 10),
    new BinShema('Stock 6 DWB', 29.3, 44.8, 60.8, 20),
]);

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
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
$packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
// $packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
// $packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
// $packager->addItem(new Item("TO1412", 41, 5, 7, 0.7));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("TBD7006-D", 36, 7, 36, 12.2));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
$packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("SB-6081", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));
// $packager->addItem(new Item("AD3001A", 3, 5, 5, 1));

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
