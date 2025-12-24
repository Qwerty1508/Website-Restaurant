<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Maintenance - Culinaire</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0B0E10 0%, #1a1f25 50%, #0B0E10 100%);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow: hidden;
        }
        .maintenance-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }
        .icon-wrapper {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            background: rgba(200, 155, 58, 0.1);
            border: 2px solid rgba(200, 155, 58, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s ease-in-out infinite;
        }
        .icon-wrapper i {
            font-size: 4rem;
            color: #D4AF37;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #D4AF37;
        }
        p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        .progress-bar-wrapper {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 2rem;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            width: 30%;
            background: linear-gradient(90deg, #D4AF37, #F5D77F, #D4AF37);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
            border-radius: 2px;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .contact-info {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(200, 155, 58, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }
        .contact-info p {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .contact-info a {
            color: #D4AF37;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        .decoration {
            position: fixed;
            opacity: 0.03;
            pointer-events: none;
        }
        .decoration.top-left {
            top: -100px;
            left: -100px;
            font-size: 300px;
        }
        .decoration.bottom-right {
            bottom: -100px;
            right: -100px;
            font-size: 300px;
        }
    </style>
</head>
<body>
    <i class="bi bi-gear decoration top-left"></i>
    <i class="bi bi-tools decoration bottom-right"></i>
    
    <div class="maintenance-container">
        <div class="icon-wrapper">
            <i class="bi bi-wrench-adjustable"></i>
        </div>
        
        <h1>Under Maintenance</h1>
        
        <p>
            Kami sedang melakukan peningkatan sistem untuk memberikan pengalaman yang lebih baik. 
            Website akan segera kembali online.
        </p>
        
        <div class="progress-bar-wrapper">
            <div class="progress-bar"></div>
        </div>
        
        <div class="contact-info">
            <p><i class="bi bi-envelope me-2"></i> Hubungi kami di</p>
            <p><a href="mailto:info@culinaire.id">info@culinaire.id</a></p>
        </div>
    </div>
</body>
</html>
