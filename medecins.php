<?php
header('Content-Type: application/json');
include 'config.php';

// Function to insert a doctor
function insertMedecin($conn, $nom, $prenom, $specialite) {
    $sql = "INSERT INTO medecins (nom, prenom, specialite) VALUES ('$nom', '$prenom', '$specialite')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Nouveau médecin ajouté avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur : " . $sql . " - " . $conn->error]);
    }
}

// Function to read all doctors
function readMedecins($conn) {
    $sql = "SELECT id, nom, prenom, specialite FROM medecins";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $medecins = [];
        while($row = $result->fetch_assoc()) {
            $medecins[] = $row;
        }
        echo json_encode($medecins);
    } else {
        echo json_encode(["message" => "Aucun médecin trouvé"]);
    }
}

// Function to update a doctor
function updateMedecin($conn, $id, $nouveau_nom, $nouveau_prenom, $nouvelle_specialite) {
    $sql = "UPDATE medecins SET nom='$nouveau_nom', prenom='$nouveau_prenom', specialite='$nouvelle_specialite' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Médecin mis à jour avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur de mise à jour : " . $conn->error]);
    }
}

// Function to delete a doctor
function deleteMedecin($conn, $id) {
    $sql = "DELETE FROM medecins WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Médecin supprimé avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur de suppression : " . $conn->error]);
    }
}

// Execute functions based on GET or POST parameters
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
