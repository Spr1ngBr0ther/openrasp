--TEST--
hook output detect (reflection xss)
--SKIPIF--
<?php
$plugin = <<<EOF
RASP.algorithmConfig = {
     xss_userinput: {
        action: 'block'
    }
}
EOF;
$conf = <<<CONF
block.redirect_url: "/block?request_id="
xss.filter_regex: "<![\\\\-\\\\[A-Za-z]|<([A-Za-z]{1,12})[\\\\/ >]"
xss.min_param_length: 15
xss.max_detection_num: 1

CONF;
include(__DIR__.'/../skipif.inc');
?>
--INI--
openrasp.root_dir=/tmp/openrasp
--CGI--
--GET--
a=<script>alert("xss")</script>&b=<script>alert("xss")</script>
--FILE--
<?php
echo '<pre>just kidding</pre>';
?>
--EXPECTHEADERS--
Location: /block?request_id=
--EXPECT--
