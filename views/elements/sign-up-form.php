
   <div class="row">
            <h1 class="title mx-auto logo-font pt-5 text-light"><?=APP_NAME?></h1>
        </div>
        <div class="row mb-5">
            <h3 class="mx-auto text-center text-light secondary-font">Share, Inspire, Invent</h3>
     </div>
    
    
    
    <div class="row mb-5 pb-5">
        <div class="accordion pink-outline card my-4 mx-auto" id="signupAccordion"> 
            <div> <!--ACCORDION-->
                
                <div class="card-header mx-auto" id="signupCard" data-toggle="collapse" data-target="#signupCardBody">
                    <h4 class='text-center'>Sign up for <?=APP_NAME?></h4>
                </div>
                <div class="card-body collapse" id="signupCardBody" data-parent="#signupAccordion">
                    <?php echo (!empty($_SESSION["create_account_msg"]))?$_SESSION["create_account_msg"]:''; ?>
                    <form action="/users/add.php" method="post">
                        <input type="text" class="form-control mb-3" name="username" placeholder="Username" required>
                        <input type="text" class="form-control mb-3" name="email" placeholder="Email Address" required>
                        <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
                        <input type="password" class="form-control mb-3" name="password2" placeholder="Confirm Password" required>
                        <hr>
                        <h5>Profile Info</h5>
                        <input type="text" class="form-control mb-3" name="firstname" placeholder="First Name" required>
                        <input type="text" class="form-control mb-3" name="lastname" placeholder="Last Name" required>
                        <textarea name="bio" placeholder="bio" class="form-control secondary-font"></textarea>
                        <div class="text-right">
                            <button type="submit" id="styled-btn" class="btn mt-3">Create Account</button>
                        </div>   
                    </form>
                </div>
            </div> 
            <div class="card">
                <div class="card-header" id="loginCard" data-toggle="collapse" data-target="#loginCardBody">
                    <h4>Login</h4>
                </div>
                <div class="card-body collapse show" id="loginCardBody" data-parent="#signupAccordion">
                <?php echo (!empty($_SESSION["login_attempt_msg"]))?$_SESSION["login_attempt_msg"]:''; ?>
                    <form action="/users/login.php" method="post">
                        <input type="text" name="username" class="form-control mb-3" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <div class="form-group">
                            <input type="checkbox" name="remember" id="remember" value="true">
                            <label for="remember">Remember Me</label>
                        </div>
                        <div class="text-right">
                            <button type="submit" id="styled-btn" class="btn">
                                Login
                            </button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
unset($_SESSION["login_attempt_msg"]);
unset($_SESSION["create_account_msg"]);
?>
