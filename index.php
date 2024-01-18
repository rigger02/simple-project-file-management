<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Gambar</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 20px;
        }
        .image-wrapper {
            position: relative;
            width: 200px;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .image-wrapper:hover .image {
            transform: scale(1.1);
        }
        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.6);
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
        }
        .image-container:hover .overlay {
            height: 100%;
        }
        .text {
            color: white;
            font-size: 18px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .delete-button {
            padding: 8px 12px;
            background-color: #ff5858;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
<a href="detail.php?index=0">Tampilan Detail</a>
    <div class="image-container">
        <?php
        $files = glob("./gambar/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        if (empty($files)) {
            echo "<p>Tidak ada gambar.</p>";
        } else {
            echo "<div class='image-container'>";
            foreach ($files as $file) {
                $filename = basename($file);
                echo "
                <div class='image-wrapper'>
                    <img class='image' src='$file' alt='$filename'>
                    <div class='overlay'>
                        <div class='text'>
                            <button class='delete-button' data-filename='$filename'>Hapus</button>
                        </div>
                    </div>
                </div>
                ";
            }
            echo "</div>";
        }
        ?>
    </div>
    <script>
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filename = button.getAttribute('data-filename');
                fetch(`./hapus-gambar.php?filename=${filename}`, { method: 'GET' })
                    .then(() => {
                        button.closest('.image-wrapper').remove();
                    });
            });
        });
    </script>
</body>
</html>
