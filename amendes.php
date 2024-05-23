<?php
include 'config.php';

// Fonction pour insérer une amende
function insertAmende($conn, $montant, $description, $citoyen_id) {
    $sql = "INSERT INTO amendes (montant, description, citoyen_id) VALUES ('$montant', '$description', '$citoyen_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle amende ajoutée avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire toutes les amendes
function readAmendes($conn) {
    $sql = "SELECT id, montant, description, citoyen_id FROM amendes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Montant: " . $row["montant"]. " - Description: " . $row["description"]. " - Citoyen ID: " . $row["citoyen_id"]. "<br>";
        }
    } else {
        echo "0 résultats<br>";
    }
}

// Fonction pour mettre à jour une amende
function updateAmende($conn, $id, $nouveau_montant, $nouvelle_description) {
    $sql = "UPDATE amendes SET montant='$nouveau_montant', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Amende mise à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer une amende
function deleteAmende($conn, $id) {
    $sql = "DELETE FROM amendes WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Amende supprimée avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
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
