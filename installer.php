<?php
 phpshadow_info(); die;
/*

***************************************************************************
**                                                                       **
**                     INSTALLER FILE FOR PHPSHADOW                      **
**                                                                       **
**          Copy this file to your web server or solution stack          **
**             and browse to its URL using your web browser              **
**                                                                       **
***************************************************************************

*/
$ini = php_ini_loaded_file();
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if ($_REQUEST['action'] == 'downloadini') {
        $content = file_get_contents($ini);
        header('Content-Length: '.strlen($content));
        header('Content-Disposition: attachment; filename="php.ini"');
        header('Content-Type: text/plain');
        echo $content;
        exit;
    }
    if ($_REQUEST['action'] == 'downloadtestfile') {
        $content = '<?php'."\n".'phpshadow_info();'."\n".'?>';
        header('Content-Length: '.strlen($content));
        header('Content-Disposition: attachment; filename="test.php"');
        header('Content-Type: text/plain');
        echo $content;
        exit;
    }
}
?><!DOCTYPE html>
<head>
<script type="text/javascript">
function downloadini() {
    var f = document.createElement('form');
    f.method = 'post';
    f.action = window.location.href;
    var i = document.createElement('input');
    i.type = 'hidden';
    i.name = 'action';
    i.value = 'downloadini';
    f.appendChild(i);
    f.submit();
}
function downloadtestfile() {
    var f = document.createElement('form');
    f.method = 'post';
    f.action = window.location.href;
    var i = document.createElement('input');
    i.type = 'hidden';
    i.name = 'action';
    i.value = 'downloadtestfile';
    f.appendChild(i);
    f.submit();
}
</script>
<meta charset="UTF-8">
<style type="text/css">
body {
border: 0px;
margin: 0px;
padding: 0px;
min-width: 980px;
background: white;
}
div {
vertical-align: top;
}
div#header {
margin: 0px;
padding: 0px;
border: 0px;
border-top-left-radius: inherit;
border-top-right-radius: inherit;
border-bottom-left-radius: 0px;
border-bottom-right-radius: 0px;
width: 100%;
height: 50px;
background-color: rgb(84,142,194);
background: linear-gradient(to bottom, rgb(98,168,219), rgb(70,121,178));
}
div#content {
position: relative;
border: 0px;
margin: 0px;
margin-left: auto;
margin-right: auto;
padding: 30px;
padding-top: 40px;
padding-bottom: 40px;
width: 550px;
height: auto;
}
div#content h1 {
border: 0px;
margin: 0px;
margin-top: 5px;
margin-bottom: 20px;
padding: 0px;
font-family: Helvetica, Arial, 'Microsoft Sans Serif', 'Lucida Sans Unicode', sans-serif;
font-weight: 200;
color: rgb(80,134,186);
font-size: 34px;
line-height: 44px;
}
div#content a, a:hover, a:active, a:visited {
text-decoration: inherit;
cursor: pointer;
color: rgb(80,134,186);
}
div#content ol {
border: 0px;
margin: 0px;
margin-bottom: 20px;
margin-left: 1.6em;
padding: 0px;
list-style-type: decimal;
}
div#content ol li {
border: 0px;
margin: 0px;
margin-bottom: 18px;
padding: 0px;
padding-left: 0em;
font-family: Helvetica, Arial, 'Microsoft Sans Serif', 'Lucida Sans Unicode', sans-serif;
font-weight: 200;
color: rgb(110,114,120);
font-size: 18px;
line-height: 28px;
text-indent: 0em;
}
div#content ol li.done {
color: rgba(110,114,120,0.5);
text-decoration: line-through;
}
div#content p {
border: 0px;
margin: 0px;
margin-bottom: 18px;
padding: 0px;
padding-left: 0em;
font-family: Helvetica, Arial, 'Microsoft Sans Serif', 'Lucida Sans Unicode', sans-serif;
font-weight: 200;
color: rgb(110,114,120);
font-size: 18px;
line-height: 28px;
text-indent: 0em;
}
div#content button {
display: inline-block;
margin: 0px;
padding-top: 4px;
padding-bottom: 4px;
padding-left: 10px;
padding-right: 10px;
background-color: rgb(84,142,194);
border-width: 0px;
border-radius: 5px;
font-family: Helvetica, Arial, 'Microsoft Sans Serif', 'Lucida Sans Unicode', sans-serif;
font-weight: 200;
color: rgb(255,255,255);
font-size: 14px;
line-height: 22px;
text-indent: 0em;
cursor: pointer;
}
div#content hr {
margin: 0px;
margin-top: 30px;
margin-bottom: 30px;
padding: 0px;
border-width: 1px 0px 0px 0px;
border-style: solid;
border-color: rgb(84,142,194);
width: 100%;
height: 0px;
}
</style>
</head>
<body>
<div id="header">&nbsp;</div>
<div id="content">
<?php
function get_phpinfo_array() {
    ob_start();
    phpinfo(1);
    $php_info = array('phpinfo' => array());
    if (preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            if (strlen($match[1])) {
                $php_info[$match[1]] = array();
            } elseif (isset($match[3])) {
                $keys1 = array_keys($php_info);
                $php_info[end($keys1)][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
            } else{
                $keys1 = array_keys($php_info);
                $php_info[end($keys1)][] = $match[2];
            }
        }
    }
    return $php_info;
}
if ($ini === false) {
    echo '<h1>Error</h1><p>Unable to determine location of php.ini file.</p>';
} else {
    $ini_data = file_get_contents($ini);
    if ($ini_data === false) {
        $ini_done = false;
    } else {
        $match = '/[\r\n]+[[:space:]]*extension[[:space:]]*\=[[:space:]]*phpshadow.so[[:space:]]*[\r\n]+/sm';
        $ini_done = (preg_match($match,$ini_data) == 1);
    }
    $ext_dir = ini_get('extension_dir');
    if ($ext_dir === false) {
        echo '<h1>Error</h1><p>Unable to determine extensions directory.</p>';
    } elseif (preg_match('/^[A-Z]\\:\\\\/',$ext_dir) == 1) {
        echo '<p>It looks like your server is Windows.  PHPshadow is only for Linux, FreeBSD and Mac OS X.</p>';
    } else {
        $ext_file_done = false;
        $ext_files = scandir($ext_dir);
        if (array_search('phpshadow.so',$ext_files) !== false) {
            if (is_file($ext_dir.'/phpshadow.so')) {
                $ext_file_done = true;
            }
        }
        echo '<h1>Installation Instructions</h1>';
        echo '<ol>';
        $class = ($ext_file_done) ? 'done' : '';
        echo '<li class="'.$class.'">If you have not already done so, download the server extension from <a href="http://phpshadow.com/download">http://phpshadow.com/download</a>';
        $phpinfo = get_phpinfo_array();
        if (isset($phpinfo['phpinfo']['PHP Extension'])) {
            echo '<br>(When you are asked to specify the PHP Extension version, make sure you choose <b>'.htmlspecialchars($phpinfo['phpinfo']['PHP Extension']).'</b>)';
        }
        echo '</li>';
        echo '<li class="'.$class.'">Extract the extension (it\'s called <i>phpshadow.so</i>) from the tar file and copy it to <b>'.htmlspecialchars($ext_dir).'</b></li>';
        $class = ($ini_done) ? 'done' : '';
        echo '<li class="'.$class.'">Open this configuration file: <b>'.htmlspecialchars($ini).'</b> <button type="button" onclick="downloadini();">Download Now</button></li>';
        echo '<li class="'.$class.'">In the configuration file add the following line at the end:<br><b>extension=phpshadow.so</b><br>and then save the file back to the same location on the server.</li>';
        if (!$ext_file_done || !$ini_done) {
            echo '<li>Restart the web server.</li>';
            echo '</ol>';
        }
        echo '<hr>';
        if ($ext_file_done && $ini_done) {
            echo '<p>Good news! It looks like PHPshadow is already installed on your system.</p>';
        }
        echo '<p>To test PHPshadow, download the test file and upload it to your server.</p>';
        echo '<p><button type="button" onclick="downloadtestfile();">Download now</button></p>';
        echo '<p>When you browse to its URL using a web browser you should see the version of PHPshadow that is installed on your server.</p>';
    }
}
?>
</div>
</body>
</html>