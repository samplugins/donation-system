<?php
/**
 * CSV Generation
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsCSV
{
    
    var $delimiter = ",";
    var $row_end = "\n";
    
    function clsCSV($delimiter,$row_end){
        $this->delimiter = $delimiter;
        $this->row_end = $row_end;
    }
    
    private function create_csv_file_header($data)
    {
        $row = "";
        if (count($data)>0){
            foreach ($data[0] as $key=>$val)
            {
                if ($row){
                    $row .= $this->delimiter . $key;
                }else{
                    $row .= $key;
                }
            }
            $row .= $this->row_end;
        }
        return $row;
    }
    
    
    private function create_csv_file_row($row)
    {
        $res = "";
        foreach ($row as $key=>$val)
        {
            if ($res){
                $res .= $this->delimiter .'"'. $val.'"';
            }else{
                $res .= '"'.$val.'"';
            }
        }
        $res .= $this->row_end;
    
        return $res;
    }
    
    private function Create($data)
    {
        $csv = $this->create_csv_file_header($data);
        foreach ($data as $key=>$val){
            $csv .= $this->create_csv_file_row($val);
        }
        return $csv;
    }
    
    function Export($data,$filename="csv_file.csv")
    {
        $csv = $this->Create($data);

        header("Content-type: application/eml");
        header("Content-Disposition: attachment; filename=".$filename."");
        
        echo $csv;
    }
}
?>