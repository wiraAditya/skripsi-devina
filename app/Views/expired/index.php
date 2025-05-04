<!DOCTYPE html>
<html>
<head>
    <title>License Expired</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .error { color: red; font-weight: bold; }
        .contact { margin-top: 30px; padding: 20px; border: 1px solid #ddd; display: inline-block; }
    </style>
</head>
<body>
    <h1 class="error">License Expired</h1>
    <p>Your access license has expired.</p>
    <p>This software requires an active license to operate properly.</p>
    
    <div class="contact">
        <h3>To renew your license:</h3>
        <p>Please contact the developer at:</p>
        <p><strong>Email:</strong> your@email.com</p>
        <p><strong>Phone:</strong> +1234567890</p>
    </div>
    
    <p>Reference ID: <?= md5(time()) ?></p>
</body>
</html>