<?php
/**
 * Original version:
 * written by Jarrod Oberto
 * taken from http://net.tutsplus.com/tutorials/php/image-resizing-made-easy-with-php/
 *
 * Example usage:
 * App::uses('ImageUtil', 'Lib');
 * $resizer = new ImageUtil('images/cars/large/input.jpg');
 * $resizer->resizeImage(150, 100, 0);
 * $resizer->saveImage('images/cars/large/output.jpg', 100);
 */

Class ImageUtil
{

    private $__width;
    private $__height;
    private $__imageInput;
    private $__imageOutput;

    public function __construct($fileName)
    {
        $this->__imageInput = $this->__openImage($fileName);
        $this->__width = imagesx($this->__imageInput);
        $this->__height = imagesy($this->__imageInput);
    }


/**
 *
 * @param type $file
 * @return type
 */
    private function __openImage($file)
    {
        if (!is_file($file)) {
            throw new Exception("File {$file} doesn't exists");
        }

        switch (pathinfo($file, PATHINFO_EXTENSION)) {
            case 'jpg':
            case 'jpeg': return imagecreatefromjpeg($file);
            case 'gif': return imagecreatefromgif($file);
            case 'png': return imagecreatefrompng($file);
        }

        throw new Exception("Invalid image extension for {$file}. Acceptable image types are jpg,jpeg,gif,png");
    }

    
/**
 *
 * @param type $width
 * @param type $height
 * @param type $option
 * @return type 
 */
    private function __getDimensions($width, $height, $option)
    {
        switch ($option) {
            case 'portrait': 
                return array($this->__getSizeByFixedHeight($height), $height);

            case 'landscape': 
                return array($width, $this->__getSizeByFixedWidth($width));

            case 'auto': 
                return $this->__getSizeByAuto($width, $height);

            case 'crop': 
                return $this->__getOptimalCrop($width, $height);

            case 'exact':
            default:
                return array($width, $height);
        }
    }

/**
 *
 * @param type $height
 * @return type
 */
    private function __getSizeByFixedHeight($height)
    {
        return ($this->__width / $this->__height) * $height;
    }

/**
 *
 * @param type $width
 * @return type
 */
    private function __getSizeByFixedWidth($width)
    {
        return ($this->__height / $this->__width) * $width;
    }

/**
 *
 * @param type $width
 * @param type $height
 * @return type
 */
    private function __getSizeByAuto($width, $height)
    {
        if ($this->__height < $this->__width) {
            return array($width, $this->__getSizeByFixedWidth($width));
        }

        if ($this->__height > $this->__width) {
            return array($this->__getSizeByFixedHeight($height), $height);
        }

        if ($height < $width) {
            return array($width, $this->__getSizeByFixedWidth($width));
        }

        if ($height > $width) {
            return array($this->__getSizeByFixedHeight($height), $height);
        }

        return array($width, $height);
    }

/**
 *
 * @param type $width
 * @param type $height
 * @return type 
 */
    private function __getOptimalCrop($width, $height)
    {
        $ratio = min($this->__height / $height, $this->__width / $width);
        return array(
            $this->__width / $ratio,
            $this->__height / $ratio
        );
    }

    
/**
 *
 * @param type $optimalWidth
 * @param type $optimalHeight
 * @param type $width
 * @param type $height
 */
    private function __crop($optimalWidth, $optimalHeight, $width, $height)
    {
        $x = ( $optimalWidth / 2) - ( $width / 2 );
        $y = ( $optimalHeight / 2) - ( $height / 2 );

        $crop = $this->__imageOutput;

        $this->__imageOutput = imagecreatetruecolor($width, $height);
        imagecopyresampled($this->__imageOutput, $crop, 0, 0, $x, $y, $width, $height, $width, $height);
    }
    

/**
 * Freely crop a given image using crop tool properties passed in from a form
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param array $cropProps
 * @param integer $targetW Target image's width
 * @param integer $targetH Target image's height
 */
    public function freeCrop($cropProps, $targetW=150, $targetH=150)
    {
        $this->__imageOutput = imagecreatetruecolor($targetW, $targetH);

        imagecopyresampled(
            $this->__imageOutput,
            $this->__imageInput,
            0,
            0,
            $cropProps['image_x'],
            $cropProps['image_y'],
            $targetW,
            $targetH,
            $cropProps['image_w'],
            $cropProps['image_h']
        );
    }
    
    
/**
 * Save the manipulated image being hold in the imageOutput property to disk using the given image quality
 *
 * @access public
 * @param string $savePath
 * @param integer $imageQuality
 */
    public function saveImage($savePath, $imageQuality="100")
    {
        switch (pathinfo($savePath, PATHINFO_EXTENSION)) {
            case 'jpg':
            case 'jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->__imageOutput, $savePath, $imageQuality);
                }
                break;

            case 'gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->__imageOutput, $savePath);
                }
                break;

            case 'png':
                if (imagetypes() & IMG_PNG) {
                    // Scale quality from 0-100 to 0-9
                    // Invert quality setting as 0 is best, not 9
                    $invertScaleQuality = 9 - round(($imageQuality / 100) * 9);
                    imagepng($this->__imageOutput, $savePath, $invertScaleQuality);
                }
                break;
        }

        imagedestroy($this->__imageOutput);
    }


/**
 * Resize image to given with and height using different methods provided through 'option'
 *
 * @access public
 * @param integer $newWidth
 * @param integer $newHeight
 * @param string $option
 */
    public function resizeImage($newWidth, $newHeight, $option='auto')
    {
        list($width, $height) = $this->__getDimensions($newWidth, $newHeight, $option);

        $this->__imageOutput = imagecreatetruecolor($width, $height);
        imagecopyresampled($this->__imageOutput, $this->__imageInput, 0, 0, 0, 0, $width, $height, $this->__width, $this->__height);

        if ($option == 'crop') {
            $this->__crop($width, $height, $newWidth, $newHeight);
        }
    }

}