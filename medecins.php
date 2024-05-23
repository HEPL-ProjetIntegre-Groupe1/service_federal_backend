<?php
include 'config.php';

// Fonction pour insérer un médecin
function insertMedecin($conn, $nom, $prenom, $specialite) {
    $sql = "INSERT INTO medecins (nom, prenom, specialite) VALUES ('$nom', '$prenom', '$specialite')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouveau médecin ajouté avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire tous les médecins
function readMedecins($conn) {
    $sql = "SELECT id, nom, prenom, specialite FROM medecins";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nom: " . $row["nom"]. " - Prénom: " . $row["prenom"]. " - Spécialité: " . $row["specialite"]. "<br>";
        }
    } else {
        echo "Aucun médecin trouvé.<br>";
    }
}

// Fonction pour mettre à jour un médecin
function updateMedecin($conn, $id, $nouveau_nom, $nouveau_prenom, $nouvelle_specialite) {
    $sql = "UPDATE medecins SET nom='$nouveau_nom', prenom='$nouveau_prenom', specialite='$nouvelle_specialite' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Médecin mis à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer un médecin
function deleteMedecin($conn, $id) {
    $sql = "DELETE FROM medecins WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Médecin supprimé avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertMedecin($conn, $_POST['nom'], $_POST['prenom'], $_POST['specialite']);
                break;
            case 'update':
                updateMedecin($conn, $_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['specialite']);
                break;
            case 'delete':
                deleteMedecin($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readMedecins($conn);
}

$conn->close();
?>
