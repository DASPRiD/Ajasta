<?php
$localeDataUrl = 'http://i18napis.appspot.com/address/data';
$locales       = json_decode(file_get_contents($localeDataUrl));

if (isset($locales->countries)) {
    $countries = explode('~', $locales->countries);
    $countries[] = 'ZZ';

    foreach ($countries as $country) {
        file_put_contents(__DIR__ . '/' . $country . '.json', file_get_contents($localeDataUrl . '/' . $country));
    }
}
