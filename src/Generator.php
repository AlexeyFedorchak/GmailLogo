<?php

namespace GmailLogo;

/**
 * custom utilities for generating gmail logo
 *
 * Class LogoGmail
 * @package App
 */
class Generator
{
    /**
     * handler of an image
     *
     * @var resource
     */
    protected $imageResource;

    /**
     * keeps path to file
     *
     * @var string
     */
    protected $font;

    /**
     * image coloured text
     *
     * @var resource
     */
    protected $colouredText;

    /**
     * unique logoName (md5(uniqid(email)))
     *
     * @var string
     */
    protected $logoName;

    /**
     * get dump
     *
     * @var string
     */
    protected $imageContent;

    /**
     * color depth
     *
     * @var array [low color value, high color value]
     */
    protected $colorDepth;

    /**
     * show if text color inverting is recommended
     *
     * @var bool
     */
    protected $needsInvertTextColor = false;

    /**
     * letter using for creating logo
     *
     * @var string
     */
    protected $letter;

    /**
     * width of the image
     *
     * @var int
     */
    protected $width;

    /**
     * height of the image
     *
     * @var
     */
    protected $height;

    /**
     * color stack '$red . | . $green . | . $blue'. Has to be put in DB ==> user(company)->logo_color.
     *
     * @var String
     */
    protected $colorStack = null;

    /**
     * init class | make initial settings
     *
     * LogoGmail constructor.
     * @param string $nameOrEmail
     * @param array $colorDepth
     */
    public function __construct(string $nameOrEmail, array $colorDepth, string $fontPath)
    {
        $this->logoName = md5(uniqid($nameOrEmail));

        $this->colorDepth = $colorDepth;
        $this->font = $fontPath;
        $this->letter = $nameOrEmail;
    }

    /**
     * set header, have to use for drawing an image
     */
    public function setHeader()
    {
        header("Content-Type: image/png");
        return $this;
    }

    /**
     * get image from string
     *
     * @param $width integer
     * @param $height integer
     * @return $this
     */
    public function setBackground(int $width, int $height)
    {
        $this->imageResource = imagecreate($width, $height);
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    /**
     * set colour for background
     *
     * @param $red integer (0...255)
     * @param $green integer (0...255)
     * @param $blue integer (0...255)
     * @return $this
     */
    public function setBackgroundColor($red, $green, $blue)
    {
        imagecolorallocate($this->imageResource, $red, $green, $blue);
        return $this;
    }

    /**
     * get background with random color
     *
     * @return $this
     */
    public function setRandomBackgroundColor()
    {
        $red = $this->getRandColor();
        $green = $this->getRandColor();
        $blue = $this->getRandColor();

        if (count(array_unique([$red, $green, $blue, $this->colorDepth[1]])) === 1) {
            $this->needsInvertTextColor = true;
        }

        $this->colorStack = implode('|', [$red, $green, $blue]);
        return $this->setBackgroundColor($red, $green, $blue);
    }

    /**
     * returns coloured text
     *
     * @param $red integer (0...255)
     * @param $green integer (0...255)
     * @param $blue integer (0...255)
     * @return $this
     */
    public function setTextColor(int $red, int $green, int $blue)
    {
        if ($this->needsInvertTextColor) {
            $red = $this->colorDepth[0];
            $green = $this->colorDepth[0];
            $blue = $this->colorDepth[0];
        }

        $this->colouredText = imagecolorallocate($this->imageResource, $red, $green, $blue);
        return $this;
    }

    /**
     * use text for image
     *
     * @param $size int
     * @param $angle int
     * @return $this
     */
    public function setTextSize(int $size, int $angle = 0)
    {
    	//centering text
        $bbox = imagettfbbox($size, 0, $this->font, $this->letter);
        $textHeight = abs($bbox[5]);
        $textWidth = $bbox[4] - $bbox[0];
        $y = $textHeight + 0.5 * ($this->height - $textHeight);
        $x = 0.5 * ($this->width - $textWidth) - $bbox[0];

        //put text into image
        imagettftext(
            $this->imageResource,
            $size,
            $angle,
            $x,
            $y,
            $this->colouredText,
            $this->font,
            $this->letter);

        return $this;
    }

    /**
     * create an image, header should be set before printing the image
     *
     * @return $this
     */
    public function createPNG()
    {
        $this->logoName .= '.png';

        $this->initBuffer();
        imagepng($this->imageResource);
        $this->getBufferAndClean();

        return $this;
    }

    /**
     * create an image, header should be set before printing the image
     *
     * @return $this
     */
    public function createJPEG()
    {
        $this->logoName .= '.jpeg';

        $this->initBuffer();
        imagejpeg($this->imageResource);
        $this->getBufferAndClean();

        return $this;
    }

    /**
     * helper for checking output PNG
     *
     * @return $this
     */
    public function showPNG()
    {
        imagepng($this->imageResource);
        return $this;
    }

    /**
     * helper for checking output JPEG
     *
     * @return $this
     */
    public function showJPEG()
    {
        imagejpeg($this->imageResource);
        return $this;
    }

    /**
     * get buffer and save to file
     *
     * @param string $path
     * @return $this
     */
    public function save(string $path = '')
    {
        $this->imagePath = $path . $this->logoName;

        $f = fopen($this->imagePath, 'w');
        fwrite($f, $this->imageContent);
        fclose($f);

        return $this;
    }

    /**
     * destroy image to prevent dump overloading
     *
     * @return $this
     */
    public function destroy()
    {
        imagedestroy($this->imageResource);
        return $this;
    }

    /**
     * start saving buffer
     */
    private function initBuffer()
    {
        ob_start();
    }

    /**
     * get content from buffer and clean buffer
     */
    private function getBufferAndClean()
    {
        $this->imageContent = ob_get_contents();
        ob_end_clean();
    }

    /**
     * rand color depth
     *
     * @return int
     */
    private function getRandColor()
    {
        return rand(0,1) === 0 ? $this->colorDepth[0] : $this->colorDepth[1];
    }
}