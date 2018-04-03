<?php

namespace Core;

class Factory
{

        public static function getController($name){
                if(class_exists($name)){
                        return new $name;
                }
        }

}
