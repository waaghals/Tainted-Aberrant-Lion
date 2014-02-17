<?php

namespace PROJ\View;

class Header {

    public function getContent() {
        return '<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="/js/main.js"></script>
    </head>
    <body>';
    }

}

?>