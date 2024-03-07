<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($page_title)) echo $page_title; ?>
    </title>
    <link href="./stylesheet/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .option:hover{
            background-color: #FC4F00;
            opacity: 0.8;
            font-weight: bold;
        }
        .borderEduOrange {
            border-color: #FC4F00;
        }
        .titleh1{
            font-family: "Lexend Tera";
        }
        .li{
            font-family: "Poppins";
        }
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-CbwchdGL8czezRGr33jLC3ohHetzGjnKOaT1qTf2LZkI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-O+YchJsrOBiQcwwzH2i9NC5gOpbTZwWGJB3j1kaCfkxgTkRVuXv4jJ1u4kJWNLz3" crossorigin="anonymous"></script>