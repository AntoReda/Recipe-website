<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            margin-bottom: 2rem;
        }
        .home-button {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Database Error</h1>
        <?php
        $error_type = isset($_GET['error']) ? $_GET['error'] : 'unknown';
        
        switch($error_type) {
            case 'connection':
                echo "<p>Unable to connect to the database. Please check if your database server is running.</p>";
                break;
            case 'missing_database':
                echo "<p>The required database does not exist. Please ensure the database is properly set up.</p>";
                break;
            case 'missing_table':
                echo "<p>Required database table 'users' is missing. Please ensure all database tables are properly set up.</p>";
                break;
            default:
                echo "<p>An unexpected database error occurred. Please try again later or contact support if the problem persists.</p>";
        }
        ?>
        <p class="error-details">Error Type: <?php echo htmlspecialchars($error_type); ?></p>
        <a href="Recipe_HomePage.php" class="home-button">Return to Homepage</a>
    </div>
</body>
</html> 