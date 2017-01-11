<?php
namespace Imagery;

class Tools {
	/**
	 * Calculates Perceptual hash of image.
	 * Algorithm:
	 * 1. Shrunk image.
	 * 2. Convert to gray-scale.
	 * 3. Calculate the average color of all image.
	 * 4. Compose a chain of bits that shows pixel color is higher of lower than average.
	 * 5. Convert result to hexadecimal string.
	 * @param Imagery $image Image you want get perceptual hash of.
	 * @return string Hash.
	 */
	static public function pHash(Imagery $image, $sizes = array(8, 8)) {
		$image = clone $image;
		$image->resize($sizes[0], $sizes[1]);
		imagefilter($image->resource, IMG_FILTER_GRAYSCALE);

		$x = $image->width - 1;
		$y = $image->height - 1;
		$sum = array('r' => 0, 'g' => 0, 'b' => 0);
		for ($i = 0; $i <= $y; $i++) {
			for ($j = 0; $j <= $x; $j++) {
				$color = imagecolorat($image->resource, $j, $i);
				$colors = imagecolorsforindex($image->resource, $color);
				$sum['r'] += $colors['red'];
				$sum['g'] += $colors['green'];
				$sum['b'] += $colors['blue'];
			}
		}

		$pixels = $image->width * $image->height;
		$average = array('r' => ceil($sum['r'] / $pixels), 'g' => ceil($sum['g'] / $pixels), 'b' => ceil($sum['b'] / $pixels));
		$average = hexdec(dechex($average['r']).dechex($average['g']).dechex($average['b']));

		// hash
		$hash = null;
		for ($i = 0; $i <= $y; $i++) {
			for ($j = 0; $j <= $x; $j++) {
				$color = imagecolorat($image->resource, $j, $i);
				if ($color > $average) {
					$hash .= 1;
				} else {
					$hash .= 0;
				}
			}
		}
		return base_convert($hash, 2, 16);
	}
}
