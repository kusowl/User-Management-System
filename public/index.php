<?php 
  session_start();
  if(!isset($_SESSION["name"]))
    header("location:login.php")
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UMS : Dashboard</title>
    <link href="output.css" rel="stylesheet" />
  </head>
  <!-- Profile Update section -->
  <input type="checkbox" id="my_modal_6" class="modal-toggle" />
  <div class="modal" role="dialog">
    <div class="modal-box">
      <form
        action="../auth/update_profile.php"
        method="post"
        enctype="multipart/form-data"
        class="flex flex-col"
      >
        <label class="label my-2">name</label>
        <input name="name" type="text" class="input" value="<?php echo $_SESSION["name"]?>" placeholder="Full name" />

        <label class="label my-2">Email</label>
        <input name="email" type="email" class="input" value="<?php echo $_SESSION["email"]?>" placeholder="Email" />
        <label class="label my-2">Upload profile photo</label>
        <input type="file" name="profile_image" class="file-input" />
        <label class="label text-gray-600">*Max size 2MB</label>

        <div class="modal-action justify-start">
          <button type="submit" class="btn btn-neutral w-20">Save</button>
          <label for="my_modal_6" class="btn">Close!</label>
        </div>
      </form>
    </div>
  </div>
<!-- Change Password section` -->
  <input type="checkbox" id="my_modal_7" class="modal-toggle" />
  <div class="modal" role="dialog">
    <div class="modal-box">
      <form
        action="../auth/change_password.php"
        method="post"
        class="flex flex-col"
      >
        <label class="label my-2">Current Password</label>
        <input
          name="old_password"
          type="Password"
          class="input"
          placeholder="Old Password"
        />
        <label class="label my-2">New Password</label>
        <input
          name="password"
          type="Password"
          class="input"
          placeholder="New Password"
        />
        <label class="label my-2">New Password Again</label>
        <input
          name="cpassword"
          type="Password"
          class="input"
          placeholder="Again type the new Password"
        />
        <div class="modal-action justify-start">
          <button type="submit" class="btn btn-neutral w-20">Save</button>
          <label for="my_modal_7" class="btn">Close!</label>
        </div>
      </form>
    </div>
  </div>

  <body>
    <div class="flex flex-col rounded-box bg-base-200 p-7 gap-4">
      <div class="heading-hero flex gap-4 items-center">
        <div class="avatar">
          <div class="w-24 rounded-xl">
            <img
              src="<?php echo $_SESSION["picture"]?>"
            />
          </div>
        </div>
        <h2 class="font-bold text-5xl">Hello! <?php echo $_SESSION["name"]?></h2>
      </div>
      <div class="divider"></div>
      <?php
    if (isset($_SESSION["messages"])) {
    ?>
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
        unset($_SESSION["messages"]);
        unset($_SESSION["messages_type"]);
    }
    ?>
      <div class="actions flex">
        <div
          class="card bg-base-300 rounded-box grid h-20 grow place-items-center"
        >
          <!-- The button to open modal -->
          <label for="my_modal_6" class="btn bg-blue-500">Profile Update</label>

          <!-- Put this part before </body> tag -->
        </div>
        <div class="divider divider-horizontal"></div>
        <div
          class="card bg-base-300 rounded-box grid h-20 grow place-items-center"
        >
          <label for="my_modal_7" class="btn bg-yellow-600"
            >Change Password</label
          >
        </div>
        <div class="divider divider-horizontal"></div>
        <div
          class="card bg-base-300 rounded-box grid h-20 grow place-items-center"
        >
          <a class="btn bg-red-500" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </body>
</html>
