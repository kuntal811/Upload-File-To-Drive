<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Google Drive Example App</title>
    </head>
    <body>
        <form method="post" action="http://localhost/uploadDrive/" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" value="Upload" name="submit">
        </form>
    </body>
</html>
