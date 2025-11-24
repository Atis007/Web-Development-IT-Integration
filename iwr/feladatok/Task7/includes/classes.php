<?php
class Worker {
    public int $id_worker;
    public string $name;
    public string $surname;
    public string $company;
    public string $position;
    public string $email;
    public string $phone;
    public string $created_at;
    public string $updated_at;
}

class QrCodeData {
    public int $id_worker;
    public string $name;
    public string $generated_at;
    public string $updated_at;
}