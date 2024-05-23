<?php
header('Content-Type: application/json');
include 'config.php';

// Function to insert a fine
function insertAmende($conn, $montant, $description, $citoyen_id) {
    $sql = "INSERT INTO amendes (montant, description, citoyen_id) VALUES ('$montant', '$description', '$citoyen_id')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Nouvelle amende ajoutée avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur : " . $sql . " - " . $conn->error]);
    }
}

// Function to read all fines
function readAmendes($conn) {
    $sql = "SELECT id, montant, description, citoyen_id FROM amendes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $amendes = [];
        while($row = $result->fetch_assoc()) {
            $amendes[] = $row;
        }
        echo json_encode($amendes);
    } else {
        echo json_encode(["message" => "0 résultats"]);
    }
}

// Function to update a fine
function updateAmende($conn, $id, $nouveau_montant, $nouvelle_description) {
    $sql = "UPDATE amendes SET montant='$nouveau_montant', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Amende mise à jour avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur de mise à jour : " . $conn->error]);
    }
}

// Function to delete a fine
function deleteAmende($conn, $id) {
    $sql = "DELETE FROM amendes WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Amende supprimée avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur de suppression : " . $conn->error]);
    }
}

// Execute functions based on GET or POST parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertAmende($conn, $_POST['montant'], $_POST['description'], $_POST['citoyen_id']);
                break;
            case 'update':
                updateAmende($conn, $_POST['id'], $_POST['montant'], $_POST['description']);
                break;
            case 'delete':
                deleteAmende($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readAmendes($conn);
}

$conn->close();
?>
