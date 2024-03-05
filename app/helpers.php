<?php
function money($value, $decimal = 2)
{
    return number_format((float)$value, $decimal, ',');
}