<?php

require "config.php";

$rota = $_GET["rota"] ?? "teste";

function teste() {
    echo "API respondendo com sucesso!";
}

function listarClientes($con) {
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM Clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function adicionarCliente($con) {
    $nome = $_POST["Nome"] ?? "";
    $email = $_POST["Email"] ?? "";
    $telefone = $_POST["Telefone"] ?? "";
    $endereco = $_POST["Endereco"] ?? "";

    try {

        $stmt = $con->prepare(
            "INSERT INTO Clientes (Nome, Email, Telefone, Endereco)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->execute([
            $nome,
            $email,
            $telefone,
            $endereco
        ]);

        header("Content-Type: application/json; charset=utf-8");

        echo json_encode([
            "mensagem" => "Cliente cadastrado com sucesso!"
        ]);

    } catch (PDOException $e) {

        header("Content-Type: application/json; charset=utf-8");

        echo json_encode([
            "erro" => "Erro ao cadastrar cliente"
        ]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $rota === "clientes/create") {

    adicionarCliente($con);

} elseif ($_SERVER["REQUEST_METHOD"] === "GET" && $rota === "clientes") {

    listarClientes($con);

} else {

    teste();
}

?>