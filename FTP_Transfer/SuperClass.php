<?php

abstract class SuperClass {
    /*
    * Provide the most used attributes to child classes
    */
    protected string $ftp_server;
    protected string $ftp_username;
    protected string $ftp_password;

    public function __construct(string $ftp_server, string $ftp_username, string $ftp_password) {
        $this->ftp_server = $ftp_server;
        $this->ftp_username = $ftp_username;
        $this->ftp_password = $ftp_password;
    }
}
