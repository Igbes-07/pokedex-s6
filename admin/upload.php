<?php
$games = [
    "red" => "Pokémon Rouge",
    "blue" => "Pokémon Bleue",
    "yellow" => "Pokémon Jaune",
    "gold" => "Pokémon Or",
    "silver" => "Pokémon Argent",
    "crystal" => "Pokémon Crystal",
    "ruby" => "Pokémon Rubis",
    "sapphire" => "Pokémon Saphir",
    "emerald" => "Pokémon Émeraude",
    "firered" => "Pokémon Rouge Feu",
    "leafgreen" => "Pokémon Vert Feuille",
    "diamond" => "Pokémon Diamant",
    "pearl" => "Pokémon Perle",
    "platinum" => "Pokémon Platine",
    "heartgold" => "Pokémon Or HeartGold",
    "soulsilver" => "Pokémon Argent SoulSilver",
    "black" => "Pokémon Noire",
    "white" => "Pokémon Blanche",
    "black-2" => "Pokémon Noire 2",
    "white-2" => "Pokémon Blanche 2",
    "x" => "Pokémon X",
    "y" => "Pokémon Y",
    "omega-ruby" => "Pokémon Rubis Oméga",
    "alpha-sapphire" => "Pokémon Saphir Alpha",
    "sun" => "Pokémon Soleil",
    "moon" => "Pokémon Lune",
    "ultra-sun" => "Pokémon Ultra-Soleil",
    "ultra-moon" => "Pokémon Ultra-Lune",
    "sword" => "Pokémon Épée",
    "shield" => "Pokémon Bouclier",
    "scarlet" => "Pokémon Écarlate",
    "violet" => "Pokémon Violet",
    "lets-go-pikachu" => "Pokémon Let's Go Pikachu",
    "lets-go-eevee" => "Pokémon Let's Go Évoli",
    "legends-arceus" => "Légendes Pokémon : Arceus",
];

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game = $_POST['game'] ?? '';
    $file = $_FILES['jaquette'] ?? null;

    if ($file && $game && $file['error'] === 0) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'avif'];

        if (in_array($ext, $allowedExt)) {
            $cleanName = strtolower($game);
            $cleanName = iconv('UTF-8', 'ASCII//TRANSLIT', $cleanName);
            $cleanName = preg_replace('/[^a-z0-9-]/', '-', $cleanName);

            $dest = __DIR__ . "/../jaquettes/{$cleanName}.{$ext}";
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $message = "✅ Jaquette uploadée avec succès : {$cleanName}.{$ext}";
                $messageType = "success";
            } else {
                $message = "❌ Erreur lors de l'upload.";
                $messageType = "error";
            }
        } else {
            $message = "❌ Format non autorisé. JPG, PNG, WEBP ou AVIF uniquement.";
            $messageType = "error";
        }
    } else {
        $message = "❌ Veuillez sélectionner un jeu et une image.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Upload Jaquettes | Pokédex</title>
    <link rel="stylesheet" href="../src/styles/admin.css">
</head>
<body>

    <header>
        <div class="header-inner">
            <h1>Pokédex - Administration</h1>
            <a href="../index.html">← Retour au Pokédex</a>
        </div>
    </header>

    <main>
        <h2>Upload Jaquettes</h2>

        <div class="form-card">
            <?php if ($message): ?>
                <p class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <label for="game">Jeu :</label>
                <select name="game" id="game">
                    <?php foreach ($games as $key => $label): ?>
                        <option value="<?= $key ?>"><?= htmlspecialchars($label) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="jaquette">Image de la jaquette :</label>
                <input type="file" name="jaquette" id="jaquette" accept="image/*">

                <button type="submit">Uploader la jaquette</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-logos">
            <img src="../images/CY_IUT_coul.svg" alt="Logo IUT">
            <img src="../images/CY_Cergy_Paris_Universite_coul.svg" alt="Logo CY Cergy Paris Université">
        </div>
        <p>Année universitaire 2024-2025</p>
    </footer>

</body>
</html>