<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/js/scripts.js"></script>


    <footer class="col-sm-12 mt-4" id="site-footer">
        <div class="container">
            <div class="row d-flex align-items-center my-2">
              
                <div class="col-md-12 text-center text-white">

                  
                <?php
               if (isset($_SESSION["user_logged_in"])) : //check if user is logged in
            ?>
                  <ul class="nav text-uppercase mx-auto justify-content-center">
                      <li class="nav-item"><a class="nav-link px-5" href="/index.php">Home</a></li>
                      <li class="nav-item"><a class="nav-link px-5" href="/users/">My Profile</a></li>
                      <li class="nav-item"><a class="nav-link px-5" href="/users/logout.php">Logout</a></li>
                  </ul>
                  <?php
                   else : //if user is not logged in
                  ?>
                  <ul class="nav text-uppercase mx-auto justify-content-center">
                    <li class="nav-item "><a class="nav-link" href="/">Home</a></li>

                  </ul>

                </div>
                <?php
              endif;
              ?>
          
              </div>
          </div>
      </footer>
  
  
    </body>
  </html>

            