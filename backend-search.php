<?php
include_once("./includes/header.php");

if (isset($_REQUEST["inicio"]) && isset($_REQUEST["fim"])) {
  // Prepare a select statement
  $sql = "SELECT p.nomePasseio, p.dataPasseio, count(pp.idPagamento) AS 'NVendas',SUM(pp.valorVendido) AS 'ValorVenda', SUM(pp.valorPago) AS 'ValorPago' FROM pagamento_passeio pp, passeio p WHERE `createdAt` BETWEEN ? AND ? AND statusPagamento NOT IN (0) AND pp.valorPago > 0 AND p.idPasseio = pp.idPasseio GROUP BY pp.idPasseio;";

  if ($stmt = mysqli_prepare($conexao, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $inicioDataPasseio, $fimDataPasseio);

    // Set parameters
    $inicioDataPasseio = $_REQUEST["inicio"];
    $fimDataPasseio = $_REQUEST["fim"];
    // $test = $_REQUEST["totalElements"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      $result = mysqli_stmt_get_result($stmt);
      // Check number of rows in the result set
      if (mysqli_num_rows($result) > 0) {
        // if ((int)$test !==  (int)mysqli_num_rows($result)){
        //   echo 'ok';
        // }
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $nomePasseio = $row['nomePasseio'];
          $dataPasseio = verifyDate($row['dataPasseio']);
          $NVendas = $row['NVendas'];
          $ValorVenda = $row['ValorVenda'];
          $ValorPago = $row['ValorPago'];
?>
          <tbody>
            <td><?php echo $nomePasseio; ?></td>
            <td><?php echo $dataPasseio->dateFormated; ?></td>
            <td><?php echo $NVendas; ?></td>
            <td><?php echo $ValorVenda; ?></td>
            <td><?php echo $ValorPago; ?></td>
          </tbody>
<?php
        }
      } else {
        echo "<p>No matches found</p>";
      }
    } else {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conexao);
    }
  }

  // Close statement
  mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($conexao);
?>