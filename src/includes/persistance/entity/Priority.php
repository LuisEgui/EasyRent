<?php

namespace easyrent\includes\persistance\entity;

/**
 * Class for ad priority
 */
class Priority {

    /**
     * @var string Unique priority identifier
     */
    private $p_id;

    /**
     * @var string Priority level.
     * Current levels: 1 and 2
     */
    private $level;

    /**
     * @var float Priority price
     */
    private $price;

    /**
     * Creates a Priority object
     * @param string $p_id Unique priority id
     * @param string $level Priority level. Posible values: 1 and 2
     * @param float $price Priority price
     * @return void
     */
    public function __construct($p_id = null, $level, $price)
    {
        $this->p_id = $p_id;
        $this->level = $level;
        $this->price = $price;
    }

    /**
     * Returns priority's id
     * @return string p_id
     */
    public function getId()
    {
        return $this->p_id;
    }

    /**
     * Returns priority's level
     * @return string level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Returns priority's price
     * @return string price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets priority's id
     * @param string $p_id Priority's id
     * @return void
     */
    public function setId($p_id)
    {
        $this->p_id = $p_id;
    }

    /**
     * Sets priority's level
     * @param string $level Priority's level
     * @return void
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Sets priority's price
     * @param string $price Priority's price
     * @return void
     */
    public function setPrice($price) {
        $this->price = $price;
    }

}
