<?php
session_start();
  session_unset();
  session_destroy();
?>
<script type="text/javascript">
                if (confirm("Do you want to log out??")) {
                    window.location="index.php";
                  }
                  else{
                    history.back();
                  }
        </script>