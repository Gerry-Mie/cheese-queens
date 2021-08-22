<style>
    .q {
        background-color: #ddd;
        border-color: #aaa;
        color: blue;
    }

    .box {
        width: 400px;
        margin: auto;
        border: 1px solid #333;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>
<div class="box">
    <form method="POST">


        <h3>Position of first queen</h3>
        <label for="row">row</label>
        <input required type="number" max="7" min="0" id="row" name="row" value="<?php if (isset($_POST["row"])) echo $_POST["row"] ?>">
        <br>
        <label for="col">col</label>
        <input max="7" min="0" required type="number" id="col" name="col" value="<?php if (isset($_POST["col"])) echo $_POST["col"] ?>">
        <hr>
        <label for="nq">number of queen to add</label>
        <input max="7" min="1" required type="number" id="nq" name="nq" value="<?php if (isset($_POST["nq"])) echo $_POST["nq"] ?>">
        <input type="submit" value="submit">

    </form>

    <div class="btn-grp">

        <?php




        function checkRow($row, $array)
        {
            return in_array(1, $array[$row]);
        }

        function checkCol($col, $array)
        {
            for ($row = 0; $row < 8; $row++) {
                if ($array[$row][$col] == 1) {
                    return true;
                }
            }
            return false;
        }


        function checkVertical($row, $col, $array)
        {
            $r = max(0, $row - $col);
            $c = max(0,  $col - $row);

            for ($i = $r; $i < 8; $i++) {

                $cl = ($i - $r) + $c;

                if ($cl < 8 and $array[$i][$cl] == 1) {
                    return  true;
                }
            }
            $r = min(7, $row + $col);
            $c = max(0, $row + $col - 7);

            for ($i = $r; $i >= 0; $i--) {

                $cl = ($r - $i) + $c;

                if ($cl < 8 and $array[$i][$cl] == 1) {
                    return  true;
                }
            }
            return false;
        }

        function isSafe($row, $col, $array)
        {
            return !(checkRow($row, $array) || checkCol($col, $array) || checkVertical($row, $col, $array));
        }



        function addQueens($index, $q, $array)
        {
            if ($q == $_POST['nq']) return $array;
            if ($index == 8) return false;

            $safe = array();
            for ($i = 0; $i < 8; $i++) {
                if (isSafe($index, $i, $array)) {
                    $safe[] = $i;
                }
            }


            foreach ($safe as $col) {
                $array[$index][$col] = 1;
                $result = addQueens($index + 1, $q + 1, $array);
                if ($result) return  $result;
                $array[$index][$col] = 0;
            }

            return addQueens($index + 1, $q, $array);
        }




        if (isset($_POST["row"]) and isset($_POST['col']) and isset($_POST['nq'])) {
            $row = $_POST["row"];
            $col = $_POST['col'];

            $board = array();
            if ($row > 7 or $row < 0 or $col > 7 or $col < 0) exit();

            for ($i = 0; $i < 8; $i++) {
                $row_arr = array();
                for ($j = 0; $j < 8; $j++) {
                    $row_arr[] = 0;
                }
                $board[] = $row_arr;
            }

            $board[$row][$col] = 1;


            $result = addQueens(0, 0, $board);
            if ($result) {

                foreach ($result as $board_row) {
                    foreach ($board_row as $rowIndex) {
                        if ($rowIndex == 1) echo "<button class='q'>$rowIndex</button>";
                        else  echo "<button>$rowIndex</button>";
                    }
                    echo "<br>";
                }
            } else {
                echo " <h1>can't add " . $_POST['nq'] . " queens</h1>";
                var_dump($result);
            }
        }
        ?>

    </div>
</div>