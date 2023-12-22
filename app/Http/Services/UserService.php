<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserService{

    public function create(array $data, String $password){
        User::create([
            ...$data,
            'uuid' => Str::uuid(),
            'password' => Hash::make($password)
        ]);
    }
}
