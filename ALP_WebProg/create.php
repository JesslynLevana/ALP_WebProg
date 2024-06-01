<?php 
session_start();
include_once("controller.php");

// Directory for file uploads
$uploadDir = 'uploads/';

// Check if the uploads directory exists, if not, create it
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Process the uploaded photo
if (isset($_FILES["image"])) {
    $image = $_FILES["image"];
    $fileName = basename($image["name"]);
    $fileTmpName = $image["tmp_name"];
    $fileSize = $image["size"];
    $fileType = $image["type"];

    if ($fileSize > 0) {
        // Check allowed file types
        if ($fileType == "image/jpeg" || $fileType == "image/png") {
            // Move the photo file to the desired directory
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                // Photo uploaded successfully
                $photoUrl = $targetFile;
            } else {
                // Failed to upload photo
                echo "Failed to upload photo.";
                exit;
            }
        } else {
            // Invalid file type
            echo "Please upload JPEG or PNG files.";
            exit;
        }
    } else {
        // No photo uploaded
        $photoUrl = "";
    }
} else {
    // Photo not found
    $photoUrl = "";
}

// Call the createMovie function
if(isset($_POST['submit'])){
    $result = createMovie($photoUrl);
    echo $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav class="bg-slate-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button id="mobile-menu-button" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" id="icon-menu" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>

                        <svg class="hidden h-6 w-6" id="icon-close" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-between sm:-mr-32">
                    <div class="flex flex-shrink-0 items-center sm:-ml-32">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4 px-5">
                            <a href="movie.php" class="text-orange-300 hover:text-orange-400 px-3 py-5 text-sm font-medium" aria-current="page">Movie List</a>
                            <a href="create.php" class="text-orange-300 border-b-4 border-orange-300 px-3 py-5 text-sm font-medium">Add Movie</a>
                            <div class="py-5 text-sm font-medium">
                                <p class="text-white font-bold text-l">Hello <?= htmlspecialchars($_SESSION["username"]) ?>!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="movie.php" class="text-orange-300 hover:text-orange-400 px-3 py-5 text-sm font-medium" aria-current="page">Movie List</a>
                <a href="create.php" class="text-orange-300 border-b-4 border-orange-300 px-3 py-5 text-sm font-medium">Add Movie</a>
            </div>
        </div>
    </nav>
    <header class="mx-3 mt-20 mb-5">
        <h1 class="mx-3 mb-5 font-bold text-3xl">Add Movie</h1>
    </header>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8">
        <form action="create.php" method="post" class="space-y-6" enctype="multipart/form-data">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="synopsis" class="block text-sm font-medium text-gray-700">Synopsis</label>
                <textarea name="synopsis" id="synopsis" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
            </div>
            <div>
                <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                <input type="text" name="genre" id="genre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                <input type="text" name="duration" id="duration" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="age" class="block text-sm font-medium text-gray-700">Rating age</label>
                <input type="number" name="age" id="age" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="day" class="block text-sm font-medium text-gray-700">Released Day</label>
                <input type="text" name="day" id="day" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="released_date" class="block text-sm font-medium text-gray-700">Released date</label>
                <input type="date" name="released_date" id="released_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="times" class="block text-sm font-medium text-gray-700">Time</label>
                <input type="time" name="times" id="times" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <input type="submit" name="submit" value="Submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            </div>
        </form>
    </div>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            var iconMenu = document.getElementById('icon-menu');
            var iconClose = document.getElementById('icon-close');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                iconMenu.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                iconMenu.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
