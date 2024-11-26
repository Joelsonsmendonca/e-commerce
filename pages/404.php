<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #333; /* Mesma cor do container */
            font-family: 'Arial', sans-serif;
            color: #fff;
        }

        .container {
            text-align: center;
            background-color: #333; /* Cor do fundo do container */
            color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 6rem;
            color: #007ACC;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .btn {
            text-decoration: none;
            font-size: 1.2rem;
            padding: 12px 25px;
            background-color: #007ACC;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #005f99;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 4rem;
            }

            p {
                font-size: 1.2rem;
            }

            .btn {
                font-size: 1rem;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>404</h1>
    <p>Oops! Página não encontrada.</p>
    <a href="/e-commerce" class="btn">Voltar à Página Inicial</a>
</div>
</body>
</html>
