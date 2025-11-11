<?php
include 'includes/conexao.php';
include 'includes/header.php';

// Verifica se o ID foi passado pela URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // garante que seja número

    // Busca o astro no banco de dados
    $sql = "SELECT * FROM astros WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $astro = $result->fetch_assoc();
    } else {
        echo "<main><p>Astro não encontrado.</p></main>";
        include 'includes/footer.php';
        exit;
    }
} else {
    echo "<main><p>Nenhum astro selecionado.</p></main>";
    include 'includes/footer.php';
    exit;
}
?>

<main class="detalhes-container">
  <h2><?php echo $astro['nome']; ?></h2>
  <img src="<?php echo $astro['imagem']; ?>" alt="<?php echo $astro['nome']; ?>">
  <p><strong>Tipo:</strong> <?php echo $astro['tipo']; ?></p>
  <?php if (!empty($astro['distancia'])): ?>
    <p><strong>Distância:</strong> <?php echo $astro['distancia']; ?></p>
  <?php endif; ?>
  <p class="descricao"><?php echo $astro['descricao']; ?></p>

  <a href="catalogo.php" class="btn-voltar">← Voltar ao catálogo</a>
</main>

<?php include 'includes/footer.php'; ?>
