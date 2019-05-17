
<?php

    echo password_hash("admin", PASSWORD_DEFAULT) . "<br>";
    echo password_hash("123456", PASSWORD_DEFAULT) . "<br>";
    echo password_hash("123456", PASSWORD_DEFAULT);
?>