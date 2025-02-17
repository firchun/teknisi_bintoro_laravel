<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Layanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Notifikasi Layanan
        </div>
        <div class="content">
            <p>{{ $messageText }}</p>
            <a href="{{ url('/') }}" class="button">Cek Status</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SERVICE AC BINTORO. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
