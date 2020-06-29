<?php


class PuppyPoop
{
    private $sourcePath;
    private $thumbnailPath;

    public function __construct($sourcePath, $thumbnailPath)
    {
        $this->sourcePath = $sourcePath;
        $this->thumbnailPath = $thumbnailPath;
    }

    public function getImage($url)
    {
        $filename = md5($url) . '-' . basename($url);

        if (!is_file($this->sourcePath . '/' . $filename)) {
            file_put_contents(
                $this->sourcePath . '/' . $filename,
                file_get_contents($url)
            );
        }

        return $this->sourcePath . '/' . $filename;
    }

    public function crop($source, $outputWidth, $outputHeight, $x, $y, $offsetLeft = 0, $offsetTop = 0, $centerFocusPoint = false)
    {
        if (!is_file($this->sourcePath . '/' . basename($source))) {
            throw new Exception('File does not exists');
        }

        $data = getimagesize($source);

        if(!$data) {
            throw new Exception('Can not retrieve image data (...'.basename($source).')');
        }


        $width = (int) $data[0];
        $height = (int) $data[1];

        if (!(int) $outputWidth) {
            $outputWidth = $width;
        }
        if (!(int) $outputHeight) {
            $outputHeight = $height;
        }

        $destination = $this->thumbnailPath . '/' .
        $outputWidth . '-' . $outputHeight . '-' . $x . '-' . $y . '-' . $offsetLeft . '-' . $offsetTop . '-' . (int) $centerFocusPoint . '-' . basename($source);

        if (is_file($destination)) {
            return $destination;
        }

        $outputX = $width / 2 + $offsetLeft;
        $outputY = $height / 2 + $offsetTop;

        if ($centerFocusPoint) {
            $outputX = $x + $offsetLeft;
            $outputY = $y + $offsetTop;
        }

        $ratioX = $outputWidth / $width;
        $ratioX = max(
            $ratioX,
            ($outputWidth / 2) / $outputX,
            ($outputWidth / 2) / ($width - $outputX)
        );

        $ratioY = $outputHeight / $height;
        $ratioY = max(
            $ratioY,
            ($outputHeight / 2) / $outputY,
            ($outputHeight / 2) / ($height - $outputY)
        );

        $ratio = (float) max($ratioX, $ratioY);

        if (!$centerFocusPoint) {
            $xFromCenter = ($width / 2 - $x) * $ratio;
            $yFromCenter = ($height / 2 - $y) * $ratio;

            $recenter = false;
            if (abs($xFromCenter) > $outputWidth / 2) {
                $recenter = true;
            }

            if (abs($yFromCenter) > $outputHeight / 2) {
                $recenter = true;
            }

            if ($recenter) {
                if ($xFromCenter < 0) {
                    $x = $x - $width / 2 * 0.2;
                } elseif ($xFromCenter > 0) {
                    $x = $x + $width / 2 * 0.2;
                }

                if ($yFromCenter < 0) {
                    $y = $y - $height / 2 * 0.2;
                } elseif ($xFromCenter > 0) {
                    $y = $y + $height / 2 * 0.2;
                }

                return $this->crop($source, $outputWidth, $outputHeight, $x, $y, $offsetLeft, $offsetTop, true);
            }
        }

        $command = 'convert ' . $source . ' -set option:distort:viewport ' . $outputWidth . 'x' . $outputHeight . ' ' .
        '-distort SRT "' . $outputX . ',' . $outputY . ' %[fx:' . $ratio . '] 0 ' . ($outputWidth / 2) . ',' . ($outputHeight / 2) . '" ' . $destination;

        exec($command);

        return $destination;
    }
}


