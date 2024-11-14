<?php

?>
<div class="container">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Cadastro</h1>

        <div class="form-floating">
            <input name="nome" type="text" class="form-control" id="floatingInput">
            <label for="floatingInput">Nome do produto</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="login" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Descrição</label>
        </div>
        <br/>

</div>
        <button name="acao" class="btn btn-primary w-200 py-2 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom" type="submit">Cadastrar</button>
    </form>
</div>