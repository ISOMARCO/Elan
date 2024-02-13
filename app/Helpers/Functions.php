<?php
function varName($var) : String
{
    foreach($GLOBALS as $var_name => $value)
    {
        if ($value === $var)
        {
            return $var_name;
        }
    }
    return "";
}
