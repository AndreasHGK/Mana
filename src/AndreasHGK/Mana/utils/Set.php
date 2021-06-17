<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\utils;

class Set implements \ArrayAccess {

    /**
     * Create a set object, which is inspired by java sets
     * and should be more performant in some scenarios
     *
     * @param array $values
     * @return static
     */
    public static function create(array $values) : self {
        $set = new self;
        $set->addAll($values);
        return $set;
    }

    private array $data = [];

    public function addAll(array $values) : void {
        foreach($values as $value) {
            $this->data[$value] = "";
        }
    }

    public function add($value) : void {
        $this->data[$value] = "";
    }

    public function remove($value) : void {
        unset($this->data[$value]);
    }

    public function contains($value) : bool {
        return isset($this->data[$value]);
    }

    // ArrayAccess

    /**
     * Used as isset($set[$offset])
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) : bool {
        return $this->contains($offset);
    }

    /**
     * Has the same behaviour as Set::contains()
     * Used as $set[$offset]
     *
     * @param mixed $offset
     * @return bool whether or not the offset exists
     */
    public function offsetGet($offset) : bool {
        return $this->contains($offset);
    }

    /**
     * Used as $set[$offset] = $value
     *
     * @param mixed $offset
     * @param mixed $value if false or null, remove the offset otherwise set the offset
     */
    public function offsetSet($offset, $value) {
        if($value === false || $offset === null) {
            if(!$this->contains($offset)) {
                return;
            }
            $this->remove($offset);
        }
        $this->add($offset);
    }

    /**
     * Used as unset()
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        $this->remove($offset);
    }

}