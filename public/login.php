<?php 
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UMS : Login</title>
  <link href="output.css" rel="stylesheet" />
</head>

<body>
  <div class="login-from flex flex-col justify-center items-center w-screen h-screen">
    <?php
    if (isset($_SESSION["messages"])) {
    ?>
      <div role="alert" class="alert alert-success alert-warning alert-<?php echo $_SESSION['messages_type'] ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php
              foreach ($_SESSION["messages"] as $message) {
                echo nl2br($message);
              }
              ?></span>
      </div>
    <?php
      session_unset();
    }
    ?>
    <fieldset
      class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
      <legend class="fieldset-legend">Login</legend>
      <form action="../auth/handel_login.php" method="post">
        <label class="label m-1">Email</label>
        <input name="email" type="email" class="input" placeholder="Email" />

        <label class="label m-1">Password</label>
        <input
          name="password"
          type="password"
          class="input"
          placeholder="Password" />
        <button type="submit" class="btn btn-primary mt-4 w-full">
          Login
        </button>
      </form>
      <a href="register.php"class="btn btn-neutral btn-dash text-white">Reister Here</a>
    </fieldset>
  </div>
</body>

</html>