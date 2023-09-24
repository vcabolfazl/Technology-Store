<?php
/**
     * This file contains the helper functions and global variables.
     * You can access to this file content from anywhere.
     */

/**
 * hold the current page title
 */
$GLOBALS["CurrentPageTitle"] = NULL;

/**
 * a utility method that move user to specified url
 * @param $url
 */
function redirectTo($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

/**
 * a utility method that use to checking session status
 * @param $sessionKey
 * @return bool
 */
function isSessionExists($sessionKey) {
    return array_key_exists($sessionKey, $_SESSION) && !empty($_SESSION[$sessionKey]);
}

/**
 * a utility method that use to getting session value
 * @param $sessionKey
 * @return mixed
 */
function getSession($sessionKey) {
    return $_SESSION[$sessionKey];
}

/**
 * a utility method that use to hash password
 * @param $plainPassword
 * @return bool|string
 */
function getSecurePassword($plainPassword) {
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

/**
 * a utility method that use to verify hashed passwords
 * @param $password
 * @param $hashedPassword
 * @return bool
 */
function matchPasswords($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

/**
 * a utility method that use to settings current page title
 * @param $title
 */
function setPageTitle($title) {
    $GLOBALS["CurrentPageTitle"] = $title;
}

/**
 * a utility method that use to get current page title
 */
function getPageTitle() {
    return $GLOBALS["CurrentPageTitle"];
}

/**
 * a utility method that use to convert product image url to local path
 * @param $url
 * @return string
 */
function convertImageUrlToPath($url) {
    $fileName = basename($url);
    return PRODUCTS_IMAGES_PATH.$fileName;
}
