<?php

    class Main {

         /**
         * INSERT MODULE
         */
        public static function insertModule($module_name, $params=array()){

            global $urlParams;
            
            $modulePath = _ABSOLUTEPATH.'/modules/'.$module_name;         
            $moduleUrl  = _FULLPATH.'/modules/'.$module_name;
            
            $insert = @ include($modulePath.'/default.php');    
            
            if(!$insert){ echo '<div class="alert alert-warning">O m&oacute;dulo <b>'.$module_name.'</b> n&atilde;o foi encontrado.</div>'; }

        }



    }
