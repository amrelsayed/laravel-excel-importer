<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BooksImport implements ToCollection
{
    public $rows;

    public function collection(Collection $rows)
    {
        $this->rows = $rows;
    }
}
