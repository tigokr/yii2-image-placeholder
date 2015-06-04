<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 03.06.2015
 * Time: 23:05
 */
// Usage (all parameters are optional):
// <img src="placeholder/400x150?bg=eee&fg=999&text=Generated+image" alt="Placeholder image" />
// based on

namespace tigokr\imageplaceholder;

class PlaceholderController extends \yii\web\Controller
{

    // Convert hex to rgb (modified from csstricks.com)
    public function actionIndex()
    {
        // Dimensions
        $getsize = isset($_GET['size']) ? $_GET['size'] : '100';
        $dimensions = explode('x', $getsize);
        if(count($dimensions) == 1)
            $dimensions[1] = $dimensions[0];

        // Create image
        $image = imagecreate($dimensions[0], $dimensions[1]);

        // Colours
        $bg = isset($_GET['bg']) ? $_GET['bg'] : 'ccc';
        $bg = $this->hex2rgb($bg);
        $setbg = imagecolorallocate($image, $bg['r'], $bg['g'], $bg['b']);

        $fg = isset($_GET['fg']) ? $_GET['fg'] : '555';
        $fg = $this->hex2rgb($fg);
        $setfg = imagecolorallocate($image, $fg['r'], $fg['g'], $fg['b']);

        $fontsize = isset($_GET['fs']) ? $_GET['fs'] : 24;

        // Text
        $text = isset($_GET['text']) ? strip_tags($_GET['text']) : implode('x', $dimensions);
        $text = str_replace('+', ' ', $text);
        $font = dirname(__FILE__).'/arial.ttf';

        // Text positioning
        $box = imagettfbbox($fontsize, 0, $font, $text);
        $fontwidth = abs($box[4] - $box[0]);
        $fontheight = abs($box[5] - $box[1]);
        $textwidth = $fontwidth;

        $xpos = (imagesx($image) - $textwidth) / 2;
        $ypos = (imagesy($image) + $fontheight) / 2;

        // Generate text
        imagettftext($image, $fontsize, 0, $xpos, $ypos, $setfg, $font, $text);

        // Render image
        ob_start();
        imagepng($image);
        $image = ob_get_clean();

        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        header("Content-type: image/png");
        return $image;
    }

    protected function hex2rgb($colour)
    {
        $colour = preg_replace("/[^abcdef0-9]/i", "", $colour);
        if (strlen($colour) == 6) {
            list($r, $g, $b) = str_split($colour, 2);
            return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
            return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
        }
        return false;
    }

    protected function toUnicodeEntities($text, $from = "w")
    {
        $text = convert_cyr_string($text, $from, "i");
        $uni = "";
        for ($i = 0, $len = strlen($text); $i < $len; $i++) {
            $char = $text{$i};
            $code = ord($char);
            $uni .= ($code > 175) ? "&#" . (1040 + ($code - 176)) . ";" : $char;
        }
        return $uni;
    }

}