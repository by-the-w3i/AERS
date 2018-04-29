<?php
$command = escapeshellcmd('python3 /user/jiangw14/classweb/cse482-AERS/pyscript/randomUser.py');
$output = shell_exec($command);
echo $output;
?>