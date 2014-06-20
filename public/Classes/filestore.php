<?php

class Filestore {

    public $is_csv = false;

    public $filename = '';

    public function __construct($filename)
    {
        $this->filename = $filename;
        $extension = substr($filename,-3);
        if($extension == 'csv'){
            $this->is_csv = true;
        }

    }

    private function read_lines()
    {
        $contents_array = [];
        if(filesize($this->filename) > 0){
            $handle = fopen($this->filename,'r');
            $contents = trim(fread($handle,filesize($this->filename)));
            $contents_array = explode("\n", $contents);
            fclose($handle);
        }
        return $contents_array;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private  function write_lines($array)
    {
        $handle = fopen($this->filename,'w');
        $string = implode("\n", $array);
        $contents = fwrite($handle,$string);
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private  function read_csv()
    {
        $address_book = [];
        $handle = fopen($this->filename, 'r');
        while(!feof($handle)){
            $row = fgetcsv($handle);
            if(is_array($row)){
                $address_book[] = $row;
            }
        }
        fclose($handle);
        return $address_book;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    private  function write_csv($array)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $fields){
            fputcsv($handle,$fields);
        }
        fclose($handle);
    }

    public  function __destruct(){
            echo  "Class dismissed";
    }

    // Create 2 new methods in Filestore: read() and write($array), and make them both public. read() should call $this->read_csv() if $this->is_csv is TRUE, and $this->read_lines() if it is not. write() should work the same way. Now when we can simply set a file, and call read() or write() and get back an array based on the filetype.

    public function read()
    {
        if ($this->is_csv) {
            return $this->read_csv();
        } else {
             return $this->read_lines();
        }
    }

    public function write($array)
    {
        if ($this->is_csv == false) {
            $this->write_lines($array);
        } else {
            $this->write_csv($array);
        }
    }
}