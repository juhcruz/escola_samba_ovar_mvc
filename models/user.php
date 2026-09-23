<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>Inserir Utilizador</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Inserir Novo Utilizador</h1>

    <form action="index.php?acao=criar" method="POST">

        <label for="utilizador">Nome:</label><br>

        <input
            type="text"
            id="utilizador"
            name="utilizador"
            required
            style="width:50%;"
        >

        <br><br>

        <label for="email">Email:</label><br>

        <input
            type="email"
            id="email"
            name="email"
            required
            style="width:50%;"
        >

        <br><br>

        <label for="palavrachave">Palavra-chave:</label><br>

        <input
            type="password"
            id="palavrachave"
            name="palavrachave"
            required
            style="width:50%;"
        >

        <br><br>

        <button type="submit">Guardar Utilizador</button>

        <a href="index.php">Cancelar</a>
        <button type="reset">Limpar</button>


    </form>

</body>

</html>
<?php

class Utilizador
{
    private $conn;
    private $table_name = "utilizadoress";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($data)
    {
        $query = "INSERT INTO " . $this->table_name . "
                  (nome, email, palavra_chave)
                  VALUES (:nome, :email, :palavra_chave)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':palavra_chave', $data['palavra_chave']);

        return $stmt->execute();
    }
}

?>





   
