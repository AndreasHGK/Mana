<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\provider;

interface Provider {

    /**
     * Set the default mana that a player receives when joining
     *
     * @param int $mana
     */
    function setDefaultMana(int $mana) : void;


    /**
     * Closes the database or writes to the disk
     */
    function close() : void;

    /**
     * Add a player to the database, giving them the default mana
     *
     * @param string $uuid
     */
    function register(string $uuid) : void;

    /**
     * Checks whether or not a player exists in the database
     *
     * @param string $uuid
     * @return bool
     */
    function exists(string $uuid) : bool;

    /**
     * See how much mana a user has
     *
     * @param string $uuid
     * @return int
     */
    function getMana(string $uuid) : int;

    /**
     * Give mana to a certain user
     *
     * @param string $uuid
     * @param int $mana
     */
    function addMana(string $uuid, int $mana) : void;

    /**
     * Change a user's mana value
     *
     * @param string $uuid
     * @param int $mana
     */
    function setMana(string $uuid, int $mana) : void;

}