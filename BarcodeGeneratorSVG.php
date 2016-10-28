<?php 
/**
 * Return SVG format
 */
class BarcodeGeneratorSVG extends BarcodeGenerator{
	
	public function getBarcode($code, $type, $widthFactor = 2, $totalHeight = 30, $color = 'black')
    {
        $barcodeData = $this->getBarcodeData($code, $type);
        // replace table for special characters
        $repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
        $svg = '<?xml version="1.0" standalone="no" ?>' . "\n";
        $svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
        $svg .= '<svg width="' . round(($barcodeData['maxWidth'] * $widthFactor),
                3) . '" height="' . $totalHeight . '" version="1.1" xmlns="http://www.w3.org/2000/svg">' . "\n";
        $svg .= "\t" . '<desc>' . strtr($barcodeData['code'], $repstr) . '</desc>' . "\n";
        $svg .= "\t" . '<g id="bars" fill="' . $color . '" stroke="none">' . "\n";
        // print bars
        $positionHorizontal = 0;
        foreach ($barcodeData['bars'] as $bar) {
            $barWidth = round(($bar['width'] * $widthFactor), 3);
            $barHeight = round(($bar['height'] * $totalHeight / $barcodeData['maxHeight']), 3);
            if ($bar['drawBar']) {
                $positionVertical = round(($bar['positionVertical'] * $totalHeight / $barcodeData['maxHeight']), 3);
                // draw a vertical bar
                $svg .= "\t\t" . '<rect x="' . $positionHorizontal . '" y="' . $positionVertical . '" width="' . $barWidth . '" height="' . $barHeight . '" />' . "\n";
            }
            $positionHorizontal += $barWidth;
        }
        $svg .= "\t" . '</g>' . "\n";
        $svg .= '</svg>' . "\n";
        return $svg;
    }
}
 ?>