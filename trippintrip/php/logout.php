<?php

session_start();

function clearUserSession() {
    session_unset();
    session_destroy();
}