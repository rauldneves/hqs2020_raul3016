<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
	exit;
}
?>
<div class="container">
	<h1 class="float-left">Listar Editora</h1>
	<div class="float-right">
		<a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
		<a href="listar/editora" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome da Editora</td>
				<td>Site da Editora</td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			//buscar em ordem alfabetica
			$sql = "select * from editora 
				order by nome";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
				//separar dados
				$id 	= $dados->id;
				$nome 	= $dados->nome;
				$site 	= $dados->site;
				//vai mostrar na tela tela
				echo '<tr>
						<td>' . $id . '</td>
						<td>' . $nome . '</td>
						<td>' . $site . '</td>
						<td>
							<a href="cadastro/editora/' . $id . '" class="btn btn-success btn-sm">
								<i class="fas fa-edit"></i>
							</a>

							<a href="javascript:excluir(' . $id . ')" class="btn btn-danger btn-sm">
								<i class="fas fa-trash"></i>
							</a>

							<button type="button" class="btn btn-danger btn-sm" onclick="excluir(' . $id . ')">
								<i class="fas fa-trash"></i>
							</button>
						</td>
					</tr>';
			}
			?>
		</tbody>
	</table>
</div>
<script>
	//funcao para perguntar se deseja excluir
	//se sim direcionar para o endereco de exclusão
	function excluir(id) {
		//perguntar - função confirm
		if (confirm("Deseja mesmo excluir?")) {
			//direcionar para a exclusao
			location.href = "excluir/editora/" + id;
		}
	}

	//adicionar o dataTable na tabela
	$(document).ready(function() {
		$('#tabela').Datatable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
			}
		})
	})
</script>