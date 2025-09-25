<?php
$dir = __DIR__;
$files = scandir($dir);

// Delete file
if (isset($_GET['delete'])) {
    $file = basename($_GET['delete']);
    if (is_file($file)) {
        unlink($file);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $upload = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $upload);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: #eee;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 400;
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            padding: 12px 10px;
            text-align: left;
        }
        th {
            background: #222;
            color: #ccc;
            font-weight: 500;
        }
        tr {
            border-bottom: 1px solid #333;
        }
        a {
            color: #4da6ff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        a.delete {
            color: #ff4d4d;
        }
        .upload-box {
            text-align: center;
            padding: 20px;
            border: 2px dashed #444;
            border-radius: 6px;
            background: #1a1a1a;
        }
        input[type=file] {
            margin: 10px 0;
            color: #ccc;
        }
        button {
            background: #4da6ff;
            color: #fff;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #1a75ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📁 File Manager</h1>

        <table>
            <tr>
                <th>File</th>
                <th>Action</th>
            </tr>
            <?php foreach ($files as $f): ?>
                <?php if ($f === '.' || $f === '..') continue; ?>
                <tr>
                    <td><a href="<?= htmlspecialchars($f) ?>" target="_blank"><?= htmlspecialchars($f) ?></a></td>
                    <td>
                        <?php if (is_file($f)): ?>
                            <a class="delete" href="?delete=<?= urlencode($f) ?>" onclick="return confirm('Delete <?= htmlspecialchars($f) ?>?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="upload-box">
            <form method="post" enctype="multipart/form-data">
                <p><b>Upload a file</b></p>
                <input type="file" name="file" required>
                <br>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
</body>
</html>
