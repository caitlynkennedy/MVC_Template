<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand logo-font pt-3" href="/"><?= APP_NAME ?></a>

    <?php
    //if user is logged in(session is NOT empty)
    if (!empty($_SESSION['user_logged_in'])) {?>
    
    
        <form class="form-inline" id="search_form">
            <input type="search" autocomplete="off" name="search" id="search" class="form-control" placeholder="Search...">
            <div id="search_results">

            </div>
        </form>


        <!--navbar-toggler = mobile collapsed button-->
        <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNavBar">
            <i class="fas fa-hamburger"></i>
        </button>


        <!--navbar-collapse=mobile collapse-->
        <div class="navbar-collapse" id="mainNavBar">
            <ul class="navbar-nav ml-auto">
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="account-dropdown" data-toggle="dropdown">Welcome <?php echo $current_user['firstname']  ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/users/">My Profile</a>
                        <a class="dropdown-item" href="/users/logout.php">Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    <?php } ?>
</nav>