<?php

function toArray($data)
{
    return json_decode(json_encode($data), true);
}