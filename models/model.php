<?php

namespace Models;

class Model
{

        protected
                $table = null,
                $db;

        function __construct($db){
                $this->db = $db;
        }

        public function getAll($columns){
                $column_tos = implode("`,`", $columns);
                $result = @mysqli_query($this->db->link, "SELECT `$column_tos` FROM `" . $this->table . "`");
                $arr = [];
                $i = 0;

                while($row = @mysqli_fetch_assoc($result))
                {
                        foreach($columns as $value){
                                $arr[$i][$value] = $row[$value];  
                        }

                        $i++;
                }
                return $arr;
        }

        public function getValue($column, $where){
                $q = @mysqli_query($this->db->link, "SELECT `$column` FROM `" . $this->table . "` WHERE $where");
                $qu = @mysqli_fetch_assoc($q);
                return $qu[$column];
        }

        public function getValues($where){
                $q = @mysqli_query($this->db->link, "SELECT * FROM `" . $this->table . "` WHERE $where");
                $qu = @mysqli_fetch_assoc($q);
                return $qu;
        }
}
