<?php

namespace traits;

trait modules 
{
                
        public function view($path, $vars=[], $fmt="php"){
                foreach($vars as $var => &$value){
                                                $$var = $value;
                                                                
                }
                                require(ROOT . "/public/views/" . $path . ".$fmt");
                                        
        }


}
