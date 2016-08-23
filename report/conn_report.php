<?php

mysql_connect("127.0.0.1", "root", "SENHA") or
    die("Não foi possível conectar: " . mysql_error());
mysql_select_db("asterisk");

?>