<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="justify-content-end">
    <button class="btn btn-danger fw-bold" id="logout">SAIR</button>
</div>
<div id="swagger-ui"></div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    window.onload = function() {
        const ui = SwaggerUIBundle({
            url: '/docs.json',
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout",
            requestInterceptor: (request) => {
                const token = sessionStorage.getItem('jwtToken');
                if (token) {
                    request.headers['Authorization'] = 'Bearer ' + token;
                }
                return request;
            }
        });

        window.ui = ui;
    }

    document.getElementById('logout').addEventListener('click', async () => {
        try {
            const response = await fetch('/api/logout', {
                method: 'get',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const responseData = await response.json();
            if (responseData.cabecalho.status === 200) {
                sessionStorage.removeItem('jwtToken');
                window.location.reload();
            }

        } catch (error) {
            console.error(error);
        }
    });
</script>
<?= $this->endSection() ?>