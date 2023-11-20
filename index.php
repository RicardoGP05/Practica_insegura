<?php

// Initialize default message
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Directory where files will be stored (ensure write permissions)
    $uploadDirectory = 'uploads/';

    // File name and full path
    $originalFileName = $_FILES['archivo']['name'];
    $uploadedFile = $uploadDirectory . $originalFileName;

    // Check if the directory exists, if not, create it
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    // Move the file to the destination directory
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadedFile)) {
        $mensaje = "The file has been uploaded successfully.";
    } else {
        $mensaje = "Error uploading the file.";
    }

    // Send the response to the client
    echo $mensaje;
    exit;
} else {
    $mensaje = "Access not allowed.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure File Upload</title>
    <!-- Include Bootstrap CSS (make sure to have access to the Bootstrap library) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="mb-4">Secure File Upload</h1>

    <form id="uploadForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="archivo" class="form-label">Select a file:</label>
            <input type="file" class="form-control" name="archivo" id="archivo" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload File</button>
    </form>

    <!-- Display messages dynamically here -->
    <div id="mensaje" class="mt-3"></div>

    <!-- Include Bootstrap JS and dependencies (make sure to have access to the Bootstrap library) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#uploadForm").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $("#mensaje").html(response);
                    }
                });
            });
        });
    </script>
</body>

</html>
