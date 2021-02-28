<?php

    # 
    # @file		error.php
    # @brief	Gestion des codes erreurs HTTP
    # @date		28 Fev 2021
    # @author 	Tristan Tedeschi
    # @lang		PHP
    # @version	1.0
    #  
    # @parent 	
    # 
    # @fctn		
    # 
    # @param	help                FOR afficher l'aide
    #           code                FOR code http
    #
    # @return	string              FOR retour de l'erreur
    #           http_error_code     FOR code erreur interprêté par le navigateur
    #
    # @execute	localhost
    # 
    # @example	error.php?code=404
    #           error.php?help
    # 

    # FILE INFORMATIONS
    $file = $_SERVER["SCRIPT_NAME"];
    $version = "1.0";
    $author = "Tristan Tedeschi (t.tedeschi@axione.fr)";
    $created_on = "28 Fev 2021";
    $update_on = "28 Fev 2021";

    # VARIABLES

    # Tableau des codes HTTP
    $http_status_code = array
    (
        # Succès
        200 => "OK", 
        201 => "Created", 
        202 => "Accepted", 
        203 => "Non-Authoritative Information", 
        204 => "No Content", 
        205 => "Reset Content", 
        206 => "Partial Content", 
        207 => "Multi-Status", 
        208 => "Already Reported",
        210 => "Content Different",
        226 => "IM Used",

        # Redirection
        300 => "Multiple Choices", 
        301 => "Moved Permanently", 
        302 => "Found", 
        303 => "See Other", 
        304 => "Not Modified", 
        305 => "Use Proxy", 
        306 => "Switch Proxy", 
        307 => "Temporary Redirect", 
        308 => "Permanent Redirect", 
        310 => "Too many Redirects",

        # Erreur du client
        400 => "Bad Request",
        401 => "Unauthorized", 
        402 => "Payment Required", 
        403 => "Forbidden", 
        404 => "Not Found", 
        405 => "Method Not Allowed", 
        406 => "Not Acceptable", 
        407 => "Proxy Authentication Required", 
        408 => "Request Timeout", 
        409 => "Conflict", 
        410 => "Gone", 
        411 => "Length Required", 
        412 => "Precondition Failed", 
        413 => "Request Entity Too Large", 
        414 => "Request-URI Too Long", 
        415 => "Unsupported Media Type", 
        416 => "Requested Range Not Satisfiable", 
        417 => "Expectation Failed", 
        418 => "I'm a teapot", 
        419 => "Authentication Timeout", 
        420 => "Enhance Your Calm", 
        422 => "Unprocessable Entity", 
        423 => "Locked", 
        424 => "Failed Dependency", 
        424 => "Method Failure", 
        425 => "Unordered Collection", 
        426 => "Upgrade Required", 
        428 => "Precondition Required",
        429 => "Too Many Requests", 
        431 => "Request Header Fields Too Large", 
        444 => "No Response", 
        449 => "Retry With", 
        450 => "Blocked by Windows Parental Controls", 
        451 => "Unavailable For Legal Reasons", 
        494 => "Request Header Too Large", 
        495 => "Cert Error", 
        496 => "No Cert", 
        497 => "HTTP to HTTPS", 
        499 => "Client Closed Request", 
        
        # Erreur du serveur
        500 => "Internal Server Error", 
        501 => "Not Implemented", 
        502 => "Bad Gateway", 
        503 => "Service Unavailable", 
        504 => "Gateway Timeout", 
        505 => "HTTP Version Not Supported", 
        506 => "Variant Also Negotiates", 
        507 => "Insufficient Storage", 
        508 => "Loop Detected", 
        509 => "Bandwidth Limit Exceeded", 
        510 => "Not Extended", 
        511 => "Network Authentication Required", 
        598 => "Network read timeout error", 
        599 => "Network connect timeout error"
    );

    # protocol prend la valeur du protocole http
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    #################

    # Récupération du paramètres code
    if (isset($_GET["code"]) && !empty($_GET["code"]) && preg_match("/^[0-9]{3}$/", $_GET["code"]) && !isset($_GET["help"]))
    {
        # code prend la valeur du paramètre
        $code = $_GET["code"];

        # Si code existe
        if (!empty($http_status_code[$code]))
        {
            # Retour code navigateur
            http_response_code($code);

            # Retour d'un texte
            echo $code." ".$http_status_code[$code];
        }

        # Sinon
        else
        {
            # Exception
            $code = 404;
            header("HTTP/1.0 ".$code." ".$http_status_code[$code]);
            echo $code." ".$http_status_code[$code]."<br>";
            echo "Note: Code HTTP inconnu.<br>";
            echo "Voir l'aide: <a href=\"".$protocol.$_SERVER["HTTP_HOST"].$file."?help\">".$protocol.$_SERVER["HTTP_HOST"].$file."?help</a>";
        }
    }

    # Afficher une aide
    else if (isset($_GET["help"]) && empty($_GET["help"]) && !isset($_GET["code"]))
    {
        echo "<b>NOM</b><br>";
        echo "error.php - Gestion des codes erreurs HTTP.<br>";
        echo "<br>";

        echo "<b>SYNOPTIQUE</b><br>";
        echo $file."?code=<i>OPTIONS</i><br>";
        echo "<br>";

        echo "<b>OPTIONS</b><br>";
        foreach ($http_status_code as $key => $value)
        {
            echo $key." => ".$value."<br>";
        }
        echo "<br>";

        echo "<b>EXEMPLE</b><br>";
        echo "<a href=\"".$protocol.$_SERVER["HTTP_HOST"].$file."?code=200\">".$protocol.$_SERVER["HTTP_HOST"].$file."?code=200</a><br>";
        echo "<br>";

        echo "<b>REFERENCES</b><br>";
        echo "Créé le $created_on, par $author.<br>
        Sous la version $version, du $update_on.";
    }

    # Sinon
    else
    {
        # Exception
        $code = 400;
        header("HTTP/1.0 ".$code." ".$http_status_code[$code]);
        echo $code." ".$http_status_code[$code]."<br>";
        echo "Note: Paramètre 'code' manquant, vide ou comportant une syntaxe autre que numérique.<br>";
        echo "Voir l'aide: <a href=\"".$protocol.$_SERVER["HTTP_HOST"].$file."?help\">".$protocol.$_SERVER["HTTP_HOST"].$file."?help</a>";
    }
?>