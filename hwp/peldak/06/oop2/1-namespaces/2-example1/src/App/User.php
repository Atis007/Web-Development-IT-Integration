<?php
namespace App;

/**
 * Represents a regular application user
 */
class User {
    public string $name = "John Doe";

    public function getRole(): string {
        return "User";
    }
}