<?php
function setCookies($type)
{
    setcookie('logincookie',$type, time() + (86400), "/");
}