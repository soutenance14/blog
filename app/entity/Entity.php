<?php

// define('USER_NOT_AUTHENTIFIED', null);
// define('USER_AUTHENTIFIED', 0);
// define('ADMIN', 1);
Abstract Class Entity
{
    // functions

    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            if(stristr($key, '_')){
                $keys = explode('_', $key);
                $nb_keys = count($keys);
                $keyCamelCase = $keys[0];
                for( $i=1; $i < $nb_keys; $i++)
                {
                    $keyCamelCase.=ucfirst($keys[$i]);
                }
                $key = $keyCamelCase;
            }
            $method = 'set'.ucfirst($key);
            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
}