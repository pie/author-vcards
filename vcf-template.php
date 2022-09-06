<?php

/**
 * VCard generator test - can save to file or output as a download
 */

require_once __DIR__ . '/vendor/autoload.php';


use JeroenDesloovere\VCard\VCard;

// define vcard
$vcard = new VCard();

$user = get_queried_object()->data;
$meta            = get_user_meta($user->ID);
foreach ($meta as $key => $value) {
    $user->$key = $value[0];
}

$user->position = get_field('position', 'user_' . $user->ID);
$user->location = get_field('location', 'user_' . $user->ID);
// define variables
$firstname = $user->first_name;
$lastname = $user->last_name;
$additional = '';
$prefix = '';
$suffix = '';

// add personal data
$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

// add work data
$vcard->addCompany(strtolower($user->location) == 'dublin' ? 'Beale & Co LLP' : 'Beale & Co');
$vcard->addJobtitle($user->position);
$vcard->addEmail($user->user_email);
$vcard->addPhoneNumber($user->telephone, 'PREF;WORK');
$vcard->addPhoneNumber($user->mobile_telephone, 'MOBILE');
$vcard->addURL(get_author_posts_url($user->ID));
$vcard->addPhoto(get_attached_file(get_field('photo', 'user_' . $user->ID)));
//$vcard->addPhoto('https://raw.githubusercontent.com/jeroendesloovere/vcard/master/tests/image.jpg');

// return vcard as a string


// return vcard as a download
return $vcard->download();

// echo message
// echo 'A personal vCard is saved in this folder: ' . __DIR__;

// or

// save the card in file in the current folder
// return $vcard->save();

// echo message
// echo 'A personal vCard is saved in this folder: ' . __DIR__;
