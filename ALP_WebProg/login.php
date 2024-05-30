<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="text-center mt-20 mb-5">
        <h1 class="font-bold text-5xl">Welcome to MovieZone!</h1>
        <h4>Where Theater Meets Enthusiasts</h4>
    </header>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="relative w-full max-w-[400px] mx-auto">
            <div class="absolute top-0 left-0 w-full h-full rotate-[5deg] bg-slate-700 rounded-lg z-[-1] shadow-[0_0_10px_rgba(0,0,0,0.1)]"></div>
            <div class="bg-slate-400 py-8 px-6 shadow rounded-lg sm:px-10 relative z-10">
                <h2 class="text-3xl font-bold text-slate-700">Hello!</h2>
                <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-slate-700">Username</label>
                        <div class="mt-2">
                            <input type="text" id="username" name="username" required class="block w-full rounded-md border-0 px-2 py-1.5 text-slate-700">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium leading-6 text-slate-700">Password</label>
                        </div>
                        <div class="mt-2">
                            <input type="password" id="password" name="password" autocomplete="current-password" required class="block w-full rounded-md border-0 px-2 py-1.5 text-slate-700 shadow-sm focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-orange-300 px-3 py-1.5 text-sm font-semibold leading-6 text-slate-700 shadow-sm hover:bg-[#fb923c] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    session_start();
    // Check if the form is submitted
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        if ($_SESSION["username"] == "admin" && $_SESSION["password"] == "admin") {
            // Correct credentials, redirect to movie.php
            header("Location: profile.php");
        } else {
            // Incorrect credentials, set error message
            echo "<script> alert ('Login failed. Please try again.') </script>";
        }
    }
    ?>
</body>

</html>
