<?php
namespace Imagery;

class Filters {
    static public function bhThreshold(Imagery $image) {
        $result = clone $image;
        $result->filter(Imagery::FILTER_GRAYSCALE);
        return $result;
    }
}
