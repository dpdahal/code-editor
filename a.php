<?php
$files = ['home.php', 'about.php', 'contact.php'];

$selected_file = isset($_POST['file']) && in_array($_POST['file'], $files) ? $_POST['file'] : 'about.php';
$filename = $selected_file;

$code = file_exists($filename) ? file_get_contents($filename) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Code Editor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
        }
        .CodeMirror {
            border: 1px solid #ddd;
            height: auto;
            max-height: 500px;
        }
    </style>
</head>
<body>

<h1>Live Code Editor</h1>

<form method="POST" id="fileSelectForm">
    <label for="file">Select File:</label>
    <select name="file" id="file" onchange="document.getElementById('fileSelectForm').submit();">
        <?php foreach ($files as $file): ?>
            <option value="<?php echo $file; ?>" <?php echo ($file == $selected_file) ? 'selected' : ''; ?>>
                <?php echo ucfirst(basename($file, '.php')); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>



<textarea id="code" name="code"><?php echo htmlspecialchars($code); ?></textarea>

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            mode: "text/html",
            theme: "default"
        });

        setInterval(function () {
            var code = editor.getValue();
            fetch('save.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'code=' + encodeURIComponent(code) + '&file=' + encodeURIComponent("<?php echo $selected_file; ?>")
            }).then(response => {
                if (response.ok) {
                    console.log("Auto-saved successfully.");
                }
            }).catch(error => console.error('Error:', error));
        }, 2000);
    });
</script>

</body>
</html>
