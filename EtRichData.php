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

//    function _InitializeManagedVars() { // template for traits to automatically get called upon construct
//        /*
//        I _think_ it makes sense to pull NodeToAsrEtVars.  I just dont think it makes sense, any longer for EtVars
//            to know about nodes.
//
//        You put a lot of thought into how it should go in ElegantEvents/wd  But it is mostly abstract at the moment
//
//        Still thinking this could be a separate trait
//
//        If might make a lot of sense to set the values of our protected vars to the ObjEtVar representing that var.
//        */
//        $this->_AsrObjEtVars = array(); // maybe
//        $this->_asrStandardizedObjVars = [];
////        $this->_AsrObjEtVars = ClsEtVar::NodeToAsrEtVars($this); // <-- should really not be in EtVar, I think
//        #static function NodeToAsrEtVars($ObjNode) {
//        // Motivation: called by ObjNode constructor to get an array of EtVars corresponding to its own vars
//        ClsEtVar::EnsureStaticallyInited();
//
//        $AsrEtVars = array();
//
//        $reflect = new \ReflectionObject($this);
//        $asrMetaVals = [];// well, technically, all non-managed vars
//        foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
//            $asrMetaVals[$prop->getName()] = $prop->getValue($this);
//        }
////        print "<br>".__FILE__.__LINE__."<pre>";
////        print_r($asrMetaVals);
////        exit;
//        foreach ($reflect->getProperties(ReflectionProperty::IS_PROTECTED) as $prop) {  // Get all protected vars (http://www.php.net/manual/en/reflectionclass.getproperties.php#93984)
//            $ModifiedVarName = $prop->getName();
//
//            $EtClassName = ClsEtVar::getTypeHardFromModifiedVarName($this,$ModifiedVarName,$asrMetaVals); //pass in all other var names and their values so less likely have circular loop - makes sense, too.
//
//            $ObjEtVar = new $EtClassName($this,$ModifiedVarName);
//
//            //set initial value
//            if (isset($this->$ModifiedVarName)) {
//                $defaultValue = $this->$ModifiedVarName;
//                $ObjEtVar->setViaDefault($defaultValue);
//                #print "<br>".__FILE__.__LINE__."defaultValue=>$defaultValue: ".$ObjEtVar->Get();;
//
//            }
//
//
//            $AsrEtVars[$ModifiedVarName] = $ObjEtVar;
//            #unset($this->$ModifiedVarName);//<-- check this out - we kill it so as to always catch 'this' trying to read/write (which would otherwise bypass the managed vars)
//            //EtError::AssertTrue(!isset($this->$ModifiedVarName) , 'error', __FILE__, __LINE__, "I'm initializing managed vars, and I couldn't unset '$ModifiedVarName'");
//        }
//        $this->_AsrObjEtVars= $AsrEtVars;
//        #}
//
//
//        foreach ($this->_AsrObjEtVars as $var=>$asr) {
//            //obe now that we unset the var $this->$var = null;// this could be refactored to point to the obj var
//            $standardizedVarName = $this->_AsrObjEtVars[$var]->getAttributeValue('standardizedVarName');
//            EtError::AssertTrue(isset($standardizedVarName) , 'error', __FILE__, __LINE__, "standardizedVarName isn't set");
//            EtError::AssertTrue(strlen($standardizedVarName)>0 , 'error', __FILE__, __LINE__, "standardizedVarName isn't set");
//            $this->_asrStandardizedObjVars[$standardizedVarName] = &$this->_AsrObjEtVars[$var];
//
//            $this->_asrAliasedObjVars[$standardizedVarName] = &$this->_AsrObjEtVars[$var];
//            $this->_asrAliasedObjVars[$var] = &$this->_AsrObjEtVars[$var];
//        }
//        EtError::AssertTrue(isset($this->_AsrObjEtVars) , 'error', __FILE__, __LINE__, "this->_AsrObjEtVar isn't set");
//        EtError::AssertTrue(isset($this->_asrStandardizedObjVars) , 'error', __FILE__, __LINE__, "this->_AsrObjEtVar isn't set");
//    }
}

trait RichData_base_compiler {
    private $_asrRichDataMeta = [
        '_traits' => [
            '_longTraitNames' => [],
            '_shortTraitNames' => [],
        ], #just the RichData traits
        #'__richDataTraits_short_' => [], #without the namespace.  KnownLimitation: could be collisions
        #'__construct_'=>[],
        #'__compile_'=>[],
        # etc.
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
}




trait RichData_get {
    function __construct_RichData_get() {
        #print "Hello from ".get_called_class()."::".__METHOD__;
    }

    function __compile_RichData_get() {
        // Get protected properties X
        foreach ($this->_asrRichDataMeta['_protectedVarNames'] as $protectedVarName) {
//            // Handle willGets
//            if (!isset($this->_asrRichDataMeta['__get'][$protectedVarName]['_onGet'])) {
//                $this->_asrRichDataMeta['__get'][$protectedVarName]['_onGet'] = [];
//            }
//
//            $onGet = null;
//            if (method_exists(get_called_class(), "onGet{$protectedVarName}")) {
//                $onGet = [$this, "onGet{$protectedVarName}"];
//            } elseif (method_exists(get_called_class(), "onGet_{$protectedVarName}")) {
//                $onGet = [$this, "onGet_{$protectedVarName}"];
//            } elseif (method_exists(get_called_class(), "_onGet_{$protectedVarName}")) {
//                $onGet = [$this, "_onGet_{$protectedVarName}"];
//            }
//            // ShouldDo: Ensure mutually exclusive
//            $this->_asrRichDataMeta['__get'][$protectedVarName]['_onGet'][] = $onGet;
//
//            // Future: Externals might need to register themselves

            global $logger;
            // Handle getBy
            if (!isset($this->_asrRichDataMeta['__get'][$protectedVarName]['_getBy'])) {
                $this->_asrRichDataMeta['__get'][$protectedVarName]['_getBy'] = [];
            }

            #$getBy = null;
            $trimmedVarName = trim($protectedVarName,'_');
            $trimmedVarName_allLower = strtolower ($trimmedVarName);


            // method exists
            $reflect = new \ReflectionObject($this);
            $arrReflectMethodObjects = $reflect->getMethods(); //http://www.php.net/manual/en/reflectionclass.getmethods.php

            $protectedVarName_allLower = strtolower($protectedVarName);
            $shortMethodNamesInTheClass_originalCase = [];
            $shortMethodNamesInTheClass_lowerCase = [];
            foreach ($arrReflectMethodObjects as $asrMethodObject) {
                $shortMethodNamesInTheClass_originalCase[] = $asrMethodObject->name;
                $shortMethodNamesInTheClass_lowerCase[] = strtolower($asrMethodObject->name);
            }
//            print "<br>Here are our options for protectedVarName($protectedVarName) ... <br><pre>";
//            print_r($shortMethodNamesInTheClass_lowerCase);
//            print "</pre><hr>";



            $arrMethodNamePermutations_allLower = [
                "get{$trimmedVarName_allLower}",
                "get_{$trimmedVarName_allLower}",
                "get__{$trimmedVarName_allLower}",
                "_get{$trimmedVarName_allLower}",
                "_get_{$trimmedVarName_allLower}",
                "_get__{$trimmedVarName_allLower}",
                "__get{$trimmedVarName_allLower}",
                "__get_{$trimmedVarName_allLower}",
                "__get__{$trimmedVarName_allLower}",
            ];
            $getBy = [];
            $slotMatches = [];
            foreach ($arrMethodNamePermutations_allLower as $methodName_allLower) {
                $slot = array_search($methodName_allLower, $shortMethodNamesInTheClass_lowerCase);
                if ($slot !== false) {
                    if (array_search($slot, $slotMatches) === false) {
                        $slotMatches[] = $slot;
                    } else {
                        // we already matches to this exact slot - so don't re-add it
                    }
                    #print "<br> Hit: Found $methodName_allLower matching against ".$shortMethodNamesInTheClass_originalCase[$slot];
                } else {
                    #print "<br> Miss:  $methodName_allLower didn't match any of the actual method names";

                }

            }
            if (count($slotMatches) == 0) {
                $this->_asrRichDataMeta['__get'][$protectedVarName]['_getBy'] = null;
            } elseif (count($slotMatches) == 1) {
                $getBy = $shortMethodNamesInTheClass_originalCase[$slotMatches[0]];
                $this->_asrRichDataMeta['__get'][$protectedVarName]['_getBy'] = $getBy;
            } else {
                $msg = "The following methods are ambiguous with getting protectedVarName($protectedVarName), so just pick one. ";
                $c = get_called_class();
                foreach ($slotMatches as $slot) {
                    $getBy_original = $shortMethodNamesInTheClass_originalCase[$slot];
                    $getBy_short = $shortMethodNamesInTheClass_originalCase[$slot];
                    $msg .= "<br> {$c}::($getBy_original)";
                }
                print "<br>$msg";
                print "<br>".__FILE__.' '.__LINE__;
                global $logger;
                $logger->error($msg,[__FILE__,__LINE__]);
//                print "<br><pre>";
//                print_r($slotMatches);
//                print_r($shortMethodNamesInTheClass_lowerCase);
//                print_r($shortMethodNamesInTheClass_originalCase);
//                print_r($this);
                exit(1);
            }

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

        if (!isset($this->_asrRichDataMeta['__get'][$StrVarName])) {
            $c = get_called_class();
            $msg = "'$StrVarName' is a not valid RichData var for class {$c}. ";
            print "<br>$msg";
            print "<br>" . __FILE__ . ' ' . __LINE__;
            global $logger;
            $logger->error($msg, [__FILE__, __LINE__]);
            exit(1);
        }
        switch ($this->_asrRichDataMeta['__get'][$StrVarName]['_getBy']) {
            case null:
                return $this->$StrVarName;
            default:
                $methodName = $this->_asrRichDataMeta['__get'][$StrVarName]['_getBy'];
                return $this->$methodName();
        }
    }


}

//trait RichData_set {
//    function __set($name, $value) {
//        //TODO implement this
//    }
//
//}
trait RichData {
    use RichData_base;
    use RichData_base_compiler;
    use RichData_get;
    //use RichData_set;
}

trait CrazyRichData {
    use RichData;
}

