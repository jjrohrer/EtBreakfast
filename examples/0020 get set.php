<?php

ini_set("display_errors","2");ERROR_REPORTING(E_ALL);
require_once(__DIR__.'/../config.php');
use Carbon\Carbon;


class SeasonalWave  { # <-- Class Name is the Key
    use EtLib18\RichData;


    static $internalVersionAsInteger = 1;   // <-- INPUT (Future: Store this meta in db and prompt if needs to change if on dev)

    CONST RICH_DATA_CONFIG = EtLib18\BeInMenu | EtLib18\BeAtomic;

    protected $title;
    CONST       title_isA= 'str';
    CONST       title_validatesAgainst = ['EtLib18\EtStrings'=>'HumanTitle'];

    protected $preview_opens_at;
    CONST       preview_opens_at_isA = 'dateTime';

    protected $_preview_opens_fromNow; #read-only cuz of 'protected' with leading underscore ( '_' )
    CONST       _preview_opens_fromNow_isFed = 'preview_opens_at';

    protected $registration_opens_at;
    CONST       registration_opens_at_isA = 'dateTime';

    protected $_registration_opens_fromNow; #read-only cuz of 'protected' with leading underscore ( '_' )
    CONST       _registration_opens_fromNow_isFed = 'registration_opens_at';

    protected $_numViews;

    protected $firstName = 'JJ';
    protected $lastName = 'Rohrer';
    protected $fullName;
    function get_fullName() {
        return "{$this->firstName} {$this->lastName}";
    }


    function __construct() {
        $this->__construct_RichData_base();
        # parent::__construct();
    }

    static function _get_preview_opens_on_humanDiff($id) {
        Carbon::enableHumanDiffOption(Carbon::JUST_NOW
            |Carbon::ONE_DAY_WORDS
            |Carbon::TWO_DAY_WORDS
            |Carbon::NO_ZERO_DIFF);

    }

}


print "RichData demo";
$a = new SeasonalWave();
print $a->get_fullName();
//
//Next up:
// - Make the setters work
//- Make validation work
//
//- Make work with Vue