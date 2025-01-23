<?php

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}
