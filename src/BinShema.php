<?php

/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 */

declare(strict_types=1);

namespace Latuconsinafr\BinPackager\BinPackager3D;

use Latuconsinafr\BinPackager\BinPackager3D\Handlers\IntersectionHandler;
use Latuconsinafr\BinPackager\BinPackager3D\Types\AxisType;
use Latuconsinafr\BinPackager\BinPackager3D\Types\RotationCombinationType;

/**
 * A class representative of a single bin to put @see Item into.
 */
final class BinShema implements \JsonSerializable
{
    /**
     * @var mixed The bin's id.
     */
    private $id;

    /**
     * @var mixed The bin's name.
     */
    private $name;

    /**
     * @var float The bin's length.
     */
    private float $length;

    /**
     * @var float The bin's breadth.
     */
    private float $breadth;

    /**
     * @var float The bin's height.
     */
    private float $height;

    /**
     * @var float The bin's volume.
     */
    private float $volume;

    /**
     * @var float The bin's weight.
     */
    private float $weight;

    /**
     * @var iterable The fitted item(s) inside the bin.
     */
    private iterable $fittedItems;


    /**
     * @param mixed $id The identifier of the bin.
     * @param float $length The length of the bin.
     * @param float $height The height of the bin.
     * @param float $breadth The breadth of the bin.
     * @param float $weight The weight of the bin.
     */
    public function __construct($id, float $length, float $height, float $breadth, float $weight)
    {
        $this->id = $id;
        $this->name = $id;

        $this->length = $length;
        $this->height = $height;
        $this->breadth = $breadth;
        $this->volume = (float) $this->length * $this->height * $this->breadth;
        $this->weight = $weight;

        $this->fittedItems = [];
    }

    /**
     * The bin's name getter.
     * 
     * @return mixed The bin's name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The bin's id getter.
     * 
     * @return mixed The bin's id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The bin's length getter.
     * 
     * @return float The bin's length.
     */
    public function getLength(): float
    {
        return $this->length;
    }

    /**
     * The bin's height getter.
     * 
     * @return float The bin's height.
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * The bin's breadth getter.
     * 
     * @return float The bin's breadth.
     */
    public function getBreadth(): float
    {
        return $this->breadth;
    }

    /**
     * Get the bin's volume.
     * 
     * @return float The bin's volume.
     */
    public function getVolume(): float
    {
        return $this->volume;
    }

    /**
     * The bin's weight getter.
     * 
     * @return float The bin's weight.
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * The bin's fitted items getter.
     * 
     * @return iterable The bin's fitted items.
     */
    public function getFittedItems(): iterable
    {
        return $this->fittedItems;
    }


    /**
     * Set the number of digits after the decimal point of bin's values.
     * 
     * @param mixed $precision The number of digits after the decimal point.
     * 
     * @return void
     */
    public function setPrecision($precision): void
    {
        $this->length = round($this->length, $precision);
        $this->height = round($this->height, $precision);
        $this->breadth = round($this->breadth, $precision);
        $this->volume = round($this->volume, $precision);
        $this->weight = round($this->weight, $precision);
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
