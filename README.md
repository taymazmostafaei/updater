# php wordpress plugin updater
 update your plugin with TMupdate 
```
<?php
//cheking for update

            get version from inistachi server
             $string = file_get_contents('http://localhost/version.json');
             $json_a = json_decode($string, true);
             $nversion = $json_a['version'] * 1;
             $var = get_plugin_data();
             $cversion = $var['Version'] * 1;

             if ($nversion > $cversion) {
                 require_once  'updater/tmupdate.php';
                 $updater = new TMUP();
                 $updater->new_version = $nversion ;
                 $updater->current_version = $cversion ;
                 $updater->do_update($zip_url, $plugin_folder_path) ;
             }
?>
```
