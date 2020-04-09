<?php

/**
 * Loads a class in the /classes folder and returns its object.
 *
 * This function acts as a singleton.  If the requested class does not
 * exist it is instantiated and set to a static variable.  If it has
 * previously been instantiated the variable is returned.
 *
 * @access	public
 * @param	string	the class name being requested
 * @param	bool	optional flag that lets classes get loaded but not instantiated
 * @return	object
 */
 
function load_class($class, $instantiate = TRUE) {
    static $objects = array();
    // Does the class exist?  If so, we're done...
    if (isset($objects[$class])) {
        return $objects[$class];
    }
    if (file_exists(F_PATH . 'lib/class.' . $class . '.php') && ($instantiate == TRUE)) {
        require(F_PATH . 'lib/class.' . $class . '.php');
        $objects[$class] = new $class();

        return $objects[$class];
    } else {
        echo 'Error : Class file class.' . $class . '.php does not exist';
        exit;
    }
}

/**
 * Sanitize Globals
 *
 * This function does the following:
 *
 * Unsets $_GET data (if query strings are not enabled)
 *
 * Unsets all globals if register_globals is enabled
 *
 * Standardizes newline characters to \n
 *
 * @access	private
 * @return	void
 */
function _sanitize_globals() {
    // Would kind of be "wrong" to unset any of these GLOBALS
    $protected = array('_SERVER', '_GET', '_POST', '_FILES', '_REQUEST', '_SESSION', '_ENV', 'GLOBALS', 'HTTP_RAW_POST_DATA');

    // Unset globals for security.
    // This is effectively the same as register_globals = off
    foreach (array($_GET, $_POST, $_COOKIE, $_SERVER, $_FILES, $_ENV, (isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : array()) as $global) {
        if (!is_array($global)) {
            if (!in_array($global, $protected)) {
                unset($GLOBALS[$global]);
            }
        } else {
            foreach ($global as $key => $val) {
                if (!in_array($key, $protected)) {
                    unset($GLOBALS[$key]);
                }

                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        if (!in_array($k, $protected)) {
                            unset($GLOBALS[$k]);
                        }
                    }
                }
            }
        }
    }


    // Clean $_POST Data
    if (is_array($_POST) AND count($_POST) > 0) {
        foreach ($_POST as $key => $val) {
            $_POST[_clean_input_keys($key)] = _clean_input_data($val);
        }
    }

    // Clean $_COOKIE Data
    if (is_array($_COOKIE) AND count($_COOKIE) > 0) {
        foreach ($_COOKIE as $key => $val) {
            $_COOKIE[_clean_input_keys($key)] = _clean_input_data($val);
        }
    }
}

// --------------------------------------------------------------------

/**
 * Clean Input Data
 *
 * This is a helper function. It escapes data and
 * standardizes newline characters to \n
 *
 * @access	private
 * @param	string
 * @return	string
 */
function _clean_input_data($str) {
    if (is_array($str)) {
        $new_array = array();
        foreach ($str as $key => $val) {
            $new_array[_clean_input_keys($key)] = _clean_input_data($val);
        }
        return $new_array;
    }

    // We strip slashes if magic quotes is on to keep things consistent
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }


    // Standardize newlines
    return preg_replace("/\015\012|\015|\012/", "\n", $str);
}

// --------------------------------------------------------------------

/**
 * Clean Keys
 *
 * This is a helper function. To prevent malicious users
 * from trying to exploit keys we make sure that keys are
 * only named with alpha-numeric text and a few other items.
 *
 * @access	private
 * @param	string
 * @return	string
 */
function _clean_input_keys($str) {
    if (!preg_match("/^[a-z0-9:_\/-]+$/i", $str)) {
        exit('Disallowed Key Characters.');
    }

    return $str;
}

/**
 * Function to redirect pages
 */
function redirect($url) {
    if (!headers_sent()) {    //If headers not sent yet... then do php redirect
        header('Location: ' . $url);
        exit;
    } else {                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}

/**
 * p()
 * Debugging made easy
 */
function pre($a) {
    echo '<pre>';
    print_r($a);
    echo '</pre>';
}

function disp_var(&$a) {
    if (isset($a)) {
        echo $a;
    }
}

function date_format_list($date_var) {
    $date = date_create($date_var);
    return date_format($date, 'm/d/Y');
}

function date_dyn_format_list($date_var, $format) {
    $date = date_create($date_var);
    return date_format($date, $format);
}

function currenturl() {
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https')
                    === FALSE ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $params = $_SERVER['QUERY_STRING'];

    $currentUrl = $protocol . '://' . $host . $script . '?' . $params;

    return $currentUrl;
}

function generate_random_letters($length) {
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= chr(rand(ord('a'), ord('z')));
    }
    return $random;
}

function getSubString($str, $start, $end,$url,$param,$id) {
    $desc = strip_tags($str);
    $descLen = strlen($desc);
    if ($descLen > $end) {
        $descri = substr($desc, $start, $end) . ' <a href="'.$url.'?'.$param.'=' . $id . '">more&raquo;</a>';
        
    } else {
        $descri = $desc;
    }
    return $descri;
}
function getSubStringNoMore($str, $start, $end,$needMore,$url,$param,$id) {
    $desc = strip_tags($str);
    $descLen = strlen($desc);
    if ($descLen > $end) {
        $descri = substr($desc, $start, $end);
        if($needMore=='y'){
            $descri .=' <a href="'.$url.'?'.$param.'=' . $id . '">more&raquo;</a>';
        }
    } else {
        $descri = $desc;
    }
    return $descri;
}

function getAllUrl() {
    $request_url =H_PATH;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);	// The url to get links from
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	// We want to get the respone
    $result = curl_exec($ch);

    $regex='|<a.*?href="(.*?)"|';
    preg_match_all($regex,$result,$parts);
    $links=$parts[1];
    foreach($links as $link) {
        if($link=='#') {
            continue;
        }
        echo $request_url.$link."<br>";
    }
    curl_close($ch);
}

function updateXML($file,$loc,$changeFreg,$priority) {
    $url = array(
            'loc' => $loc,
            'changefreq' => $changeFreg,
            'priority' => $priority,
    );

    $doc = new DOMDocument();
    $doc->load( $file );

    $doc->formatOutput = true;
    $r = $doc->getElementsByTagName("urlset")->item(0);

    $b = $doc->createElement("url");

    $loc = $doc->createElement("loc");
    $loc->appendChild(
            $doc->createTextNode( $url["loc"] )
    );
    $b->appendChild( $loc );

    $changefreq = $doc->createElement("changefreq");
    $changefreq->appendChild(
            $doc->createTextNode( $url["changefreq"] )
    );
    $b->appendChild( $changefreq );

    $priority = $doc->createElement("priority");
    $priority->appendChild(
            $doc->createTextNode( $url["priority"] )
    );

    $b->appendChild( $priority );
    $r->appendChild( $b );

    $doc->save($file);
}

?>