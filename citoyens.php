<?php
header('Content-Type: application/json'); // Set header for JSON output
include 'config.php';

// Fonction pour insérer un citoyen avec mot de passe
function insertCitoyen($conn, $nom, $prenom, $date_naissance, $adresse, $mot_de_passe) {
    // Hasher le mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $sql = "INSERT INTO citoyens (nom, prenom, date_naissance, adresse, mot_de_passe) VALUES ('$nom', '$prenom', '$date_naissance', '$adresse', '$mot_de_passe_hache')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Nouveau citoyen ajouté avec succès"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erreur : " . $sql . " - " . $conn->error));
    }
}

// Fonction pour lire tous les citoyens
function readCitoyens($conn) {
    $sql = "SELECT id, nom, prenom, date_naissance, adresse FROM citoyens";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $citoyens = array();
        while($row = $result->fetch_assoc()) {
            $citoyens[] = $row;
        }
        echo json_encode(array("status" => "success", "data" => $citoyens));
    } else {
        echo json_encode(array("status" => "error", "message" => "0 résultats"));
    }
}

// Fonction pour mettre à jour un citoyen avec mot de passe
function updateCitoyen($conn, $id, $nouveau_nom, $nouveau_prenom, $nouvelle_date_naissance, $nouvelle_adresse, $nouveau_mot_de_passe) {
    // Hasher le nouveau mot de passe si fourni
    $mot_de_passe_hache = '';
    if (!empty($nouveau_mot_de_passe)) {
        $mot_de_passe_hache = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);
    }
    $sql = "UPDATE citoyens SET nom='$nouveau_nom', prenom='$nouveau_prenom', date_naissance='$nouvelle_date_naissance', adresse='$nouvelle_adresse'";
    if (!empty($mot_de_passe_hache)) {
        $sql .= ", mot_de_passe='$mot_de_passe_hache'";
    }
    $sql .= " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Citoyen mis à jour avec succès"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erreur de mise à jour : " . $conn->error));
    }
}

// Fonction pour supprimer un citoyen
function deleteCitoyen($conn, $id) {
    $sql = "DELETE FROM citoyens WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Citoyen supprimé avec succès"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erreur de suppression : " . $conn->error));
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertCitoyen($conn, $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse'], $_POST['mot_de_passe']);
                break;
            case 'update':
                updateCitoyen($conn, $_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse'], $_POST['mot_de_passe']);
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
