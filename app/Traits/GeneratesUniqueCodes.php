<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesUniqueCodes
{
    /**
     * Generate a unique code.
     *
     * @param string $modelClass
     * @param string $attribute
     * @param int $length
     * @return string
     */
    public function generateUniqueCode($modelClass, $attribute = 'code', $length = 10)
    {
        $code = Str::random($length);

        // Check if the generated code already exists in the database
        while ($modelClass::where($attribute, $code)->exists()) {
            $code = Str::random($length);
        }

        return $code;
    }
}
