<?php

/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 */

declare(strict_types=1);

namespace ferhatyasar\BinPackager\BinPackager3D;

use ferhatyasar\BinPackager\BinPackager3D\Types\AxisType;
use ferhatyasar\BinPackager\BinPackager3D\Types\PositionType;
use ferhatyasar\BinPackager\BinPackager3D\Types\SortType;

/**
 * A main packager class to pack all the items into all the bins.
 */
final class Packager implements \JsonSerializable
{
    /**
     * @var iterable The bins.
     */
    private iterable $bins;
    /**
     * @var iterable The bins.
     */
    private iterable $binShemas;

    /**
     * @var iterable The items to put into the bins.
     */
    private iterable $items;
    /**
     * @var int The counter of items and bins in usage for unique id .
     */
    private iterable $counter;

    /**
     * @var float The total bins volume inside the packager.
     */
    private float $totalBinsVolume;

    /**
     * @var float The total fitted items volume inside the packager.
     */
    private float $totalFittedVolume;

    /**
     * @var float The total fitted items weight inside the packager.
     */
    private float $totalFittedWeight;

    /**
     * @var float The total bins weight inside the packager.
     */
    private float $totalBinsWeight;

    /**
     * @var float The total bins Height inside the packager.
     */
    private float $binFitHeight;

    /**
     * @var float The total bins Length inside the packager.
     */
    private float $binFitLenght;

    /**
     * @var float The total bins Width inside the packager.
     */
    private float $binFitWidht;

    /**
     * @var float The total items volume inside the packager.
     */
    private float $totalItemsVolume;

    /**
     * @var float The total items weight inside the packager.
     */
    private float $totalItemsWeight;

    /**
     * @var int The number of digits after the decimal point.
     */
    private int $precision;

    /**
     * @var int The sort method to apply (1 for ascending and -1 for descending).
     */
    private int $sortMethod;

    /**
     * @param int $precision The number of digits after the decimal point.
     * @param int $sortMethod The sort method to apply (1 for ascending and -1 for descending).
     */
    public function __construct(int $precision = 0, int $sortMethod = SortType::DESCENDING)
    {
        if ($precision < 0) {
            throw new \UnexpectedValueException("The number of digits should be more than or equals to zero.");
        }
        if ($sortMethod != -1 && $sortMethod != 1) {
            throw new \UnexpectedValueException("The sort method should be either 1 (for ascending) or -1 (for descending).");
        }
        // print_r($precision);
        // die;

        $this->binShemas = [];
        $this->bins = [];
        $this->items = [];
        $this->counter = array("bins" => [], "items" => []);
        $this->totalBinsVolume = 0;
        $this->totalBinsWeight = 0;
        $this->totalFittedVolume = 0;
        $this->totalFittedWeight = 0;
        $this->totalItemsVolume = 0;
        $this->totalItemsWeight = 0;
        $this->precision = $precision;
        $this->sortMethod = $sortMethod;
    }

    /**
     * The packager's bins getter.
     * 
     * @return iterable The packager's bins.
     */
    public function getBins(): iterable
    {
        return $this->bins;
    }

    /**
     * The packager's iterable bins getter.
     * 
     * @return ArrayIterator The packager's iterable bins.
     */
    public function getIterableBins(): \ArrayIterator
    {
        return new \ArrayIterator($this->bins);
    }

    /**
     * The packager's items getter.
     * 
     * @return iterable The packager's items.
     */
    public function getItems(): iterable
    {
        return $this->items;
    }

    /**
     * The packager's iterable items getter.
     * 
     * @return ArrayIterator The packager's iterable items.
     */
    public function getIterableItems(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * The packager's total bin(s) volume getter.
     * 
     * @return float The total bin(s) volume.
     */
    public function getTotalBinsVolume(): float
    {
        return $this->totalBinsVolume;
    }

    /**
     * The packager's total bin(s) weight getter.
     * 
     * @return float The total bin(s) weight.
     */
    public function getTotalBinsWeight(): float
    {
        return $this->totalBinsWeight;
    }

    /**
     * The packager's total item(s) volume getter.
     * 
     * @return float The total item(s) volume.
     */
    public function getTotalItemsVolume(): float
    {
        return $this->totalItemsVolume;
    }

    /**
     * The packager's total item(s) weight getter.
     * 
     * @return float The total item(s) weight.
     */
    public function getTotalItemsWeight(): float
    {
        return $this->totalItemsWeight;
    }

    /**
     * The packager's lower bounds getter.
     * The lower bounds mean that the value returned is the worst case of the bin(s) needed to hold or contain all the items.
     * Calculated based on the bin(s) and item(s) volume.
     * 
     * @return int The lower bounds.
     */
    public function getLowerBounds(): int
    {
        // To prevent the division by zero error
        if ($this->totalItemsVolume == 0) {
            return 0;
        }

        return (int)ceil($this->totalItemsVolume / $this->totalBinsVolume);
    }

    /**
     * The item's counter getter.
     * 
     * @return mixed The item's counter.
     */
    public function getItemCounter($item)
    {
        if (!isset($this->counter['items'][$item->getName()])) $this->counter['items'][$item->getName()] = 0;
        return $this->counter['items'][$item->getName()];
    }


    /**
     * The bin's counter getter.
     * 
     * @return mixed The item's counter.
     */
    public function getBinCounter($bin)
    {
        if (!isset($this->counter['bins'][$bin->getName()])) $this->counter['bins'][$bin->getName()] = 0;
        return $this->counter['bins'][$bin->getName()];
    }

    /**
     * The add bin to the packager method.
     * The bin(s) would become the container for the item(s).
     * 
     * @param Bin $bin The bin to contain the item(s).
     * 
     * @return void
     */
    public function addBinShema(BinShema $bin): void
    {
        // \print_r($bin);die;
        // foreach ($this->bins as $existingBin) {
        //     if ($existingBin->getId() === $bin->getId()) {
        //         throw new \UnexpectedValueException("Bin id should be unique.");
        //     }
        // }
        if (isset($this->binShemas[$bin->getName()])) {
            throw new \UnexpectedValueException($bin->getName() . "Bin Shema id should be unique.");
        }
        // $bin->binFitWidth = 0;
        // $bin->binFitHeight = 0;
        // $bin->binFitLenght = 0;
        if (!isset($this->binShemas[$bin->getName()])) $this->binShemas[$bin->getName()] = $bin;

        if (!isset($this->counter['bins'][$bin->getName()])) $this->counter['bins'][$bin->getName()] = 0;
        // $this->counter['bins'][$bin->getName()]++;
        $bin->setPrecision($this->precision);
        // $this->bins[$binId] = $bin;
        // $this->totalBinsVolume += $bin->getVolume();
        // $this->totalBinsWeight += $bin->getWeight();
    }
    /**
     * The add bins to the shema
     * The bins would become the container for the items.
     * 
     * @param iterable $bins The iterable of @see Bin to contain the item(s).
     * 
     * @return void
     */
    public function addBinShemas(iterable $bins): void
    {
        foreach ($bins as $bin) {
            if (!$bin instanceof BinShema) {
                throw new \UnexpectedValueException("Bin should be an instance of Bin class.");
            }

            $this->addBinShema($bin);
        }
    }

    /**
     * The add bin to the packager method.
     * The bin(s) would become the container for the item(s).
     * 
     * @param Bin $bin The bin to contain the item(s).
     * 
     * @return void
     */
    public function addBin(Bin $bin): void
    {
        // \print_r($bin);die;
        // foreach ($this->bins as $existingBin) {
        //     if ($existingBin->getId() === $bin->getId()) {
        //         throw new \UnexpectedValueException("Bin id should be unique.");
        //     }
        // }
        $binId = $bin->getName() . "-" . $this->getBinCounter($bin);
        $bin->setId($binId);
        if (isset($this->bins[$binId])) {
            throw new \UnexpectedValueException($binId . "Bin id should be unique.a");
        }
        if (!isset($this->counter['bins'][$bin->getName()])) $this->counter['bins'][$bin->getName()] = 0;
        $this->counter['bins'][$bin->getName()]++;
        $bin->setPrecision($this->precision);
        if (!isset($this->binShemas[$bin->getName()])) $this->binShemas[$bin->getName()] = $bin;
        $this->bins[$binId] = $bin;
        $this->totalBinsVolume += $bin->getVolume();
        $this->totalBinsWeight += $bin->getWeight();
    }

    /**
     * The add bins to the packager method.
     * The bins would become the container for the items.
     * 
     * @param iterable $bins The iterable of @see Bin to contain the item(s).
     * 
     * @return void
     */
    public function addBins(iterable $bins): void
    {
        foreach ($bins as $bin) {
            if (!$bin instanceof Bin) {
                throw new \UnexpectedValueException("Bin should be an instance of Bin class.");
            }

            $this->addBin($bin);
        }
    }

    /**
     * The add item to the packager method.
     * This item(s) to put into the bin(s).
     * 
     * @param Item $item The to put into the bin.
     * 
     * @return void
     */
    public function addItem(Item $item): void
    {
        // foreach ($this->items as $existingItem) {
        //     if ($existingItem->getId() === $item->getId()) {
        //         throw new \UnexpectedValueException("Item id should be unique.");
        //     }
        // }
        // if (!isset($this->counter['items'][$item->getName()])) $this->counter['items'][$item->getName()] = 0;
        $itemId = $item->getName() . "-" . $this->getItemCounter($item);
        $item->setId($itemId);
        if (isset($this->items[$itemId])) {
            throw new \UnexpectedValueException($itemId . "Item id should be unique.a");
        }
        if (!isset($this->counter['items'][$item->getName()])) $this->counter['items'][$item->getName()] = 0;
        $this->counter['items'][$item->getName()]++;


        if (isset($this->items[$item->getId()])) {
            throw new \UnexpectedValueException("Item id should be unique.");
        }
        $item->setPrecision($this->precision);

        $this->items[$item->getId()] = $item;
        $this->totalItemsVolume += $item->getVolume();
        $this->totalItemsWeight += $item->getWeight();
    }

    /**
     * The add items to the packager method.
     * The items to put into the bin(s).
     * 
     * @param iterable $items The iterable of @see Item to put into the bin(s).
     * 
     * @return void
     */
    public function addItems(iterable $items): void
    {
        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new \UnexpectedValueException("Item should be an instance of Item class.");
            }

            $this->addItem($item);
        }
    }

    /**
     * The pack item to bin method.
     * This method would try to pack the inputted item into the inputted bin.
     * Whether the inputted item would fit into the inputted bin or not.
     * 
     * @param Bin $bin The bin to put the item into.
     * @param Item $item The item to put into the bin.
     * 
     * @return void
     */
    public function packItemToBin(Bin $bin, Item $item): void
    {
        $fitted = false;

        if (!$bin instanceof Bin) {
            throw new \UnexpectedValueException("Bin should be an instance of Bin class.");
        }
        if (!$item instanceof Item) {
            throw new \UnexpectedValueException("Item should be an instance of Item class.");
        }

        // Bin has no fitted items yet
        if (iterator_count($bin->getIterableFittedItems()) === 0) {
            if (!$bin->putItem($item, PositionType::START_POSITION)) {
                $bin->setUnfittedItems($item);
            }

            return;
        }

        // Bin has fitted item(s) already
        foreach (AxisType::ALL_AXIS as $axis) {
            $fittedItems = $bin->getFittedItems();
            foreach ($fittedItems as $fittedItem) {
                $pivot = PositionType::START_POSITION;
                $dimension = $fittedItem->getDimension();

                if ($axis === AxisType::LENGTH) {
                    $pivot = [
                        AxisType::LENGTH  => $fittedItem->getPosition()[AxisType::LENGTH] + $dimension[AxisType::LENGTH],
                        AxisType::HEIGHT  => $fittedItem->getPosition()[AxisType::HEIGHT],
                        AxisType::BREADTH => $fittedItem->getPosition()[AxisType::BREADTH]
                    ];
                } elseif ($axis === AxisType::HEIGHT) {
                    $pivot = [
                        AxisType::LENGTH  => $fittedItem->getPosition()[AxisType::LENGTH],
                        AxisType::HEIGHT  => $fittedItem->getPosition()[AxisType::HEIGHT] + $dimension[AxisType::HEIGHT],
                        AxisType::BREADTH  => $fittedItem->getPosition()[AxisType::BREADTH]
                    ];
                } elseif ($axis === AxisType::BREADTH) {
                    $pivot = [
                        AxisType::LENGTH  => $fittedItem->getPosition()[AxisType::LENGTH],
                        AxisType::HEIGHT  => $fittedItem->getPosition()[AxisType::HEIGHT],
                        AxisType::BREADTH  => $fittedItem->getPosition()[AxisType::BREADTH] + $dimension[AxisType::BREADTH]
                    ];
                }

                if ($bin->putItem($item, $pivot)) {
                    // $bin->binFitHeight += $item->getHeight();
                    // $bin->binFitWidth += $item->getBreadth();
                    // $bin->binFitLength += $item->getLength();
                    $fitted = true;
                    break;
                }
            }

            if ($fitted) {
                break;
            }
        }

        if (!$fitted) {
            // $bin->setUnfittedItems($item);
        }
    }

    /**
     * The default pack method, keeps all bins open, in the order in which they were opened. 
     * It attempts to place each new item into the first bin in which it fits.
     * This first fir also applied the sort method to both the bin(s) and the item(s) according to the sort method value,
     * it could ascending or descending.
     * 
     * @return self
     */
    public function withFirstFit(): self
    {
        // Sort the bins based on the sort method value
        $iterableBins = $this->getIterableBins();
        $iterableBins->uasort(function ($a, $b) {
            if ($a->getVolume() === $b->getVolume()) return 0;
            return ($a->getVolume() > $b->getVolume()) ? $this->sortMethod : SortType::DESCENDING * $this->sortMethod;
        });

        $this->bins = $iterableBins;
        // \var_dump($this);
        // Sort the items based on the sort method value
        $iterableItems = $this->getIterableItems();
        $iterableItems->uasort(function ($a, $b) {
            if ($a->getVolume() === $b->getVolume()) return 0;
            return ($a->getVolume() > $b->getVolume()) ? $this->sortMethod : SortType::DESCENDING * $this->sortMethod;;
        });

        $this->items = $iterableItems;

        return $this;
    }

    /**
     * The main pack method, this method would try to pack all the items into all the bins
     * based on the chosen method, currently the available method is the @see withFirstFit().
     * 
     * @return void
     */
    public function pack(): void
    {
        foreach ($this->bins as $bin) {

            // No item left
            if (iterator_count($this->getIterableItems()) === 0) {
                break;
            }

            // Pack item(s) to current open bin
            foreach ($this->items as $item) {
                $this->packItemToBin($bin, $item);
            }

            // Remove the packed item(s)
            foreach ($bin->getFittedItems() as $fittedItem) {
                if ($this->getIterableItems()->offsetExists($fittedItem->getId())) {
                    unset($this->items[$fittedItem->getId()]);
                }
            }
        }
    }

    public function createParcels(): void
    {

        $loop = 0;
        // create bins as much as needed and fill with items 
        do {
            $totalItems =  count($this->items);
            if ($totalItems) {
                $leftValue =  $this->totalItemsVolume - $this->totalFittedVolume;
                $leftKg =  $this->totalItemsWeight - $this->totalFittedWeight;
                // \var_dump($this->bins);
                // die; 
                $foundbin = false;
                foreach ($this->bins as $key => $prevbin) {
                    # code...

                    if (!count($prevbin->getFittedItems())) {
                        $this->totalBinsVolume -= $prevbin->getVolume();
                        $this->totalBinsWeight -= $prevbin->getWeight();
                        unset($this->bins[$prevbin->getId()]);

                        // break;
                    };
                    // foreach ($this->items as $key => $item) {
                    //     // print_r ($item->getLength()."<". $prevbin->getLength()."<br>\n");
                    //     if (
                    //         $item->getLength() < $prevbin->getLength()
                    //         &&
                    //         $item->getBreadth() < $prevbin->getBreadth()
                    //         &&
                    //         $item->getHeight() < $prevbin->getHeight()
                    //     ) {
                    //         $foundbin = true;
                    //     }
                    //     # code...
                    // }
                }
                // if($foundbin) \var_dump($prevbin);
                // $prevbin = \json_decode (\json_encode($this->bins),true);

                // if ( (count($prevbin)))  $prevbin = $prevbin[$this->bins];
                // \var_dump($prevbin);
                foreach ($this->binShemas as $bin) {
                    // echo "($leftValue < 0  && $leftKg < 0 || " . $bin->getVolume() . "> $leftValue &&  " . $bin->getWeight() . " > $leftKg )\n";

                    // foreach ($this->items as $key => $item) {
                    //     if (
                    //         $item->getLength() < $bin->getLength()
                    //         &&
                    //         $item->getBreadth() < $bin->getBreadth()
                    //         &&
                    //         $item->getHeight() < $bin->getHeight()
                    //     ) {
                    //         $foundbin = true;
                    //     }

                    // }
                    //  if($foundbin){ 
                    if (
                        $leftValue < 0
                        && $leftKg < 0
                        ||
                        $bin->getVolume() > $leftValue
                        &&  $bin->getWeight() > $leftKg
                        &&  $bin->getWeight() > $leftKg
                    ) {
                        // if (isset($prevbin)) {
                        //     echo $prevbin->getName() ."!=". $bin->getName()." <br>\n";
                        //     if (
                        //         $prevbin->getName()
                        //         !=
                        //         $bin->getName()
                        //     ) {
                        //         break;
                        //     }
                        // } else {
                        if ($this->counter['bins'][$bin->getName()] == 0 && count($this->items))   break;
                        // }
                    }
                    //  } 

                }
                // echo  . " <br>\n";
                $binn =  new Bin($bin->getId(), $bin->getLength(), $bin->getHeight(), $bin->getBreadth(), $bin->getWeight());
                $this->addBin($binn);
                if (iterator_count($this->getIterableItems()) === 0) {
                    break;
                }
                // Pack item(s) to current open bin
                foreach ($this->items as $item) {
                    $this->packItemToBin($binn, $item);
                }
                $fittedItems = $binn->getFittedItems();
                $this->totalFittedVolume += $binn->getTotalFittedVolume();
                $this->totalFittedWeight += $binn->getTotalFittedWeight();

                foreach ($fittedItems as $fittedItem) {
                    // Remove the packed item(s)
                    if ($this->getIterableItems()->offsetExists($fittedItem->getId())) unset($this->items[$fittedItem->getId()]);
                }

                $totalItems =  count($this->items);
            }
            $loop++;
            if ($loop > 100) {
                // \print_r($this);
                // die;
                // throw new \UnexpectedValueException(count($this->items) . " Item left. To big to fit in.");
                break;
            }
        } while ($totalItems > 0 || $loop < 100);
    }
    /**
     * The json serialize method.
     * 
     * @return array The resulted object.
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
