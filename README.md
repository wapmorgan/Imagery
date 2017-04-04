## Imagery simplifies image manipulations.

Imagery supports:
- resizing
- cropping
- flipping and rotating
- making collages

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/imagery)](https://packagist.org/packages/wapmorgan/imagery)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/imagery/v/stable)](https://packagist.org/packages/wapmorgan/imagery)
[![Total Downloads](https://poser.pugx.org/wapmorgan/imagery/downloads)](https://packagist.org/packages/wapmorgan/imagery)
[![License](https://poser.pugx.org/wapmorgan/imagery/license)](https://packagist.org/packages/wapmorgan/imagery)

1. **Installation**
2. **API**

# Installation
* Composer package:
```
  composer require wapmorgan/imagery
```

# API
## Opening
Create new Imagery object
```php
use Imagery\Imagery;

$image = Imagery::createFromFile($filename);
// or
$image = Imagery::createWithSize($width, $height);
// or
$image = Imagery::createFromResource(imagecreatetruecolor(90, 90));
// or
$image = new Imagery(imagecreatefrombmp('image.bmp'));
```

## Saving
- `public function save($filename, $format, $quality)`
  Saves image to disk. Possible `$format` values: jpeg, png, gif, wbmp. Quality is an integer value between `0` (worst) and `100` (best).

## Properties
- `$width` - width of image
- `$height` - height of image
- `$resource` - original gd-resource of image (you can use it with gd-functions)

## Imagery
### Resize && Zoom
- `public function resize(int $width, int $height)` - resizes an image to `$width` X `$height`

**To minimize**
- `public function decreaseWidthTo(int $size)`

  Decreases proportionally image width to `$size`, if needed

- `public function decreaseHeightTo(int $size)`

  Decreases proportionally image height to `$size`, if needed

- `public function decreaseTo(int $size)`

  Decreases proportionally larger side to `$size`, if needed

**To maximize**
- `public function zoomWidthTo(int $size)`

  Changes proportionally image width to `$size`
- `public function zoomHeightTo(int $size)`

  Changes proportionally image height to `$size`

### Crop
- `public function crop($x, $y, $x2, $y2)`

  Cuts a rectangular piece of image

- `public function decreaseSide($side, int $size)`

  Deletes a piece of image from specific side. For example, if $side=top and $size=100, 100px from top will be deleted.

### Rotation && Mirroring
- `public function rotate($angle, $bgColor = 0)`

  Rotates an image. `True` equals 90°, `False` equals -90°.
- `public function flip($horizontally = true)`

  Flips an image horizontally or vertically.

### Collage
- `public function appendImageTo($side, Imagery $appendix, int $modifiers)`

  Appends an image (`$appendix`) to current image at `$side` (`top|bottom|left|right`). Modifiers:
  - `Imagery::ZOOM_IF_LARGER` - appendix' height will be zoomed (not resized) if it's larger than current image's one (when appending to left or right side); appendix' width will be zoomed (not resized) if it's larger than current image's one (when appending to top or bottom side);
- `public function placeImageAt($x, $y, Imagery $image)`

  Places an image atop current image at `$x` X `$y`.

- `public function placeImageAtCenter(Imagery $image)`

  Places an image in the center of current image.

## Tools
There's a tools class: `Imagery/Tools`.

- `static public function pHash(Imagery $image, $sizes = array(8, 8))`

  Calculates Perceptual hash of image.
