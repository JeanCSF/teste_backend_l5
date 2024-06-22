    <?= $this->extend('layouts/main') ?>
    <?= $this->section('content') ?>
    <h1 class="text-center">Login</h1>
    <form class="d-flex flex-column col-12 col-md-3">
        <div class="mb-3">
            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
        </div>
        <div class="mb-3">
            <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha">
        </div>
        <div class="text-end">
            <button class="btn btn-primary" type="submit">Entrar</button>
        </div>
    </form>
    <?= $this->endSection() ?>
    <?= $this->section('scripts') ?>
    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const responseData = await response.json();
                if (responseData.cabecalho.status === 200) {
                    sessionStorage.setItem('jwtToken', responseData.token);
                    window.location.reload();
                }

            } catch (error) {
                console.error(error);
            }
        });
    </script>
    <?= $this->endSection() ?>