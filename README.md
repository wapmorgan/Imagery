## Imagery simplifies image manipulations.

_Imagery_ supports:
- resizing
- cropping
- flipping and rotating
- making collages
- applying filters and effects

[![Composer package](http://composer.network/badge/wapmorgan/imagery)](https://packagist.org/packages/wapmorgan/imagery)
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
## Imagery
```php
use Imagery\Imagery;
```
### Opening
Create new Imagery object:
- `$image = Imagery::open($filename);` - from a file.
- `$image = Imagery::create($width, $height);` - new image
- `$image = new Imagery(imagecreatefrombmp('image.bmp'));` - from a resource

### Saving
- `public function save($filename, $quality = 75, $format = null)` - saves image to disk.
Quality is an integer value between `0` (worst) and `100` (best). Default is `75`. Quality is applicable only to JPEG, PNG, WEBP. If `$format` can not be determined by filename extension, specifcy it explicitly.

Formats supports:

| Operation | Formats                                                  |
|-----------|----------------------------------------------------------|
| Opening   | jpeg, png, gif, bmp, wbmp, xbm, xpm, webp (php >= 7.1.0) |
| Saving    | jpeg, png, gif, bmp, wbmp, xbm, webp (php >= 7.1.0)      |

### Properties
- `$image->width` - width of image
- `$image->height` - height of image
- `$image->resource` - original gd-resource of image (you can use it with gd-functions)

### Resize && Zoom
- `public function resize(int $width, int $height)` - resizes an image to `$width` X `$height`
- `public function zoomWidthTo(int $size)` - changes proportionally image width to `$size`
- `public function zoomHeightTo(int $size)` - changes proportionally image height to `$size`
- `public function zoomMaxSide(int $size)` - zoomes proportionally larger side to `$size`, if needed

### Crop
- `public function crop($x, $y, $x2, $y2)` - cuts a rectangular piece of image
- `public function decreaseSide($side, int $size)` - deletes a piece of image from specific side. For example, if $side=top and $size=100, 100px from top will be deleted.

### Rotation && Mirroring
- `public function rotate($angle, $bgColor = 0)` - rotates an image. `True` equals 90°, `False` equals -90°.
- `public function flip($horizontally = true)` - flips an image horizontally or vertically.

### Collage
- `public function appendImageTo($side, Imagery $appendix, int $modifiers)` - appends an image (`$appendix`) to current image at `$side` (`top|bottom|left|right`). Modifiers:
  - `Imagery::ZOOM_IF_LARGER` - appendix' height will be zoomed (not resized) if it's larger than current image's one (when appending to left or right side); appendix' width will be zoomed (not resized) if it's larger than current image's one (when appending to top or bottom side);
- `public function placeImageAt($x, $y, Imagery $image)` - places an image atop current image at `$x` X `$y`.

- `public function placeImageAtCenter(Imagery $image)` - places an image in the center of current image.

### Effects
- `public function filter($filter)` - applies grayscale or negate filter. Pass `Imagery::FILTER_NEGATE` or `Imagery::FILTER_GRAYSCALE` as $filter.

  Grayscale:

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Grayscale](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/grayscale_original.png)

  Negate:

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/negate_original.png)

- `public function changeContrast($newValue)` - changes contrast of image. New values can be in range from 100 (max contrast) to -100 (min contrast), 0 means no change.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/contrast_original.png)

- `public function changeBrightness($newValue)` - changes brightness of image. New values can be in range from 255 (max brightness) to -255 (min brightness), 0 means no change.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/brightness_original.png)

- `public function colorize($red, $green, $blue, $alpha = 127)` - changes colors of image. Colors (`$red, $green, $blue`) can be in range from 255 to -255. `$alpha` from 127 to 0.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/colorize_original.png)

- `public function blur($method)` - blurs an image. Method can be `Imagery::GAUSSIAN_BLUR` or `Imagery::SELECTIVE_BLUR`.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/blur_original.png)

- `public function smooth($level)` - smooths an image. Level of smoothness can be in range from 0 to 8. 8 is un-smooth.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/smooth_original.png)

- `public function pixelate($blockSize = 5, $useModernEffect = true)` - pixelates an image. `$blockSize` is size of pixel block.

  ![Original](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/original.png)
  ->
  ![Negate](https://github.com/wapmorgan/Imagery/releases/download/1.0.0/pixelate_original.png)

## Tools
There's a tools class: `Imagery/Tools`.

- `static public function pHash(Imagery $image, $sizes = array(8, 8))`

  Calculates Perceptual hash of image.
