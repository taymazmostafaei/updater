<?php
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
class TMUP
{
    public  $current_version;
    public  $new_version;

    private function deleteFolder($path)
    {
        $system = new WP_Filesystem_Base ;
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file)
                $this->deleteFolder(realpath($path) . '/' . $file);

            return $system->rmdir($path);
        } else if (is_file($path) === true)
            return $system->delete($path);

        return false;
    }
    public function do_update($zip_url, $plugin_folder_path)
    {
        $system = new WP_Filesystem_Base ;
        $cv = $this->current_version;
        $nv = $this->new_version;
        if ($cv < $nv) {
            file_put_contents('roblox.zip', fopen($zip_url, 'r'));

            $zip = new ZipArchive();
            $res = $zip->open('roblox.zip');
            if ($res === TRUE) {
                $this->deleteFolder($plugin_folder_path);
                $system->mkdir($plugin_folder_path);
                $zip->extractTo($plugin_folder_path);
                $system->delete('roblox.zip');
                $zip->close();
            } else {
                wp_die('oh sorry we cant update it');
            }
        }
    }
}
