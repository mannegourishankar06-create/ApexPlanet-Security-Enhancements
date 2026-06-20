<?php
session_start();
include("db.php");

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

if(isset($_GET['search']) && !empty($_GET['search']))
{
    $search = $_GET['search'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM posts
        WHERE title LIKE '%$search%'
        OR content LIKE '%$search%'"
    );
}
else
{
    $result = mysqli_query(
        $conn,
        "SELECT * FROM posts
        LIMIT $start,$limit"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION['username']; ?></h2>

<a href="add_post.php">Add Post</a> |
<a href="logout.php">Logout</a>

<br><br>

<form method="GET">
    <input type="text" name="search" placeholder="Search Post">
    <input type="submit" value="Search">
</form>

<br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Content</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td><?php echo htmlspecialchars($row['content']); ?></td>

    <td>
        <img src="uploads/<?php echo $row['image']; ?>" width="100">
    </td>

    <td>
        <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
        |
        <a href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>

</tr>

<?php } ?>

</table>

<br><br>

<a href="?page=<?php echo $page-1; ?>">Previous</a>

|

<a href="?page=<?php echo $page+1; ?>">Next</a>

</body>
</html>