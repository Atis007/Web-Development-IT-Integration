<?php

class User {
    public string $name = "John";

    public function getRole(): string {
        return "Regular user";
    }
}