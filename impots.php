<?php
include 'config.php';

// Set header to output JSON content
header('Content-Type: application/json');

// Fonction pour insérer un impôt
function insertImpot($conn, $montant, $description, $citoyen_id) {
    $response = array();
    $sql = "INSERT INTO impots (montant, description, citoyen_id) VALUES ('$montant', '$description', '$citoyen_id')";
    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Nouvel impôt ajouté avec succès';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erreur: ' . $conn->error;
    }
    echo json_encode($response);
}

// Fonction pour lire tous les impôts
function readImpots($conn) {
    $response = array();
    $sql = "SELECT id, montant, description, citoyen_id FROM impots";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response['status'] = 'success';
        $response['data'] = array();
        while($row = $result->fetch_assoc()) {
            $response['data'][] = $row;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Aucun impôt trouvé';
    }
    echo json_encode($response);
}

// Fonction pour mettre à jour un impôt
function updateImpot($conn, $id, $nouveau_montant, $nouvelle_description) {
    $response = array();
    $sql = "UPDATE impots SET montant='$nouveau_montant', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Impôt mis à jour avec succès';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erreur de mise à jour: ' . $conn->error;
    }
    echo json_encode($response);
}

// Fonction pour supprimer un impôt
function deleteImpot($conn, $id) {
    $response = array();
    $sql = "DELETE FROM impots WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Impôt supprimé avec succès';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erreur de suppression: ' . $conn->error;
    }
    echo json_encode($response);
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertImpot($conn, $_POST['montant'], $_POST['description'], $_POST['citoyen_id']);
                break;
            case 'update':
                updateImpot($conn, $_POST['id'], $_POST['montant'], $_POST['description']);
                break;
            case 'delete':
                deleteImpot($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readImpots($conn);
}

$conn->close();
?>
