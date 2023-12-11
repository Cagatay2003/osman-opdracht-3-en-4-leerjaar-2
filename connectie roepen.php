
<?php
require_once("databaseconnectie.php");
 
if (isset($_GET['persoonID'])) {
    $persoonID = $_GET['persoonID'];
 
    $sql = "SELECT * FROM personen WHERE persoonID = :persoonID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':persoonID', $persoonID);
    $stmt->execute();
    $person = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $naam = $_POST['naam'];
        $achternaam = $_POST['achternaam'];
        $geboortedatum = $_POST['geboortedatum'];
        $email = $_POST['email'];
        $telefoonnummer = $_POST['telefoonnummer'];
 
        $sql = "UPDATE personen
                SET naam = :naam, achternaam = :achternaam, geboortedatum = :geboortedatum, email = :email, telefoonnummer = :telefoonnummer
                WHERE persoonID = :persoonID";
        $stmt = $pdo->prepare($sql);
 
        $placeholders = [
            ':naam' => $naam,
            ':achternaam' => $achternaam,
            ':geboortedatum' => $geboortedatum,
            ':email' => $email,
            ':telefoonnummer' => $telefoonnummer,
            ':persoonID' => $persoonID
        ];
 
        $stmt->execute($placeholders);
 
        header("Location:pdo_opdracht7.php");
        echo "<h2> Gegevens zijn bijgewerkt.</h2>";
    }
} else {
    echo "Ongeldige persoonID.";
}
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
 
</head>
 
<body>
 
    <?php if (isset($person)): ?>
        <form action="pdo_opdracht7edit.php?persoonID=<?php echo $persoonID; ?>" method="POST">
            <label for="voornaam">Voornaam:</label>
            <input type="text" name="naam" value="<?php echo $person['naam']; ?>" required><br><br>
 
            <label for="achternaam">Achternaam:</label>
            <input type="text" name="achternaam" value="<?php echo $person['achternaam']; ?>" required><br><br>
 
            <label for="geboortedatum">Geboortedatum:</label>
            <input type="date" name="geboortedatum" value="<?php echo $person['geboortedatum']; ?>" required><br><br>
 
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo $person['email']; ?>" required><br><br>
 
            <label for="telefoonnummer">Telefoonnummer:</label>
            <input type="text" name="telefoonnummer" value="<?php echo $person['telefoonnummer']; ?>" required><br><br>
 
            <input type="submit" class="editbutton" value="Edit">
        </form>
    <?php else: ?>
        <p>Geen persoon gevonden met het opgegeven persoonID.</p>
    <?php endif; ?>
</body>
 
</html>