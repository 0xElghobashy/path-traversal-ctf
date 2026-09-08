<?php
// index.php - Page listing invoices available to employees
// These files are the ONLY ones that should be accessible; anything else on the server is off-limits

$documentsDir = __DIR__ . '/documents';
$files = array_diff(scandir($documentsDir), ['.', '..']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>DocuShare - Company Documents</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>DocuShare</h1>
        <p>Internal Document Sharing System - Accounting Department</p>
    </header>
    <main>
        <h2>Available Invoices</h2>
        <ul class="doc-list">
            <?php foreach ($files as $file): ?>
            <li>
                <span class="doc-name"><?php echo htmlspecialchars($file); ?></span>
                <a class="download-btn" href="downloads.php?file=<?php echo urlencode($file); ?>">Download</a>
            </li>
            <?php endforeach; ?>
        </ul>
        <p class="note">DocuShare v1.0 &mdash; Internal Use Only</p>
    </main>
</body>
</html>
