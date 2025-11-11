<?php
include('includes/conexao.php');
include('includes/header.php');

$dificuldade = $_GET['nivel'] ?? null;

if (!$dificuldade) {
  // Tela de seleção de dificuldade
  ?>
  <main class="quiz-container">
    <h2>🧩 Quiz de Astronomia</h2>
    <p>Escolha o nível de dificuldade para começar:</p>

    <div class="nivel-container">
      <a href="quiz.php?nivel=Fácil" class="btn-acao">🌕 Fácil</a>
      <a href="quiz.php?nivel=Médio" class="btn-acao">🌗 Médio</a>
      <a href="quiz.php?nivel=Difícil" class="btn-acao">🌑 Difícil</a>
    </div>
  </main>
  <?php
  include('includes/footer.php');
  exit;
}

// Busca perguntas do nível selecionado
$sql = "SELECT * FROM perguntas WHERE dificuldade = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dificuldade);
$stmt->execute();
$result = $stmt->get_result();


$perguntas = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $perguntas[] = $row;
  }
}

// Processa o resultado se o formulário for enviado
$pontuacao = 0;
$total = count($perguntas);
$respondido = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $respondido = true;
  foreach ($perguntas as $p) {
    $id = $p['id'];
    $resposta = $_POST["pergunta_$id"] ?? '';
    if ($resposta === $p['resposta_certa']) {
      $pontuacao++;
    }
  }
}
?>

<main class="quiz-container">
  <h2>🧩 Quiz de Astronomia</h2>
  <p>Você escolheu o nível: <strong><?php echo $dificuldade; ?></strong></p>

  <?php if (!$respondido): ?>
    <form method="POST">
      <?php foreach ($perguntas as $p): ?>
        <div class="pergunta">
          <p><strong><?php echo $p['pergunta']; ?></strong></p>
          <label><input type="radio" name="pergunta_<?php echo $p['id']; ?>" value="<?php echo $p['opcao1']; ?>" required> <?php echo $p['opcao1']; ?></label><br>
          <label><input type="radio" name="pergunta_<?php echo $p['id']; ?>" value="<?php echo $p['opcao2']; ?>"> <?php echo $p['opcao2']; ?></label><br>
          <label><input type="radio" name="pergunta_<?php echo $p['id']; ?>" value="<?php echo $p['opcao3']; ?>"> <?php echo $p['opcao3']; ?></label><br>
        </div>
      <?php endforeach; ?>
      <button type="submit">Enviar Respostas</button>
    </form>
  <?php else: ?>
    <div class="resultado">
      <h3>Resultado</h3>
      <p>Você acertou <strong><?php echo $pontuacao; ?></strong> de <strong><?php echo $total; ?></strong> perguntas.</p>
      <?php if ($pontuacao == $total): ?>
        <p>🌟 Incrível! Você é um verdadeiro astrônomo!</p>
      <?php elseif ($pontuacao >= ($total/2)): ?>
        <p>🚀 Muito bom! Continue estudando o cosmos!</p>
      <?php else: ?>
        <p>🪐 Não desanime! Há muito a aprender sobre o universo.</p>
      <?php endif; ?>
      <a href="quiz.php" class="btn-voltar">Tentar novamente</a>
    </div>
  <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
