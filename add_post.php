<?php
include("db.php");

if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    $image = $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "uploads/".$image
    );

    $sql = "INSERT INTO posts(title,content,image)
            VALUES('$title','$content','$image')";

    mysqli_query($conn,$sql);

    echo "Post Added Successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>

<h2>Add Post</h2>

<form method="POST" enctype="multipart/form-data">

    Title:
    <input type="text" name="title" required>

    <br><br>

    Content:
    <textarea name="content" required></textarea>

    <br><br>

    Image:
    <input type="file" name="image">

    <br><br>

    <input type="submit" name="submit" value="Add Post">

</form>

</body>
</html>