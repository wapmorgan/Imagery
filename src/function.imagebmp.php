<?php

if (function_exists('imagebmp'))
    return false;

// Save 24bit BMP files
// Author: de77
// Licence: MIT
// Webpage: de77.com
// Version: 07.02.2010
function imagebmp(&$img, $filename = false) {
    $wid = imagesx($img);
    $hei = imagesy($img);
    $wid_pad = str_pad('', $wid % 4, "\0");

    $size = 54 + ($wid + $wid_pad) * $hei;

    //prepare & save header
    $header['identifier'] = 'BM';
    $header['file_size'] = dword($size);
    $header['reserved'] = dword(0);
    $header['bitmap_data'] = dword(54);
    $header['header_size'] = dword(40);
    $header['width'] = dword($wid);
    $header['height'] = dword($hei);
    $header['planes'] = word(1);
    $header['bits_per_pixel']= word(24);
    $header['compression']= dword(0);
    $header['data_size'] = dword(0);
    $header['h_resolution'] = dword(0);
    $header['v_resolution'] = dword(0);
    $header['colors'] = dword(0);
    $header['important_colors'] = dword(0);
    if ($filename) {
        $f = fopen($filename, "wb");
        foreach ($header AS $h) {
            fwrite($f, $h);
        }

        //save pixels
        for ($y=$hei-1; $y>=0; $y--) {
            for ($x=0; $x<$wid; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                fwrite($f, byte3($rgb));
            }
            fwrite($f, $wid_pad);
        }
        return fclose($f);
    }

    else {
        foreach ($header AS $h) {
            echo $h;
        }

        //save pixels
        for ($y = $hei - 1; $y >= 0; $y--) {
            for ($x=0; $x<$wid; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                echo byte3($rgb);
            }
            echo $wid_pad;
        }
        return true;
    }
}
function byte3($n) {
    return chr($n & 255) . chr(($n >> 8) & 255) . chr(($n >> 16) & 255);
}
function dword($n) {
    return pack("V", $n);
}
function word($n) {
    return pack("v", $n);
}