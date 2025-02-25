<?php
namespace Swim\Harbor;

/**
 * This is a way to make Crate globally accesible
 */

final class Cargo {
    private static array $crates = [];

    public static function new(string $name, Crate $crate) : void 
    {
        if (self::$crates[$name] ?? null) {
            throw new Exception("Cargo named $name already exist!");
        }
        self::$crates[$name] = $crate;
    }

    public static function open(string $name) : Crate 
    {
        $crate = self::$crates[$name] ?? null;
        if (null === $crate) {
            throw new Exception("Cargo $name does not exist!");
        }
        return $crate;
    }
}
