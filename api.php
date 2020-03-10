<?php

$conn = new mysqli('localhost', 'root', 'symee@2018', 'api_2sow');

if ($conn->connect_error)
{
    die('Erro, Falha na conexão com o banco de dados.');
}

// $res = ['error' => false];
$action = 'read';

if (isset($_GET['action']))
{
    $action = $_GET['action'];
}

// read
if ($action == 'read')
{
    $sql = "SELECT ci.id, ci.name, ci.surname, ci.cpf, co.id_citizen, 
                   co.phone, co.email, co.cellphone, 
                   ad.zipcode, ad.logradouro, ad.neighborhood, ad.city, ad.state
            FROM citizen ci
            LEFT JOIN contact co ON co.id_citizen = ci.id
            LEFT JOIN address ad ON ad.id_citizen = ci.id
            ORDER BY ci.name ASC";
    
    $result = $conn->query($sql);
    $citizens = [];

    while ($row = $result->fetch_assoc()) {
        array_push($citizens, $row);
    }

    $res['citizens'] = $citizens;
}

// create
if ($action == 'create')
{
    $cpf = $_POST['cpf'];

    $sql = "SELECT cpf FROM citizen WHERE cpf = '$cpf'";
    $sql = $conn->query($sql);
    $row = $sql->fetch_assoc();

    if ($row['cpf'] === $cpf) {
        $res['error'] = true;
        $res['message'] = 'CPF já está registrado no banco de dados';
    } else {
        // tb-citizen
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        $res_citizen = $conn->query("INSERT INTO citizen (name, surname, cpf) VALUES ('$name', '$surname', '$cpf')");
        
        $sql_citizen = "SELECT MAX(id) AS id FROM citizen";
        $sql_citizen = $conn->query($sql_citizen);
        $citizen = $sql_citizen->fetch_assoc();
        
        // tb-contact
        $id_citizen = $citizen['id']; 
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $cellphone = $_POST['cellphone'];
        
        $res_contact = $conn->query("INSERT INTO contact (id_citizen, phone, email, cellphone) VALUES ('$id_citizen', '$phone', '$email', '$cellphone')");
        
        // tb-address
        $zipcode = $_POST['zipcode'];
        $logradouro = $_POST['logradouro'];
        $neighborhood = $_POST['neighborhood'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        
        $res_address = $conn->query("INSERT INTO address (id_citizen, zipcode, logradouro, neighborhood, city, state) VALUES ('$id_citizen', '$zipcode', '$logradouro', '$neighborhood', '$city', '$state')");
        
        if ($res_citizen) {
            $res['message'] = 'Registro criado com sucesso';
        } else {
            $res['error'] = true;
            $res['message'] = 'Erro ao tentar criar o registro, tente novamente mais tarde';
        }
    }
}

// update
if ($action == 'update')
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $cpf = $_POST['cpf'];

    $res_citizen = $conn->query("UPDATE citizen SET name = '$name', surname = '$surname', cpf = '$cpf' WHERE id = '$id'");
    $id_citizen = $id;

    // tb-contact
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];

    $res_contact = $conn->query("UPDATE contact SET phone = '$phone', email = '$email', cellphone = '$cellphone' WHERE id_citizen = '$id_citizen'");

    // tb-address
    $zipcode = $_POST['zipcode'];
    $logradouro = $_POST['logradouro'];
    $neighborhood = $_POST['neighborhood'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    $res_address = $conn->query("UPDATE address SET zipcode = '$zipcode', logradouro = '$logradouro', neighborhood = '$neighborhood', city = '$city', state = '$state' WHERE id_citizen = '$id_citizen'");  

    if ($res_citizen || $res_contact || $res_address) {
        $res['message'] = 'Registro atualizado com sucesso';
    } else {
        $res['error'] = true;
        $res['message'] = 'Erro ao tentar atualizar o registro, tente novamente mais tarde';
    }
}

// delete
if ($action == 'delete')
{
    $id = $_POST['id'];
    $result = $conn->query("DELETE FROM citizen WHERE id = '$id'");

    if ($result) {
        $res['message'] = 'Registro excluido com sucesso';
    } else {
        $res['error'] = true;
        $res['message'] = 'Erro ao tentar excluir o registro, tente novamente mais tarde';
    }
}

$conn->close();
header("Content-type: application/json");
echo json_encode($res);
exit;
