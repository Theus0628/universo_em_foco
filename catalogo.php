<?php
include 'includes/conexao.php';
include 'includes/header.php';
?>

<main>
  <h2>Catálogo de Astros</h2>
  <p>Explore planetas, estrelas, galáxias e muito mais!</p>

  <div class="catalogo-container">
    <?php
    // Buscar todos os astros do banco de dados
    $sql = "SELECT * FROM astros ORDER BY nome ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
          <div class='astro-card'>
            <img src='{$row['imagem']}' alt='{$row['nome']}'>
            <h3>{$row['nome']}</h3>
            <p><strong>Tipo:</strong> {$row['tipo']}</p>
            <p>" . substr($row['descricao'], 0, 100) . "...</p>
            <a href='detalhes.php?id={$row['id']}' class='btn-detalhes'>Ver mais</a>
          </div>
        ";
      }
    } else {
      echo "<p>Nenhum astro cadastrado ainda.</p>";
    }

    $conn->close();
    ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
