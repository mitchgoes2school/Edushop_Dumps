<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Lexend Tera' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <style>
    .titleh1{
        font-family: "Lexend Tera";
    }
    li{
        font-family: "Poppins";
    }
  </style>
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-CbwchdGL8czezRGr33jLC3ohHetzGjnKOaT1qTf2LZkI=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-O+YchJsrOBiQcwwzH2i9NC5gOpbTZwWGJB3j1kaCfkxgTkRVuXv4jJ1u4kJWNLz3" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-1">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="img/logo.png" width="90px" height="35px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link mx-2 active" aria-current="page" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="#">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="#">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="title text-center">
        <h1 class="titleh1 py-4">EDUSHOP</h1>
  </div>
  <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
    <ul class="nav"> 
        <li class="nav-item">
        <a class="nav-link mx-5 active text-dark" aria-current="page" href="#">HOME</a>
        </li>
        <li class="nav-item">
        <a class="nav-link mx-5 text-dark" href="#">SELL</a>
        </li>
        <li class="nav-item">
        <a class="nav-link mx-5 text-dark" href="#">AUCTION</a>
        </li>
    </ul>
</div>
</body>
</html>