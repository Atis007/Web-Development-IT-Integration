<?php
namespace Admin;

/**
 * Represents an administrator user
 */
class User {
    public string $name = "System Admin";

    public function getRole(): string {
        return "Administrator";
    }
}