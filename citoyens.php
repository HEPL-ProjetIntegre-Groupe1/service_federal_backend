<?php
include 'config.php';

// Fonction pour insérer un citoyen
function insertCitoyen($conn, $nom, $prenom, $date_naissance, $adresse) {
    $sql = "INSERT INTO citoyens (nom, prenom, date_naissance, adresse) VALUES ('$nom', '$prenom', '$date_naissance', '$adresse')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouveau citoyen ajouté avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire tous les citoyens
function readCitoyens($conn) {
    $sql = "SELECT id, nom, prenom, date_naissance, adresse FROM citoyens";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["i"]. " - Nom: " . $row["nom"]. " " . $row["prenom"]. " - Date de naissance: " . $row["date_naissance"]. " - Adresse: " . $row["adresse"]. "<br>";
        }
    } else {
        echo "0 résultats<br>";
    }
}

// Fonction pour mettre à jour un citoyen
function updateCitoyen($conn, $id, $nouveau_nom, $nouveau_prenom, $nouvelle_date_naissance, $nouvelle_adresse) {
    $sql = "UPDATE citoyens SET nom='$nouveau_nom', prenom='$nouveau_prenom', date_naissance='$nouvelle_date_naissance', adresse='$nouvelle_adresse' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Citoyen mis à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer un citoyen
function deleteCitoyen($conn, $id) {
    $sql = "DELETE FROM citoyens WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Citoyen supprimé avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertCitoyen($conn, $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse']);
                break;
            case 'update':
                updateCitoyen($conn, $_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse']);
                break;
            case 'delete':
                deleteCitoyen($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readCitoyens($conn);
}

$conn->close();


?>
