<?php
include 'config.php';

// Fonction pour récupérer les données d'une table et les stocker dans un tableau
function fetchTableData($conn, $tableamendes) {
    $sql = "SELECT * FROM $tableamendes";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Récupérer les données de chaque table
$citoyens = fetchTableData($conn, 'citoyens');
$impots = fetchTableData($conn, 'impots');
$amendes = fetchTableData($conn, 'amendes');
$medecins = fetchTableData($conn, 'medecins');
$medicaments = fetchTableData($conn, 'medicaments');
$prescriptions = fetchTableData($conn, 'prescriptions');

// Créer un tableau associatif contenant les données de toutes les tables
$data = array(
    'citoyens' => $citoyens,
    'impots' => $impots,
    'amendes' => $amendes,
    'medecins' => $medecins,
    'medicaments' => $medicaments,
    'prescriptions' => $prescriptions
);

// Convertir le tableau en JSON
$jsonData = json_encode($data, JSON_PRETTY_PRINT);

// Écrire les données JSON dans un fichier
$file = 'data.json';
file_put_contents($file, $jsonData);

echo "Le fichier JSON a été créé avec succès.";
?>
