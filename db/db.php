<?php

namespace db;

class db
{
        public
                $host,
                $user,
                $pass,
                $name,
                $link;


        function __construct($config){
                $this->host      = $config['host'];
                $this->user      = $config['user'];
                $this->pass      = $config['pass'];
                $this->name      = $config['name'];

                $this->char      = $config['char'];
                $this->connect($this->host, $this->user, $this->pass, $this->name);
                mysqli_query($this->link, "SET NAMES $this->char");
        }

        public function connect($host="localhost", $user="root", $pass="", $name="db"){
                $link = mysqli_connect($this->host, $this->user, $this->pass, $this->name);
                $this->link = $link;
        }
        public function close($link){
                mysqli_close($this->link);
        }

}
