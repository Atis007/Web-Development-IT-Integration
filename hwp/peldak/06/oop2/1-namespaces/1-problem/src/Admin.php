<?php

class User {
    public string $name = "Admin";

    public function getRole(): string {
        return "Administrator";
    }
}