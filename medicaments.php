<?php
include 'config.php';

// Fonction pour insérer un médicament
function insertMedicament($conn, $nom, $description) {
    $sql = "INSERT INTO medicaments (nom, description) VALUES ('$nom', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouveau médicament ajouté avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire tous les médicaments
function readMedicaments($conn) {
    $sql = "SELECT id, nom, description FROM medicaments";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nom: " . $row["nom"]. " - Description: " . $row["description"]. "<br>";
        }
    } else {
        echo "Aucun médicament trouvé.<br>";
    }
}

// Fonction pour mettre à jour un médicament
function updateMedicament($conn, $id, $nouveau_nom, $nouvelle_description) {
    $sql = "UPDATE medicaments SET nom='$nouveau_nom', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Médicament mis à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer un médicament
function deleteMedicament($conn, $id) {
    $sql = "DELETE FROM medicaments WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Médicament supprimé avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertMedicament($conn, $_POST['nom'], $_POST['description']);
                break;
            case 'update':
                updateMedicament($conn, $_POST['id'], $_POST['nom'], $_POST['description']);
                break;
            case 'delete':
                deleteMedicament($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readMedicaments($conn);
}

$conn->close();
?>
