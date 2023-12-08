<?php
$values = [1, 2, 3, 4, 5];

if (isset($_POST['result'])) {
    $result = json_decode($_POST['result'], true);

    $sortedValues = [];
    foreach ($result as $index) {
        $sortedValues[] = $values[$index];
    }

    echo "<pre>";
    print_r($sortedValues);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #column {
            width: 300px;
            min-height: 400px;
            margin: 20px;
            border: solid 2px #ccc;
        }

        .list {
            background: blue;
            height: 40px;
            margin: 30px;
            color: #fff;
            display: flex;
            align-items: center;
            cursor: grab;
        }

        .list i {
            margin-right: 15px;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="column">
            <?php
            foreach ($values as $index => $value) {
                echo '<div class="list" draggable="true" data-index="' . $index . '">';
                echo '<i class="fa fa-list-ul" aria-hidden="true"></i> Item ' . $value;
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <form method="POST" id="myForm">
        <input type="hidden" name="result" id="resultInput" value="">
    </form>
    <script type="text/javascript" src="script.js"></script>
    <script>
        let column = document.getElementById("column");
        let result = <?php echo json_encode(array_keys($values)); ?>;

        column.addEventListener("dragover", function (e) {
            e.preventDefault();
        });

        column.addEventListener("drop", function (e) {
            let draggedIndex = parseInt(e.dataTransfer.getData("text/plain"));
            let draggedValue = result[draggedIndex];

            result.splice(draggedIndex, 1);
            result.splice(e.target.dataset.index, 0, draggedValue);
            document.getElementById('resultInput').value = JSON.stringify(result);
            renderLists();
            document.getElementById('myForm').submit();
        });

        function renderLists() {
            column.innerHTML = "";
            result.forEach((value, index) => {
                let listItem = document.createElement("div");
                listItem.className = "list";
                listItem.draggable = true;
                listItem.dataset.index = index;
                listItem.innerHTML = `<i class="fa fa-list-ul" aria-hidden="true"></i> Item ${value}`;
                listItem.addEventListener("dragstart", function (e) {
                    e.dataTransfer.setData("text/plain", index);
                });
                column.appendChild(listItem);
            });
        }

        renderLists();
    </script>
</body>

</html>