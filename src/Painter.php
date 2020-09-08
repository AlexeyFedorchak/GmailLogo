<?php

namespace GmailLogo;

/**
 * custom controller for getting different gmail custom images
 * this controller contain all the custom builders of some custom settings for some images.
 * it is necessary to avoid writing the same code again | storage of LogoGmail custom settings builders
 *
 * extend this class and add more methods for your custom images.. :D
 *
 * Class LogoTools
 * @package App\Logo
 */
class Painter
{
    /**
     * generate typical gmail logo..
     */
    public function typical()
    {
        $temporaryLogo = new Generator('John Doe', [75, 175], Font::ROBOTO_REGULAR);
        $temporaryLogo->setHeader()
            ->setBackground(300,300)
            ->setTextColor(255,255,255)
            ->setTextSize(110)
            ->createPNG()
            ->showPNG()
            ->destroy();
    }
}