<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h1>Search for a Movie</h1>
    <form action="index.php" method="GET">
        <input type="hidden" name="action" value="search">
        <input type="text" name="title" placeholder="Enter movie title" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
