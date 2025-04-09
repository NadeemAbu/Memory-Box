<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Result</title>
  <style>
    body {
      background: #fff0f6;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }

    .message-box {
      background: white;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-width: 500px;
    }

    h1 {
      color: #d63384;
      font-size: 2rem;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.1rem;
      color: #333;
      margin: 10px 0 20px;
    }

    .back-btn {
      background-color: #ff69b4;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    .back-btn:hover {
      background-color: #e64980;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <?php
    $targetDir = "uploads/";
    $file = $_FILES["photo"];
    $fileName = basename($file["name"]);
    $fileTmpPath = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $uploadOk = true;
    $message = "";

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'webm'];

    // Check file type
    if (!in_array($fileType, $allowedTypes)) {
        $message = "🚫 Only image and video files are allowed (jpg, png, gif, mp4, mov, etc).";
        $uploadOk = false;
    }

    // File size limit (optional: 200MB max for videos)
    if ($fileSize > 200 * 1024 * 1024) {
        $message = "🚫 File is too large. Max size is 200MB.";
        $uploadOk = false;
    }

    // Ensure uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Generate unique file name if it already exists
    $newFileName = $fileName;
    $baseName = pathinfo($fileName, PATHINFO_FILENAME);
    $i = 1;
    while (file_exists($targetDir . $newFileName)) {
        $newFileName = $baseName . "_" . $i . "." . $fileType;
        $i++;
    }

    if ($uploadOk) {
        if (move_uploaded_file($fileTmpPath, $targetDir . $newFileName)) {
            $message = "✅ Your file <strong>" . htmlspecialchars($newFileName) . "</strong> has been uploaded successfully!";
        } else {
            $message = "🚫 Sorry, there was an error uploading your file.";
        }
    }

    echo "<h1>Upload Status</h1>";
    echo "<p>$message</p>";
    ?>
    <a class="back-btn" href="index.html">← Back to Home</a>
  </div>
</body>
</html>
