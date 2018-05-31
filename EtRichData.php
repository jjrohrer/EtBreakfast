<?php

namespace EtLib18;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

CONST BeInMenu = 1;
CONST BeAtomic = 2;

$gIsDevelopment = TRUE;

trait RichData_base {
    /* This is always meant to work with RichData_base_compiler
    */


    //????
    static $__compileMethodsByPrefix_RichData_base = ['__compile_', '__construct_']; #traits can not have constants.  stooopid


    function __construct_RichData_base() {

        // Boostrap the compiler
        global $gIsDevelopment;


        if ($gIsDevelopment) {
            $this->__construct_RichData_base_compiler();
        }

        // Constructors for everyone (except me & the compiler)!


        $arMethodNames = $this->_getCompiledMethods_byPrefix('__construct_');

        foreach ($arMethodNames as $methodName) {
            if ($methodName != '__construct_RichData_base' && $methodName != '__construct_RichData_base_compiler') {
                $this->$methodName();
            }
        }

    }

    function __compile_RichData_base() {
        $this->__compileMethods_byPrefix('__construct_');


        // Build list of RichData variables & Store them
        $reflect = new \ReflectionObject($this);

        // Get all protected  all non-managed vars
        $asrMetaVals = [];
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $asrMetaVals[$prop->getName()] = $prop->getValue($this);
        }


        // Get all protected vars (http://www.php.net/manual/en/reflectionclass.getproperties.php#93984)
        $protectedVarNames = [];
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PROTECTED) as $prop) {
            $ModifiedVarName = $prop->getName();
            $protectedVarNames[] = $ModifiedVarName;
        }
        $this->_asrRichDataMeta['_protectedVarNames'] = $protectedVarNames;
    }
}

trait RichData_base_compiler {
    private $_asrRichDataMeta = [
        '_traits' => [
            '_longTraitNames' => [],
            '_shortTraitNames' => [],
        ],
    ];

    function __construct_RichData_base_compiler() {
        global $gIsDevelopment;
        if ($gIsDevelopment) {
            $this->___compileMethods_init();

            $this->__compileMethods_byPrefix('__compile_');

            // compile everyone else (like create, read, etc.)
            $arrMethodNames = $this->_getCompiledMethods_byPrefix('__compile_');

            foreach ($arrMethodNames as $methodName) {
                $this->$methodName();

            }

        }
    }

    private function ___compileMethods_init() {
        // Compile Everything
        $thisClassName = get_called_class();
        $arrUsedTraits = static::_util_class_uses_deep($thisClassName, FALSE); # class_uses($this); // too shallow

        foreach ($arrUsedTraits as $longTraitName) {
            // Track if a rich data trait, and only RichData
            $exploded_longTraitName = explode('\\', $longTraitName);
            $shortTraitName = end($exploded_longTraitName);

            #print substr($shortTraitName, 0, 8);
            if (substr($shortTraitName, 0, 8) == 'RichData') {
                if (!in_array($longTraitName, $this->_asrRichDataMeta['_traits']['_longTraitNames'])) {
                    $this->_asrRichDataMeta['_traits']['_longTraitNames'][] = $longTraitName;
                }

                #$s =  array_pop(explode('\\', $traitName));
                if (!in_array($shortTraitName, $this->_asrRichDataMeta['_traits']['_shortTraitNames'])) {
                    $this->_asrRichDataMeta['_traits']['_shortTraitNames'][] = $shortTraitName;
                }
            }
        }
    }

    protected
    function __compileMethods_byPrefix(string $prefix) {
        if (empty($prefix) || is_null($prefix)) {
            print "yikes";
            exit;
        }
        $arrShortNames = $this->_asrRichDataMeta['_traits']['_shortTraitNames'];

        $arrMethodNames = static::_static_harvest_PrefixTrait_method_patterns($prefix, $arrShortNames);
        $this->_asrRichDataMeta[$prefix] = isset($this->_asrRichDataMeta[$prefix]) ? $this->_asrRichDataMeta[$prefix] : [];

        $this->_asrRichDataMeta[$prefix] = array_unique(
            array_merge(
                $arrMethodNames,
                $this->_asrRichDataMeta[$prefix]
            )
        );

    }


    static function _util_class_uses_deep($class, $autoload = TRUE) { //http://php.net/manual/en/function.class-uses.php#110752
        $traits = [];
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));
        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }
        return array_unique($traits);
    }

    private
    static function _static_harvest_PrefixTrait_method_patterns(string $prefix, array $shortTraitNames): array {
        $a = [];
        foreach ($shortTraitNames as $shortTraitName) {
            $methodName = "{$prefix}{$shortTraitName}";

            if (method_exists(get_called_class(), $methodName)) {
                $a[] = $methodName;
            }
        }
        return $a;
    }


    protected
    function _getCompiledMethods_byPrefix(string $prefix) {
        return $this->_asrRichDataMeta[$prefix];
    }

    function _util_getMethodDerivites(string $prefix, string $protectedVarName): array {//            // Handle willGets
        #global $logger;




        $_MatchedReason = '';
        #$getBy = null;
        $trimmedVarName = trim($protectedVarName, '_');
        $trimmedVarName_allLower = strtolower($trimmedVarName);


        // method exists
        $reflect = new \ReflectionObject($this);
        $arrReflectMethodObjects = $reflect->getMethods(); //http://www.php.net/manual/en/reflectionclass.{$prefix}methods.php

        $shortMethodNamesInTheClass_originalCase = [];
        $shortMethodNamesInTheClass_lowerCase = [];
        foreach ($arrReflectMethodObjects as $asrMethodObject) {
            $shortMethodNamesInTheClass_originalCase[] = $asrMethodObject->name;
            $shortMethodNamesInTheClass_lowerCase[] = strtolower($asrMethodObject->name);
        }

        // Handle getBy

        // What constants does our class hame
        $arrReflectConstObjects = $reflect->getConstants(); //http://www.php.net/manual/en/reflectionclass.{$prefix}methods.php
        $asrClassConst = [];
        foreach ($arrReflectConstObjects as $constName=>$constValue) {
            $asrClassConst[$constName] = $constValue;//useless
        }
        foreach ($asrClassConst as $constName=>$constValue) {
            $matchOn = "{$protectedVarName}_{$prefix}By";//like firstName_getBy = 'blah' or firstName_setBy = 'blah';
            $beginsWithVarName =  (substr($constName, 0, strlen($matchOn)) == $matchOn) ? true : false;
            if ($beginsWithVarName) {
                #$this->_asrRichDataMeta['__fields'][$protectedVarName]['_src'][$constName] = $constValue;//$gcc::$constName;
                #$this->_asrRichDataMeta['__fields'][$protectedVarName]['_src']['//'.$constName] = "This is defined via a class CONST";
                $_MatchedReason = "Explicit method set via: CONST $constName = $constValue";
                $methodMatchViaConst = $constValue;
                $constNameMatch = $constName;
                if (!method_exists($this, $constValue)) {
                    $msg = "You've explicitly said to use CONST $constName = $constValue, but  '$constValue' isn't an existing method";
                    $c = get_called_class();
                    print "<br>{$c} $msg";
                    print "<br>" . __FILE__ . ' ' . __LINE__;
                    global $logger;
                    $logger->error($msg, [__FILE__, __LINE__]);
                    exit(1);
                }
            }
        }// OUTPUT: $methodMatchViaConst & $_MatchedReason might now exist


        $arrMethodNamePermutations_allLower = [
            "{$prefix}{$trimmedVarName_allLower}",
            "{$prefix}_{$trimmedVarName_allLower}",
            "{$prefix}__{$trimmedVarName_allLower}",
            "_{$prefix}{$trimmedVarName_allLower}",
            "_{$prefix}_{$trimmedVarName_allLower}",
            "_{$prefix}__{$trimmedVarName_allLower}",
            "__{$prefix}{$trimmedVarName_allLower}",
            "__{$prefix}_{$trimmedVarName_allLower}",
            "__{$prefix}__{$trimmedVarName_allLower}",
        ];
        $getBy = [];
        $slotMatches = [];
        foreach ($arrMethodNamePermutations_allLower as $methodName_allLower) {
            $slot = array_search($methodName_allLower, $shortMethodNamesInTheClass_lowerCase);
            if ($slot !== FALSE) {
                if (array_search($slot, $slotMatches) === FALSE) {
                    $slotMatches[] = $slot;
                } else {
                    // we already matches to this exact slot - so don't re-add it
                }
                #print "<br> Hit: Found $methodName_allLower matching against ".$shortMethodNamesInTheClass_originalCase[$slot];
            } else {
                #print "<br> Miss:  $methodName_allLower didn't match any of the actual method names";

            }

        }

        // OUTPUT:
        // $shortMethodNamesInTheClass_originalCase
        // $shortMethodNamesInTheClass_lowerCase
        // $slotMatches

        if (count($slotMatches) > 1) {
            $msg = "The following methods are ambiguous with getting protectedVarName($protectedVarName), so just pick one. ";
            $c = get_called_class();
            foreach ($slotMatches as $slot) {
                $getBy_original = $shortMethodNamesInTheClass_originalCase[$slot];
                $getBy_short = $shortMethodNamesInTheClass_originalCase[$slot];
                $msg .= "<br> {$c}::($getBy_original)";
            }
            if (isset($methodMatchViaConst)) {
                $msg .= "<br>Oh, and you're matching on the CONST $constNameMatch";
            }
                print "<br>$msg";
            print "<br>" . __FILE__ . ' ' . __LINE__;
            global $logger;
            $logger->error($msg, [__FILE__, __LINE__]);
            exit(1);
        }

        if (isset($methodMatchViaConst) ) {

            if (count($slotMatches) == 0) {
                $methodMatch = $methodMatchViaConst;

            } elseif (count($slotMatches) == 1) {
                $methodMatchViaInference = $shortMethodNamesInTheClass_originalCase[$slotMatches[0]];
                if ($methodMatchViaInference == $methodMatchViaConst) {
                    // they are the same, so cool.
                    $_MatchedReason .= " & it matches the infered methd";
                } else {
                    // they are different.  Complain loudly
                    print "<br> $methodMatchViaInference != $methodMatchViaConst for class(".get_called_class().")::$protectedVarName " . __FILE__ . ' ' . __LINE__;
                    exit(1);
                }

                $methodMatch = $methodMatchViaConst;
            } else {
                $msg = "<br>Oh, and you're matching on the CONST $constNameMatch, but also on inferred vars You  protectedVarName($protectedVarName), so just pick one. ";
                $c = get_called_class();
                foreach ($slotMatches as $slot) {
                    $getBy_original = $shortMethodNamesInTheClass_originalCase[$slot];
                    $getBy_short = $shortMethodNamesInTheClass_originalCase[$slot];
                    $msg .= "<br> {$c}::($getBy_original)";
                }
                print "<br>$msg";
                print "<br>" . __FILE__ . ' ' . __LINE__;
                global $logger;
                $logger->error($msg, [__FILE__, __LINE__]);
                exit(1);
            }
        } elseif (count($slotMatches) == 0 ) {
            $methodMatch = null;
            $_MatchedReason = 'DefaultingToRaw: No other overrides found.';
        } elseif (count($slotMatches) == 1) {
            $methodMatch = $shortMethodNamesInTheClass_originalCase[$slotMatches[0]];
            $_MatchedReason = 'FunctionImplicitlyAppliesHere';
        } else {
            print "<br>" . __FILE__ . ' ' . __LINE__;
            exit(1);
        }
        $output =
            ['methodMatch' => $methodMatch,
                'protectedVarName' => $protectedVarName,
                'prefix' => $prefix,
                'reason' => $_MatchedReason,
            ];
        return $output;
    }
}


trait RichData_get {
    function __construct_RichData_get() {
        #print "Hello from ".get_called_class()."::".__METHOD__;
    }

    function __compile_RichData_get() {
        foreach ($this->_asrRichDataMeta['_protectedVarNames'] as $protectedVarName) {
            $output = $this->_util_getMethodDerivites('get', $protectedVarName);
            if (is_null($output['methodMatch'])) {
                $methodName = 'getRaw';
            } else {
                $methodName = $output['methodMatch'];
            }
            $this->_asrRichDataMeta['__fields'][$protectedVarName]['_getBy'] = $methodName;
            $this->_asrRichDataMeta['__fields'][$protectedVarName]['//']['_getBy_reason'] = $output['reason'];
        }
    }
    // ============================= Get =========================================================================
    // get the vlaue of a protected var w/o normal filtering - use with caution
    // motivation: when writing ClsEtVar, it needed a way to get the original values
    function getRaw($StrVarName, $bDieOnNotThere = FALSE) {
        #EtError::AssertTrue(property_exists($this,$StrVarName), 'error', __FILE__, __LINE__, "$StrVarName isn't a real property of me " .get_class($this)." in ".get_called_class());
        return $this->$StrVarName;
    }


    function __get($StrVarName) {
//        // onget/willGet
//        switch ($this->_asrRichDataMeta['__get'][$StrVarName]['_onGet']) {
//            case null:
//                break;
//            default:
//                foreach ($this->_asrRichDataMeta['__get'][$StrVarName]['_onGet'] as $arr2WillGetNotifyee) {
//                    $firstTerm = $arr2WillGetNotifyee[0];
//                    $secondTerm= $arr2WillGetNotifyee[1];
//                    if (is_object($firstTerm)) {
//                        $firstTerm->$secondTerm();
//                    } elseif(is_string($firstTerm)) {
//                        $firstTerm::$secondTerm();
//                    } else {
//                        print "<br> Exiting at: ".gettype($firstTerm).' ' .__FILE__.__LINE__;
//                        exit;
//                    }
//                }
//        }

        if (!isset($this->_asrRichDataMeta['__fields'][$StrVarName]['_getBy'])) {
            $c = get_called_class();
            $msg = "'$StrVarName' is a not valid RichData var for class {$c}. ";
            print "<br>$msg";
            print "<br>" . __FILE__ . ' ' . __LINE__;
            global $logger;
            $logger->error($msg, [__FILE__, __LINE__]);
            print "<pre>";
            print_r($this);
            exit(1);
        }
        $methodName = $this->_asrRichDataMeta['__fields'][$StrVarName]['_getBy'];
        return $this->$methodName($StrVarName);
    }

}

trait RichData_set {
    function __compile_RichData_set() {


        foreach ($this->_asrRichDataMeta['_protectedVarNames'] as $protectedVarName) {

                $output = $this->_util_getMethodDerivites('set', $protectedVarName);
                if (is_null($output['methodMatch'])) {
                    $methodName = 'setRaw';
                } else {
                    $methodName = $output['methodMatch'];
                }
            if (substr($protectedVarName,0,1) != '_') { // <-- Ignore if 'readonly' a
                $this->_asrRichDataMeta['__fields'][$protectedVarName]['_setBy'] = $methodName;

            } else {
                $output['reason'] = "Nothing: Is ReadOnly because it starts with an underscore";
            }
            $this->_asrRichDataMeta['__fields'][$protectedVarName]['//']['_setBy_reason'] = $output['reason'];


        }
    }
    // ============================= Get =========================================================================
    function setRaw($StrVarName, $value) {
        $this->$StrVarName = $value;
    }


    function __set($StrVarName, $value) {
        if (!isset($this->_asrRichDataMeta['__fields'][$StrVarName]['_setBy'])) {
            $c = get_called_class();
            $msg = "'$StrVarName' is a not settable RichData var for class {$c}. ";
            print "<br>$msg";
            print "<br>" . __FILE__ . ' ' . __LINE__;
            global $logger;
            $logger->error($msg, [__FILE__, __LINE__]);
            print "<pre>";
            print_r($this);
            exit(1);
        }
        $methodName = $this->_asrRichDataMeta['__fields'][$StrVarName]['_setBy'];
        return $this->$methodName($StrVarName, $value);
    }



}

trait RichData {
    use RichData_base;
    use RichData_base_compiler;
    use RichData_get;
    use RichData_set;
}

trait CrazyRichData {
    use RichData;
}

