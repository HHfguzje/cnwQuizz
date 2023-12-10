<?php
$values = [1, 2, 3, 4, 5];

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = json_decode($_POST['order'], true);

    // Sắp xếp lại mảng values dựa trên thứ tự mới
    $sortedValues = [];
    foreach ($order as $index) {
        $sortedValues[] = $values[$index];
    }

    // Hiển thị giá trị của mảng values sau khi được sắp xếp lại
    echo "Sorted Values: " . implode(', ', $sortedValues);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
        <input type="submit" value="Submit" id="submitButton">
    </form>
    <script type="text/javascript" src="script.js"></script>
    <script>
        $(function () {
            $("#column").sortable({
                update: function (event, ui) {
                    updateOrder();
                }
            });

            $("#myForm").submit(function (e) {
                e.preventDefault(); // Ngăn chặn việc gửi biểu mẫu theo cách truyền thống
                displaySortedValues();
            });

            function updateOrder() {
                var result = $("#column").sortable("toArray");
                $("#resultInput").val(JSON.stringify(result));
            }

            function displaySortedValues() {
                var result = $("#resultInput").val();
                var sortedValues = JSON.parse(result);

                // In ra giá trị của mảng sau khi được sắp xếp
                console.log("Sorted Values:", sortedValues);

                // Nếu bạn muốn hiển thị trực tiếp trên trang, bạn có thể sử dụng một phần tử HTML để hiển thị
                // Ví dụ: $("#resultDisplay").text("Sorted Values: " + sortedValues.join(', '));
            }
        });
    </script>
    <div id="resultDisplay"></div>

</body>

</html>