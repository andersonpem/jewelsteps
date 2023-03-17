<?php

namespace App\Entity;

use Psr\Log\LoggerInterface;

class BaseEntity
{


    // Let's steal a function from Laravel.
    public function fill(array $data)
    {
        foreach ($data as $key=>$value) {
            $function = "set".ucfirst($key);
            // Watch out for curly braces in PHP v8. They work differently.
            if( method_exists($this, $function) )
            {
                $this->{$function}($value);
            }
            else {

            }
        }
    }
}