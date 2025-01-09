<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .error-container {
            max-width: 400px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .error-title {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f;
        }
        .error-message {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #5bc0de;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #31b0d5;
        }
    </style>
</head>
<body>


    <div class="error-container">
        </a> </div>
        <div class="error-title">Accès refusé</div>
        <div class="error-message">Désolé, vous n'avez pas accès à cette page.</div>
        <button class="back-button" onclick="window.history.back();">Retourner à la page précédente</button>
    </div>
</body>
</html>
