<?php

namespace DMetibr;

/**
 * Esta classe contém funções para conversão entre RGB e HSL.
 */
class ConversaoEspacoCor
{
    /**
     * Converte de RGB para HSL.
     *
     * @param array $rgb Com os três valores ['red', 'green', 'blue'].
     *
     * @return array Com os três valores ['hue', 'saturation', 'lightness'].
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
    
        $hsl['lightness'] = (int) round($lightness, 2) * 100;
        $hsl['saturation'] = (int) round($saturation, 2) * 100;
        $hsl['hue'] = (int) round($hue);
        return $hsl;
    }

    /**
     * Converte de HSL para RGB.
     *
     * @param array $hsl Com os três valores ['hue', 'saturation', 'lightness'].
     *
     * @return array Com os três valores ['red', 'green', 'blue'].
     */
    public function hsltorgb($hsl)
    {
        $hue = $hsl['hue'] / 360;
        $saturation = $hsl['saturation'] / 100;
        $lightness = $hsl['lightness'] / 100;
    
        if ($saturation == 0) {
            $red = $green = $blue = $lightness * 255;
        } else {
            if ($lightness < 0.5) {
                $sl1 = $lightness * (1.0 + $saturation);
            } else {
                $sl1 = $lightness + $saturation - $lightness * $saturation;
            }
            $sl2 = 2 * $lightness - $sl1;
        
            $tmpR = $hue + 0.333333333333;
            $tmpG = $hue;
            $tmpB = $hue - 0.333333333333;
        
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
                $red = $sl2 + ($sl1 - $sl2) * (0.666666666666 - $tmpR) * 6;
            } else {
                $red = $sl2;
            }
        
            if (6 * $tmpG < 1) {
                $green = $sl2 + ($sl1 - $sl2) * 6 * $tmpG;
            } elseif (2 * $tmpG < 1) {
                $green = $sl1;
            } elseif (3 * $tmpG < 2) {
                $green = $sl2 + ($sl1 - $sl2) * (0.666666666666 - $tmpG) * 6;
            } else {
                $green = $sl2;
            }
        
            if (6 * $tmpB < 1) {
                $blue = $sl2 + ($sl1 - $sl2) * 6 * $tmpB;
            } elseif (2 * $tmpB < 1) {
                $blue = $sl1;
            } elseif (3 * $tmpB < 2) {
                $blue = $sl2 + ($sl1 - $sl2) * (0.666666666666 - $tmpB) * 6;
            } else {
                $blue = $sl2;
            }
        
            $red = $red * 255;
            $green = $green * 255;
            $blue = $blue * 255;
        }
    
        $rgb['red'] = (int) round($red);
        $rgb['green'] = (int) round($green);
        $rgb['blue'] = (int) round($blue);
        return $rgb;
    }

}
