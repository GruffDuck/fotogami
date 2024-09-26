<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 80px;
            height: 80px;
        }
        .content {
            text-align: center;
            margin-top: 20px;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            color: inherit; /* Use the default text color */
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://www.mpstudiocore.com/fotogamilogo.png" alt="Logo">
        </div>
        <div class="content">
            <p>You can use the following code to reset your password:</p>
            <p class="code">{{ $token }}</p>
        </div>
        <div class="footer">
            <p>Fotogami is a MasterPiece Studios product.</p>
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>&copy; 2024 Fotogami. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
