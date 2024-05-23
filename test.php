<?php
include 'config.php'; // Assurez-vous d'inclure le fichier de configuration avec la connexion à la base de données

// Requête SQL pour récupérer les données des citoyens
$sql = "SELECT * FROM citoyens";
$result = $conn->query($sql);

// Vérifier s'il y a des données à afficher
if ($result->num_rows > 0) {
    // Afficher les données dans un tableau HTML
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Date de naissance</th>
    <th>Adresse</th>
    </tr>";

    // Parcourir les résultats et afficher chaque citoyen
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["montant"] . "</td>";
        echo "<td>" . $row["decriptions"] . "</td>";
        echo "<td>" . $row["date_naissance"] . "</td>";
        echo "<td>" . $row["adresse"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats"; // Si aucun citoyen n'est trouvé dans la base de données
}

// Fermer la connexion à la base de données
$conn->close();
?>
