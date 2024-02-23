<?php
function Border_Random_Color() : string
{
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    return sprintf("#%02x%02x%02x", $red, $green, $blue);
}
