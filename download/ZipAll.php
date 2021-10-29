<?php

class ZipAll extends ZipArchive 
{

    public function __construct($a=false, $b=false, $c=array()) { $this->create_func($a, $b, $c);  }
	
    public function create_func($input_folder=false, $output_zip_file=false, $ignore_list=array())
    {
        if($input_folder !== false && $output_zip_file !== false)
        {
            $res = $this->open($output_zip_file, ZipArchive::CREATE);
            if($res === TRUE) {
                $this->addDir($input_folder, basename($input_folder), $ignore_list);
                $this->close();
            }
            else {
                echo 'Could not create a zip archive. Contact Admin.';

            }
        }
    }
	
    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name, $ignore_list=array()) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name, $ignore_list);
    }

    // Add Files & Dirs to archive 
    private function addDirDo($location, $name, $ignore_list=array()) {
        $name .= '/';
        $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..' || $file == "package" || $file == "install.php" || $file == "install-last-package.zip" || in_array($file, $ignore_list)) continue;

            if ( filetype( $location . $file) == 'dir') {
                $this->addDir($location . $file, $name . $file, $ignore_list);
            }
            else {
                $this->addFile($location . $file, $name . $file);
            }
        }
    } 
}

?>

