<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Password Berhasil Direset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            min-height: 100vh;
            background: #fff;
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .center-box {
            background: #fff;
            max-width: 400px;
            width: 100%;
            padding: 36px 30px 30px 30px;
            border-radius: 20px;
            box-shadow: 0 4px 24px 0 #42325222;
            text-align: center;
            border: 1px solid #f2f2f4;
        }
        .logo {
            background: #BFA045;
            width: 52px; height: 52px;
            border-radius: 50%;
            margin: 0 auto 18px auto;
            display: flex; align-items: center; justify-content: center;
        }
        .logo svg { width: 28px; height: 28px; fill: #fff;}
        h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 16px 0;
            color: #BFA045;
            letter-spacing: -1px;
        }
        .desc {
            font-size: 1.07rem;
            color: #423252cc;
            margin-bottom: 26px;
        }
        .btn-main {
            display: block;
            width: 100%;
            padding: 14px;
            font-size: 1.08rem;
            font-weight: 600;
            background: #BFA045;
            border: none;
            border-radius: 10px;
            color: #fff;
            box-shadow: 0 2px 8px 0 #BFA04518;
            cursor: pointer;
            transition: background 0.2s, transform 0.16s;
            margin-bottom: 16px;
            text-decoration: none;
        }
        .btn-main:active, .btn-main:hover {
            background: #423252;
        }
        .alert-success {
            background: #ece9f2;
            color: #423252;
            border-radius: 10px;
            padding: 14px;
            font-weight: 500;
            font-size: 1.07rem;
            margin-bottom: 20px;
            border: 1px solid #42325244;
            box-shadow: 0 2px 8px #42325212;
        }
        .back-link {
            color: #423252;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.16s;
            font-weight: 500;
        }
        .back-link:hover {
            color: #BFA045;
            text-decoration: underline;
        }
        @media (max-width:500px) {
            .center-box {padding: 18px 7vw 18px 7vw;}
            h2 {font-size: 1.15rem;}
        }
    </style>
</head>
<body>
    <div class="center-box">
        <div class="logo">
            <!-- Ikon centang/kunci sukses -->
            <svg viewBox="0 0 24 24">
                <path d="M17 9V7a5 5 0 0 0-10 0v2A5 5 0 0 0 2 14a5 5 0 0 0 5 5h10a5 5 0 0 0 5-5a5 5 0 0 0-5-5zm-8 0V7a3 3 0 0 1 6 0v2H9zm11 5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3zm-7 1a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"/>
            </svg>
        </div>
        <h2>Password Berhasil Direset</h2>
        <div class="alert-success">
            Password Anda telah berhasil diperbarui. Silakan login kembali !
        </div>
    </div>
</body>
</html>
