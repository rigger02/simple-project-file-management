<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Gambar</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }
        .detail-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .detail-wrapper {
            position: relative;
            width: 400px;
            height: 400px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .detail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nav-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .skip-button, .delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }
        .skip-button {
            background-color: #3498db;
            color: white;
        }
        .delete-button {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <a href="index.php">back</a>
    <?php
    $files = glob("./gambar/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    $currentImage = isset($_GET['index']) && $_GET['index'] < count($files) ? $_GET['index'] : 0;
    $filename = !empty($files) ? basename($files[$currentImage]) : "Tidak Ada Gambar";
    ?>

    <div class="detail-container">
        <?php if (!empty($files)): ?>
            <div class="detail-wrapper">
                <img class="detail-image" src="./gambar/<?= $filename ?>" alt="<?= $filename ?>">
            </div>
        <?php else: ?>
            <p>Tidak ada gambar.</p>
        <?php endif; ?>
        <div class="nav-buttons">
            <?php if (!empty($files)): ?>
                <a class="skip-button" href="detail.php?index=<?= ($currentImage - 1 + count($files)) % count($files) ?>">Previous</a>
                <a class="skip-button" href="detail.php?index=<?= ($currentImage + 1) % count($files) ?>">Skip</a>
                <span>Urutan Gambar: <?= $currentImage + 1 ?> dari <?= count($files) ?></span>
                <button class="delete-button" data-filename="<?= $filename ?>">Delete</button>
            <?php endif; ?>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButton = document.querySelector('.delete-button');

        if (deleteButton) {
            const currentImage = <?= $currentImage ?>;
            const filesCount = <?= count($files) ?>;

            deleteButton.addEventListener('click', function() {
                const filename = deleteButton.getAttribute('data-filename');
                fetch(`./hapus-gambar.php?filename=${filename}`, { method: 'GET' })
                    .then(() => {
                        window.location.href = `detail.php?index=${(currentImage) % filesCount}`;
                    });
            });
        }
    });
</script>

</html>
