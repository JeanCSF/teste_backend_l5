<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.17.14/swagger-ui.css" />
    <title>API - Teste Backend L5</title>
    <style>
        .topbar {
            display: none !important;
        }

        #swagger-ui {
            max-width: 650px;
        }
    </style>
</head>

<body class="bg-light">
    <main class="d-flex flex-column align-items-center justify-content-center min-vh-100 p-4">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.17.14/swagger-ui-bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.17.14/swagger-ui-standalone-preset.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>