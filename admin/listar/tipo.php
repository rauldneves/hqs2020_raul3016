<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Tipo de Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/tipo" class="btn btn-success">Novo Registro</a>
		<a href="listar/tipo" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td>ID</td>
				<td>Tipo de Quadrinho</td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar em ordem alfabetica
				$sql = "select * from tipo 
				order by tipo";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar dados
					$id 	= $dados->id;
					$tipo 	= $dados->tipo;

					//mostrar na telaa
					echo '<tr>
						<td>'.$id.'</td>
						<td>'.$tipo.'</td>
						<td>
							<a href="cadastro/tipo/'.$id.'" class="btn btn-success btn-sm">
								<i class="fas fa-edit"></i>
							</a>
						</td>
					</tr>';
				}
			?>
		</tbody>
	</table>

</div>