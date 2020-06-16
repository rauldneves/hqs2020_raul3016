<?php
//verificar se não esta logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if (!isset($id)) $id = '';

$nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id =
    $foto = $telefone = $celular = $nome_cidade = $estado = $bairro = $complemento = '';

if (!empty($id)) {

    $sql = "SELECT c.*, 
        DATE_FORMAT(c.datanascimento, '%d/%m/%Y') datanascimento,
        ci.cidade,
        ci.estado
        FROM cliente c
        INNER JOIN cidade ci 
        ON ci.id = c.cidade_id
        WHERE c.id = :id
        LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty ($dados->id)) {
        echo "<p class='alert alert-danger'>Cliente não existe</p>";
    }

    $id = $dados->id;
    $nome = $dados->nome;
    $cpf = $dados->cpf;
    $datanascimento = $dados->datanascimento;
    $email = $dados->email;
    $telefone = $dados->telefone;
    $celular = $dados->celular;
    $foto = $dados->foto;
    
    $cep = $dados->cep;
    $cidade_id = $dados->cidade_id;
    $nome_cidade = $dados->cidade;
    $estado = $dados->estado;
    $endereco = $dados->endereco;
    $bairro = $dados->bairro;
    $complemento = $dados->complemento;

    $imagem = "../fotos/" . $foto . "p.jpg";
}
?>

<div class="container">
    <h1 class="floar-left">Cadastro de Cliente</h1>
    <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
        <a href="listar/cliente" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id ?>">
            </div>

            <div class="col-12 col-md-10">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>" placeholder="Digite seu nome completo">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" onblur="verificarCpf(this.value)" class="form-control" required data-parsley-required-message="Preencha o CPF" value="<?= $cpf ?>" placeholder="Digite seu CPF">
            </div>

            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de Nascimento</label>
                <input type="text" name="datanascimento" id="datanascimento" class="form-control" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $datanascimento ?>" placeholder="Ex. 01/01/1990">
            </div>

            <?php
            $required = "required data-parsley-required-message='Selecione uma foto'";
            if (!empty($id)) $required = '';
            ?>

            <div class="col-10 col-md-3">
                <label for="foto">Foto (.JPG)</label>
                <input type="file" accept=".jpg" name="foto" id="foto" <?= $required ?> class="form-control" value="<?= $foto ?>">

                <input type="hidden" name="foto" value="<?= $foto ?>">
            </div>

            <div class="col-2 col-md-1">
                <?php
                if (!empty($foto)) {
                    echo "<img class='mt-4' src='$imagem' width='50'><br>";
                }
                ?>
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Digite o seu telefone" value="<?= $telefone ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="celular">Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" required required data-parsley-required-message="Preencha o celular" placeholder="Digite o seu celular" value="<?= $celular ?>">
            </div>

            <div class="col-12">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o e-mail" data-parsley-type-message="Digite um e-mail válido" placeholder="Digite o e-mail" value="<?= $email ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required data-parsley-required-message="Preencha a senha">
            </div>

            <div class="col-12 col-md-6">
                <label for="senha2">Confirme a Senha</label>
                <input type="password" id="senha2" onblur="verificarSenha()" class="form-control" required data-parsley-required-message="Confirme a senha">
            </div>

            <div class="col-12 col-md-3">
                <label for="CEP">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" required required data-parsley-required-message="Preencha o CEP" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="cidade_id">ID Cidade</label>
                <input type="text" name="cidade_id" id="cidade_id" class="form-control" required required data-parsley-required-message="Preencha a Cidade" readonly value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-5">
                <label for="nome_cidade">Nome da Cidade</label>
                <input type="text" id="nome_cidade" class="form-control" value="<?= $nome_cidade ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="estado">Estado</label>
                <input type="text" id="estado" class="form-control" value="<?= $estado ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="<?= $bairro ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="complemento">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control" value="<?= $complemento ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-success my-3">
            <i class="fas fa-check"></i>
            Gravar Dados
        </button>
    </form>
</div>

<?php
if (empty($id)) $id = 0
?>

<script>
    $(document).ready(function() {
        $('#datanascimento').inputmask("99/99/9999")
        $('#cpf').inputmask("999.999.999-99")
        $('#telefone').inputmask("(99) 9999-9999")
        $('#celular').inputmask("(99) 9 9999-9999")
    })

    function verificarCpf(cpf) {
        // funcao do ajax para verificar o CPF
        $.get("verificarCpf.php", {
                cpf: cpf,
                id: <?= $id ?>
            },
            function(dados) {
                if (dados != '') {
                    alert(dados)

                    //zerar CPF
                    $('#cpf').val('')
                }

            }
        )
    }

    $('#cep').blur(function() {
        // pega CEP
        let cep = $('#cep').val()

        // remove espacos em branco e caracter que nao tem digito
        cep = cep.replace(/\D/g, '')

        if (cep == '') {
            alert('Preencha o CEP')
        } else {
            //consulta web service viacep.com.br
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                
                $("#nome_cidade").val(dados.localidade);
                $("#estado").val(dados.uf);
                $("#endereco").val(dados.logradouro);
                $("#bairro").val(dados.bairro);

                // buscar o id da cidade
                $.get("buscarCidade.php", 
                    {cidade:dados.localidade, estado:dados.uf},
                    function(dados) {
                        if (dados != "Erro") {
                            $("#cidade_id").val(dados);
                        } else {
                            alert(dados);
                        }
                    })
                
                $("#endereco").focus();
            })
        }
    })

    function verificarSenha() {
        if ($('#senha').val() != $('#senha2').val()) {
            $('#senha').val('')
            $('#senha2').val('')
            $('#senha2').removeClass('is-valid')
            $('#senha2').addClass('is-invalid')
            return alert('As senhas devem ser iguais.')
        }

        $('#senha2').removeClass('is-invalid')
        $('#senha2').addClass('is-valid')
    }
</script>