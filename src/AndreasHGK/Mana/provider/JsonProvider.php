<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\provider;

final class JsonProvider implements Provider {

    /**
     *
     * @var string
     */
    private string $file;

    /**
     * This stores everyone's mana in memory
     * @var int[]
     */
    private array $memory = [];

    private int $defaultMana = 100;

    public function setDefaultMana(int $mana) : void {
        $this->defaultMana = $mana;
    }

    public function register(string $uuid) : void {
        $this->memory[$uuid] = $this->defaultMana;
    }

    public function exists(string $uuid) : bool {
        return isset($this->memory[$uuid]);
    }

    public function getMana(string $uuid) : int {
        return $this->memory[$uuid];
    }

    public function addMana(string $uuid, int $mana) : void {
        $this->memory[$uuid] += $mana;
    }

    public function setMana(string $uuid, int $mana) : void {
        $this->memory[$uuid] = $mana;
    }

    public function close() : void {
        $json = json_encode($this->memory);
        file_put_contents($this->file, $json);
    }

    public function __construct(string $filepath) {
        $this->file = $filepath;
        if(!file_exists($filepath)) {
            // We run close() since it just saves the file
            $this->close();
        } else {
            $content = file_get_contents($filepath);
            $this->memory = json_decode($content, true);
        }
    }

}