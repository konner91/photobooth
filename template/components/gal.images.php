<?php

use Photobooth\Service\LanguageService;
use Photobooth\Utility\PathUtility;

$languageService = LanguageService::getInstance();

if (empty($imagelist)) {
    echo '<h1 style="text-align:center">' . $languageService->translate('gallery_no_image') . '</h1>' . "\n";
} else {
    echo '<div class="gallery__body" id="galimages">' . "\n";
    foreach ($imagelist as $image) {
        try {
            $date = $config['ui']['branding'] . ' Gallery';
            if ($config['picture']['naming'] === 'dateformatted' && $config['gallery']['show_date']) {
                if ($config['database']['file'] != 'db') {
                    $db = strlen($config['database']['file']);
                    $name = substr($image, ++$db);
                } else {
                    $name = $image;
                }
                $dateObject = DateTime::createFromFormat('Ymd_His', substr($name, 0, strlen($name) - 4));
                if ($dateObject) {
                    $date = '<i class="' . $config['icons']['date'] . '"></i> ' . $dateObject->format($config['gallery']['date_format']);
                }
            }

            $filename_photo = PathUtility::getAbsolutePath($config['folders']['data'] . DIRECTORY_SEPARATOR . $config['folders']['images'] . DIRECTORY_SEPARATOR . $image);
            $filename_thumb = PathUtility::getAbsolutePath($config['folders']['data'] . DIRECTORY_SEPARATOR . $config['folders']['thumbs'] . DIRECTORY_SEPARATOR . $image);

            $imageinfo = @getimagesize($filename_photo);
            $imageinfoThumb = @getimagesize($filename_thumb);

            if (is_array($imageinfo)) {
                if (!is_array($imageinfoThumb)) {
                    $imageinfoThumb = $imageinfo;
                }
                echo '<a href="' . PathUtility::getPublicPath($filename_photo) . '" class="gallery__img rotaryfocus" data-size="' . $imageinfo[0] . 'x' . $imageinfo[1] . '"';
                echo ' data-pswp-width="' . $imageinfo[0] . '" data-pswp-height="' . $imageinfo[1] . '"';
                echo ' data-med="' . PathUtility::getPublicPath($filename_thumb) . '" data-med-size="' . $imageinfoThumb[0] . 'x' . $imageinfoThumb[1] . '">' . "\n";
                echo '<figure class="' . $uiShape . '">' . "\n";
                echo '<img class="' . $uiShape . '" src="' . PathUtility::getPublicPath($filename_thumb) . '" alt="' . $image . '" />' . "\n";
                if ($config['gallery']['figcaption']) {
                    echo '<figcaption class="' . $uiShape . '">' . $date . '</figcaption>' . "\n";
                }
                echo '</figure>' . "\n";
                echo '</a>' . "\n";
            }
        } catch (Exception $e) {
            // Empty catch block
            // ignore errors for niw
        }
    }
}
echo '</div>' . "\n";
