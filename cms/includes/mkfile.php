<?php
    function mkfile($dir,$file,$content)
    {
        if ($dir=="" || $dir==".")
            $path = $file;
        else
        {
            $path = "$dir/$file";
            if (!file_exists($dir))
            {
                mkdir($dir, 0755, true);
            }
        }
        if (file_exists($path)){
            copy("$path", "$path.old");
            chmod("$path.old", 0640);
        }
        $f = fopen($path, "w");
        fwrite($f,$content);
        fclose($f);
        chmod("$path", 0640);
    }

    function mkpublic($dir,$file)
    {
        if ($dir=="" || $dir==".")
            chmod($file, 0644);
        else
            chmod("$dir/$file", 0644);
    }
?>
