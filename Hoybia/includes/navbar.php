<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-1">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="img/logo.png" width="90px" height="35px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
      ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link mx-2 <?php if(isset($page_title) && $page_title=="Home") echo 'active'; ?>" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2 <?php if(isset($page_title) && $page_title=="Register") echo 'active'; ?>" href="register.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2 <?php if(isset($page_title) && $page_title=="Login") echo 'active'; ?>" href="login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>