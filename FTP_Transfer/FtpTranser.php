<?php

require_once "SuperClass.php";

class FileTransferProtocol extends SuperClass {
    /*
    * Handles connection to FTP server
    * Method for upload and remote file browsing
    */
    private $connection;
    private string $upload_dir;
    private string $download_dir;

    public function __construct($ftp_server, $ftp_username, $ftp_password) {
        parent::__construct($ftp_server, $ftp_username, $ftp_password);     // Inherit class attributes
        $this->upload_dir = 'Upload';                                       // Remote upload directory
        $this->download_dir = 'Download';                                   // Remote download directory

        // Establish connection, and sign in to the FTP server
        $this->connection = ftp_connect($ftp_server) or die(error_log("Could not connect to $ftp_server"));
        ftp_login($this->connection, $ftp_username, $ftp_password) or die(error_log("Could not log into $ftp_server"));
        ftp_set_option($this->connection, FTP_USEPASVADDRESS, false);
        if (!ftp_pasv($this->connection, true)) {
            error_log("Can't change to pasv");
        }
        ftp_pasv($this->connection, true);

        // Create a folder called Orders on FTP if non-existent
        if (ftp_nlist($this->connection, $this->upload_dir) == false) {
            ftp_mkdir($this->connection, $this->upload_dir);
        }
    }

    public function upload($file) {
        // Upload file to FTP
        if (ftp_put($this->connection, $this->upload_dir . "/$file", $file, FTP_ASCII)) {
            error_log("Successfully uploaded $file");
        } else {
            error_log("Error uploading $file");
        }
    }

    private function getData(): string {
        $content = ftp_nlist($this->connection, $this->download_dir);

        $content_count = count($content);

        if ($content_count > 0) {
            for ($i = 0; $i < $content_count; $i++) {

                $file_name = $content[$i];

                if (!$this->endsWith($file_name, '.xml')) {
                    continue;
                }

                $handler = fopen('php://temp', 'r+');

                ftp_fget($this->connection, $handler, $file_name, FTP_BINARY, 0);

                $fstats = fstat($handler);
                fseek($handler, 0);

                $contents = fread($handler, $fstats['size']);

                fclose($handler);

                $new = simplexml_load_string($contents);
                $n_json = json_encode($new);
                $n_arr = json_decode($n_json, true);
                foreach ($n_arr as $arr) {
                    if (isset($arr['array_key'])) {
                        $ftp_data = (string)$arr['array_key']['index'];
                    }
                }
            }
        }
        return $ftp_data;
    }
}

