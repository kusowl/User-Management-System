<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UMS : Register</title>
  <link href="output.css" rel="stylesheet" />
</head>

<body>

  <div class="register-from flex flex-col justify-center items-center w-full h-screen">
    <?php
    if (isset($_SESSION["messages"])) {
    ?>
      <div class="alert alert-success" hidden></div>
      <div class="alert alert-warning" hidden></div>
      <div class="alert alert-error" hidden></div>
      <div role="alert" class="alert alert-<?php echo $_SESSION['messages_type'] ?>">
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
      <legend class="fieldset-legend">Register</legend>
      <form action="../auth/handel_register.php" method="post" enctype="multipart/form-data">
        <label class="label my-2">name</label>
        <input
          name="name"
          type="text"
          class="input"
          placeholder="Full name" />

        <label class="label my-2">Email</label>
        <input name="email" type="email" class="input" placeholder="Email" />

        <label class="label my-2">Password</label>
        <input
          name="password"
          type="password"
          class="input"
          placeholder="Password" />

        <label class="label my-2">Confirm Password</label>
        <input
          name="cpassword"
          type="password"
          class="input"
          placeholder="Type password again" />
        <label class="label my-2">Upload profile photo</label>
        <input type="file" class="file-input" name="profile_image" />
        <label class="label text-gray-600">*Max size 2MB</label>

        <button type="submit" class="btn btn-primary mt-4 w-full">
          Register
        </button>
      </form>
      <a href="login.php"class="btn btn-neutral btn-dash text-white">login</a>
    </fieldset>
  </div>
</body>

</html>