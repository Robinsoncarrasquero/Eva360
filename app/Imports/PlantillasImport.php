<?php

namespace App\Imports;

use App\Plantilla;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow};

use Maatwebsite\Excel\Imports\HeadingRowFormatter;

//HeadingRowFormatter::default('none');


class PlantillasImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Plantilla([
            //
                'ubicacion' => $row['ubicacion'],
                'name' => $row['name'],
                'dni' => $row['dni'],
                'email' => $row['email'],
                'email_super' => $row['email_super'],
                'celular' => $row['celular'],
                'manager' => $row['manager'],
                'cargo' => $row['cargo'],
                'nivel_cargo' => $row['nivel_cargo'],

        ]);
    }

    // public function headingRow(): int
    // {
    //     return 1;
    // }

}
