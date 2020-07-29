<?php

namespace DMetibr;

/**
 * Esta classe contém funções para conversão entre RGB, HSL e HSV.
 */
class ConversaoEspacoCor
{
    /**
     * Converte de RGB para HSL.
     *
     * @param array $rgb ['red', 'green', 'blue'].
     *
     * @return array ['hue', 'saturation', 'lightness'].
     */
    public function rgbtohsl($rgb)
    {
        $red = $rgb['red'] / 255;
        $green = $rgb['green'] / 255;
        $blue = $rgb['blue'] / 255;
    
        $max = max($red, $green, $blue);
        $min = min($red, $green, $blue);
    
        $lightness = ($max + $min) / 2;
    
        if ($max == $min) {
            $saturation = 0;
            $hue = 0;
        } else {
            if ($lightness < 0.5) {
                $saturation = ($max - $min) / ($max + $min);
            } else {
                $saturation = ($max - $min) / (2.0 - $max - $min);
            }
           if ($red >= $green and $red >= $blue) {
                $hue = (($green - $blue) / ($max - $min)) * 60; // red
            } elseif ($green >= $red and $green >= $blue) {
                $hue = (2.0 + ($blue - $red) / ($max - $min)) * 60; // green
            } else {
                $hue = (4.0 + ($red - $green) / ($max - $min)) * 60; // blue
            }
            if ($hue < 0) {
                $hue = $hue + 360;
            }
        }
    
        $hsl['hue'] = (int) round($hue);
        $hsl['saturation'] = (int) round($saturation * 100);
        $hsl['lightness'] = (int) round($lightness * 100);
        return $hsl;
    }

    /**
     * Converte de HSL para RGB.
     *
     * @param array $hsl ['hue', 'saturation', 'lightness'].
     *
     * @return array ['red', 'green', 'blue'].
     */
    public function hsltorgb($hsl)
    {
        $hue = $hsl['hue'] / 360;
        $saturation = $hsl['saturation'] / 100;
        $lightness = $hsl['lightness'] / 100;
    
        if ($saturation == 0) {
            $red = $green = $blue = $lightness;
        } else {
            if ($lightness < 0.5) {
                $sl1 = $lightness * (1.0 + $saturation);
            } else {
                $sl1 = $lightness + $saturation - $lightness * $saturation;
            }
            $sl2 = 2 * $lightness - $sl1;
        
            $tmpR = $hue + 1/3;
            $tmpG = $hue;
            $tmpB = $hue - 1/3;
        
            if ($tmpR < 0) {
                $tmpR = $tmpR + 1;
            } elseif ($tmpR > 1) {
                $tmpR = $tmpR - 1;
            }
            if ($tmpG < 0) {
                $tmpG = $tmpG + 1;
            } elseif ($tmpG > 1) {
                $tmpG = $tmpG - 1;
            }
            if ($tmpB < 0) {
                $tmpB = $tmpB + 1;
            } elseif ($tmpB > 1) {
                $tmpB = $tmpB - 1;
            }
    
            if (6 * $tmpR < 1) {
                $red = $sl2 + ($sl1 - $sl2) * 6 * $tmpR;
            } elseif (2 * $tmpR < 1) {
                $red = $sl1;
            } elseif (3 * $tmpR < 2) {
                $red = $sl2 + ($sl1 - $sl2) * (2/3 - $tmpR) * 6;
            } else {
                $red = $sl2;
            }
        
            if (6 * $tmpG < 1) {
                $green = $sl2 + ($sl1 - $sl2) * 6 * $tmpG;
            } elseif (2 * $tmpG < 1) {
                $green = $sl1;
            } elseif (3 * $tmpG < 2) {
                $green = $sl2 + ($sl1 - $sl2) * (2/3 - $tmpG) * 6;
            } else {
                $green = $sl2;
            }
        
            if (6 * $tmpB < 1) {
                $blue = $sl2 + ($sl1 - $sl2) * 6 * $tmpB;
            } elseif (2 * $tmpB < 1) {
                $blue = $sl1;
            } elseif (3 * $tmpB < 2) {
                $blue = $sl2 + ($sl1 - $sl2) * (2/3 - $tmpB) * 6;
            } else {
                $blue = $sl2;
            }
        }
    
        $rgb['red'] = (int) round($red * 255);
        $rgb['green'] = (int) round($green * 255);
        $rgb['blue'] = (int) round($blue * 255);
        return $rgb;
    }
    
    /**
     * Converte de RGB para HSV.
     *
     * @param array $rgb ['red', 'green', 'blue'].
     *
     * @return array ['hue', 'saturation', 'value'].
     */
    public function rgbtohsv($rgb)
    {
        $red = $rgb['red'] / 255;
        $green = $rgb['green'] / 255;
        $blue = $rgb['blue'] / 255;
    
        $value = max($red, $green, $blue);
        $x = min($red, $green, $blue);
        
        if ($value == 0) {
            $saturation = 0;
            $hue = 0;
        } else {
            $saturation = ($value - $x) / $value;
            
            $r = ($value - $red) / ($value - $x);
            $g = ($value - $green) / ($value - $x);
            $b = ($value - $blue) / ($value - $x);
        
            if ($red == $value) {
                if ($green == $x) {
                    $hue = 5 + $b;
                } else {
                    $hue = 1 - $g;
                }
            } elseif ($green == $value) {
                if ($blue == $x) {
                    $hue = 1 + $r;
                } else {
                    $hue = 3 - $b;
                }
            } else {
                if ($red == $x) {
                    $hue = 3 + $g;
                } else {
                    $hue = 5 - $r;
                }
            }
            $hue = $hue / 6;
        }
        
        $hsv['hue'] = (int) round($hue * 360);
        $hsv['saturation'] = (int) round($saturation * 100);
        $hsv['value'] = (int) round($value * 100);
        return $hsv;
    }
    
    /**
     * Converte de HSV para RGB.
     *
     * @param array $hsv ['hue', 'saturation', 'value'].
     *
     * @return array ['red', 'green', 'blue'].
     */
    public function hsvtorgb($hsv)
    {
        if ($hsv['hue'] == 360) {
            $hsv['hue'] = 0;
        }
        $hue = $hsv['hue'] / 360;
        $saturation = $hsv['saturation'] / 100;
        $value = $hsv['value'] / 100;
        
        $hue = 6 * $hue;
        $i = floor($hue);
        $f = $hue - $i;
        $m = $value * (1 - $saturation);
        $n = $value * (1 - $saturation * $f);
        $k = $value * (1 - $saturation * (1 - $f));
        
        switch ($i) {
            case 0:
                $red = $value; $green = $k;     $blue = $m;
                break;
            case 1:
                $red = $n;     $green = $value; $blue = $m;
                break;
            case 2:
                $red = $m;     $green = $value; $blue = $k;
                break;
            case 3:
                $red = $m;     $green = $n;     $blue = $value;
                break;
            case 4:
                $red = $k;     $green = $m;     $blue = $value;
                break;
            case 5:
                $red = $value; $green = $m;     $blue = $n;
                break;
        }
        
        $rgb['red'] = (int) round($red * 255);
        $rgb['green'] = (int) round($green * 255);
        $rgb['blue'] = (int) round($blue * 255);
        return $rgb;
    }

}
