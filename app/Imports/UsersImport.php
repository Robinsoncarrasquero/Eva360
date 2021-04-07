<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'name' => $row[0],
                'email'=> $row[1],
                'password'=> Hash::make('secret'),
                'phone_number'=>'1234567890',
            ]);
        }
    }
}

