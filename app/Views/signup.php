<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-center">Cadastrar</h1>
<form class="d-flex flex-column col-12 col-md-3">
    <div class="mb-3">
        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required minlength="3">
    </div>
    <div class="mb-3">
        <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" required minlength="3">
    </div>
    <div class="mb-3">
        <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" placeholder="Confirmar Senha" required minlength="3">
    </div>
    <div class="d-flex justify-content-between">
        <a href="javascript:history.go(-1)" class="btn btn-secondary">Voltar</a>
        <button class="btn btn-primary" type="submit">Cadastrar</button>
    </div>
</form>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    let msg = document.querySelector('.toast-body');
    const toastElement = document.querySelector('.toast');
    const toast = new bootstrap.Toast(toastElement);

    function validarSenha() {
        const senha = document.querySelector('#senha');
        const confirmarSenha = document.querySelector('#confirmar_senha');

        if (senha.value !== confirmarSenha.value) {
            msg.textContent = 'As senhas devem ser iguais';
            toast.show();
            return false;
        }

        return true;
    }

    const form = document.querySelector('form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            if (!validarSenha()) {
                return;
            }
            const response = await fetch('/api/signup', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const responseData = await response.json();
            if (!response.ok) {
                const erros = Object.entries(responseData.cabecalho.erros).map(([key, value]) => `${key}: ${value}`);
                msg.textContent = `${responseData.cabecalho.mensagem}\n${erros.join('\n')}`;
                toast.show();
                return;
            }

            if (responseData.cabecalho.status === 201) {
                msg.textContent = `${responseData.cabecalho.mensagem}\nRedirecionando...`;
                toast.show();
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }

        } catch (error) {

            console.error(error);
        }
    });
</script>
<?= $this->endSection() ?>