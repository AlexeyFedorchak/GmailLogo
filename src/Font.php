<?php

namespace GmailLogo;

/**
 * Class for keeping paths to all fonts
 *
 * Class Font
 * @package GmailLogo\Fonts
 */
class Font
{
    const ROBOTO_REGULAR = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/roboto/Roboto-Regular.ttf';

    const DAYS_28_LATER = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/28-days-later/28-Days-Later.ttf';

    const ANGILLA_TATTO = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/angilla-tattoo/AngillaTattoo_PERSONAL_USE_ONLY.ttf';

    const AUTHENTIC_SCRIPT = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/authentic-script/Authentic-Script-Rough.ttf';

    const GREAT_VIBES = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/great-vibes/GreatVibes-Regular.ttf';

    const PLAY_DAY = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/play-day/Play-Day.otf';

    const REMACHINE_SCRIPT = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/remachine-script/RemachineScript_Personal_Use.ttf';

    const VALIDITY_SCRIPT = 'https://gmail-logo-fonts.ams3.digitaloceanspaces.com/validity-script/ValidityScriptR_PERSONAL_USE.ttf';

    /**
     * get list of all fonts
     *
     * @return array
     */
    public function getFonts()
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }
}
