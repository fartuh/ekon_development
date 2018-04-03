<?php

class auth
{

    public function pass($args)
    {
        if(isset($_SESSION['user'])){
            return true;
        }

        else{
            return true;
        }
    }

    public function failed()
    {
        echo "failed";
    }

}
