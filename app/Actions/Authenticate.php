<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

class Authenticate {

    private array $credentials;
    private bool $remember;

    public function __construct(string $email, string $password, bool $remember = false)
    {
        $this->credentials = array("email" => $email, "password" => $password);
        $this->remember = $remember;
    }

    public function handle(): bool
    {
        return Auth::attempt($this->credentials, $this->remember) ? true : false;
    }
}