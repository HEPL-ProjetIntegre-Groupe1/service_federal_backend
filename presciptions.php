<?php
include 'config.php';

// Fonction pour insérer une prescription
function insertPrescription($conn, $medecin_id, $citoyen_id, $medicament_id, $date_prescription, $description) {
    $sql = "INSERT INTO prescriptions (medecin_id, citoyen_id, medicament_id, date_prescription, description) VALUES ('$medecin_id', '$citoyen_id', '$medicament_id', '$date_prescription', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle prescription ajoutée avec succès<br>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Fonction pour lire toutes les prescriptions
function readPrescriptions($conn) {
    $sql = "SELECT id, medecin_id, citoyen_id, medicament_id, date_prescription, description FROM prescriptions";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Médecin ID: " . $row["medecin_id"]. " - Citoyen ID: " . $row["citoyen_id"]. " - Médicament ID: " . $row["medicament_id"]. " - Date de prescription: " . $row["date_prescription"]. " - Description: " . $row["description"]. "<br>";
        }
    } else {
        echo "Aucune prescription trouvée.<br>";
    }
}

// Fonction pour mettre à jour une prescription
function updatePrescription($conn, $id, $nouveau_medecin_id, $nouveau_citoyen_id, $nouveau_medicament_id, $nouvelle_date_prescription, $nouvelle_description) {
    $sql = "UPDATE prescriptions SET medecin_id='$nouveau_medecin_id', citoyen_id='$nouveau_citoyen_id', medicament_id='$nouveau_medicament_id', date_prescription='$nouvelle_date_prescription', description='$nouvelle_description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Prescription mise à jour avec succès<br>";
    } else {
        echo "Erreur de mise à jour : " . $conn->error . "<br>";
    }
}

// Fonction pour supprimer une prescription
function deletePrescription($conn, $id) {
    $sql = "DELETE FROM prescriptions WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Prescription supprimée avec succès<br>";
    } else {
        echo "Erreur de suppression : " . $conn->error . "<br>";
    }
}

// Exécuter les fonctions en fonction des paramètres GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insertPrescription($conn, $_POST['medecin_id'], $_POST['citoyen_id'], $_POST['medicament_id'], $_POST['date_prescription'], $_POST['description']);
                break;
            case 'update':
                updatePrescription($conn, $_POST['id'], $_POST['medecin_id'], $_POST['citoyen_id'], $_POST['medicament_id'], $_POST['date_prescription'], $_POST['description']);
                break;
            case 'delete':
                deletePrescription($conn, $_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'read') {
    readPrescriptions($conn);
}

$conn->close();
?>
