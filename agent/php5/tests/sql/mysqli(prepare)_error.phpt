--TEST--
hook mysqli::prepare error
--SKIPIF--
<?php
$plugin = <<<EOF
RASP.algorithmConfig = {
     sql_exception: {
        action: 'block'
    }
}
EOF;
$conf = <<<CONF
security.enforce_policy: false
CONF;
include(__DIR__.'/../skipif.inc');
if (!extension_loaded("mysqli")) die("Skipped: mysqli extension required.");
@$con = mysqli_connect('127.0.0.1', 'root');
if (mysqli_connect_errno()) die("Skipped: can not connect to MySQL " . mysqli_connect_error());
mysqli_close($con);
?>
--INI--
openrasp.root_dir=/tmp/openrasp
--FILE--
<?php
@$con = new mysqli('127.0.0.1', 'root');
$con->prepare("select GeometryCollection((select 1 from (select * from (select user())a)b))");
$con->close();
?>
--EXPECTREGEX--
<\/script><script>location.href="http[s]?:\/\/.*?request_id=[0-9a-f]{32}"<\/script>