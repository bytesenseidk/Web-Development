<?php

class HelloWorld {
    public static function sayHello() {
        print_r("Hello Instagram!");
    }
}

if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {
    HelloWorld::sayHello();
}

