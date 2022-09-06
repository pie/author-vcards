<?php

/**
 * VCard generator test - can save to file or output as a download
 */

require_once __DIR__ . '/vendor/autoload.php';


use JeroenDesloovere\VCard\VCard;

// define vcard
$vcard = new VCard();

$user = get_queried_object()->data;
$meta = get_user_meta($user->ID);

foreach ($meta as $key => $value) {
    $user->$key = $value[0];
}

// define variables
$firstname = $user->first_name;
$lastname = $user->last_name;
$additional = '';
$prefix = '';
$suffix = '';


// add personal data
$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

// add work data
$vcard->addCompany(apply_filters('pie-avc-company', $user->company));
$vcard->addJobtitle(apply_filters('pie-avc-position', $user->position));
$vcard->addEmail($user->user_email);
$vcard->addPhoneNumber(apply_filters('pie-avc-telephone-work', $user->telephone), 'PREF;WORK');
$vcard->addPhoneNumber(apply_filters('pie-avc-telephone-mobile', $user->mobile_telephone ), 'MOBILE');
$vcard->addURL(get_author_posts_url($user->ID));
$vcard->addPhoto(get_attached_file(get_field('photo', 'user_' . $user->ID)));


return $vcard->download();