<?php
include 'config.php';

// Fonction pour insérer un impôt
function insertImpot($conn, $montant, $description, $citoyen_id) {
    $sql = "INSERT INTO impots (montant, description, citoyen_id) VALUES ('$montant', '$description', '$citoyen_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvel impôt ajouté avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire tous les impôts
function readImpots($conn) {
    $sql = "SELECT id, montant, description, citoyen_id FROM impots";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Montant: " . $row["montant"]. " - Description: " . $row["description"]. " - Citoyen ID: " . $row["citoyen_id"]. "<br>";
        }
    } else {
        echo "Aucun impôt trouvé.<br>";
    }
}

// Fonction pour mettre à jour un impôt
function updateImpot($conn, $id, $nouveau_montant, $nouvelle_description) {
    $sql = "UPDATE impots SET montant='$nouveau_montant', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Impôt mis à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer un impôt
function deleteImpot($conn, $id) {
    $sql = "DELETE FROM impots WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Impôt supprimé avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
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
