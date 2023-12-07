<?php
$values = [1, 2, 3, 4, 5];

if (isset($_POST['result'])) {
    $result = $_POST['result'];
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Câu hỏi sắp xếp</title>
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

            #left {
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
            <div id="left">
                <?php
                foreach ($values as $value) {
                    echo '<div class="list" draggable="true" data-value="' . $value . '">';
                    echo '<i class="fa fa-list-ul" aria-hidden="true"></i> Item ' . $value;
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <form method="POST">
            <input type="hidden" name="result" id="resultInput" value="">
        </form>
        <script type="text/javascript" src="script.js"></script>
        <script>
            let lists = document.getElementsByClassName("list");
            let left = document.getElementById("left");

            let result = <?php echo json_encode($values); ?>;

            left.addEventListener("dragover", function (e) {
                e.preventDefault();
            });

            left.addEventListener("drop", function (e) {
                let draggedValue = e.dataTransfer.getData("text/plain");
                let draggedIndex = result.indexOf(draggedValue);

                result.splice(draggedIndex, 1);
                result.splice(e.target.dataset.index, 0, draggedValue);
                document.getElementById('resultInput').value = JSON.stringify(result);
                renderLists();
            });

            function renderLists() {
                left.innerHTML = "";
                result.forEach((value, index) => {
                    let listItem = document.createElement("div");
                    listItem.className = "list";
                    listItem.draggable = true;
                    listItem.dataset.index = index;
                    listItem.dataset.value = value;
                    listItem.innerHTML = `<i class="fa fa-list-ul" aria-hidden="true"></i> Item ${value}`;
                    listItem.addEventListener("dragstart", function (e) {
                        e.dataTransfer.setData("text/plain", value);
                    });
                    left.appendChild(listItem);
                });
            }

            renderLists();
        </script>
    </body>

    </html>
    <?php
}
?>