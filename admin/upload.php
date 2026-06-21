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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game = $_POST['game'] ?? '';
    $file = $_FILES['jaquette'] ?? null;

    if ($file && $game && $file['error'] === 0) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowedExt)) {
            // Sanitize le nom
            $cleanName = strtolower($game);
            $cleanName = iconv('UTF-8', 'ASCII//TRANSLIT', $cleanName);
            $cleanName = preg_replace('/[^a-z0-9-]/', '-', $cleanName);

            $dest = __DIR__ . "/../jaquettes/{$cleanName}.{$ext}";
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $message = "✅ Jaquette uploadée : {$cleanName}.{$ext}";
            } else {
                $message = "❌ Erreur lors de l'upload.";
            }
        } else {
            $message = "❌ Format non autorisé. JPG, PNG ou WEBP uniquement.";
        }
    } else {
        $message = "❌ Veuillez sélectionner un jeu et une image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Upload Jaquettes</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 0 20px; }
        h1 { font-size: 24px; }
        select, input, button { display: block; width: 100%; margin: 10px 0; padding: 8px; font-size: 16px; }
        button { background: #0f172a; color: white; border: none; cursor: pointer; border-radius: 6px; }
        button:hover { background: #1e293b; }
        .message { padding: 10px; border-radius: 6px; margin: 10px 0; background: #f0fdf4; }
    </style>
</head>
<body>
    <h1>Upload Jaquettes</h1>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Jeu :</label>
        <select name="game">
            <?php foreach ($games as $key => $label): ?>
                <option value="<?= $key ?>"><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Image de la jaquette :</label>
        <input type="file" name="jaquette" accept="image/*">

        <button type="submit">Uploader</button>
    </form>
</body>
</html>
