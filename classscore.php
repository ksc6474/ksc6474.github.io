<?php
// DB 연결
$link = mysqli_connect("localhost", 'root', '', 'classscore');

// 에러 체크
if (!$link) {
    die("MySQL 연결 실패: " . mysqli_connect_error());
}

// 문자셋 설정 (한글 깨짐 방지)
mysqli_set_charset($link, "utf8");

$ticket_types = ['입장권', 'BIG3', '자유이용권', '연간이용권'];
$child_prices = [7000, 12000, 21000, 70000];
$adult_prices = [10000, 16000, 26000, 90000];
$remarks = ['입장', '입장+놀이3종', '입장+놀이자유', '입장+놀이자유'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $select_child = $_POST['select_child'];
    $select_adult = $_POST['select_adult'];

    $total_price = 0;
    $selected_items = [];

    for ($i = 0; $i < 4; $i++) {
        $child_count = isset($select_child[$i]) && $select_child[$i] !== "" ? (int)$select_child[$i] : 0;
        $adult_count = isset($select_adult[$i]) && $select_adult[$i] !== "" ? (int)$select_adult[$i] : 0;

        if ($child_count > 0 || $adult_count > 0) {
            $child_price = $child_prices[$i];
            $adult_price = $adult_prices[$i];

            $total_price += ($child_price * $child_count) + ($adult_price * $adult_count);

            $selected_items[] = [
                'type' => $ticket_types[$i],
                'remark' => $remarks[$i],
                'child_count' => $child_count,
                'adult_count' => $adult_count
            ];

            // DB 저장 (각 행별 저장)
            $stmt = mysqli_prepare($link, "INSERT INTO tickets (customer_name, ticket_type, remarks, child_counts, adult_counts, total_price) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param(
                $stmt,
                "sssssi",
                $name,
                $ticket_types[$i],
                $remarks[$i],
                $child_count,
                $adult_count,
                $total_price
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    if (!empty($selected_items)) {
        $db_message = "<br>DB에 저장되었습니다!";
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>classscore</title>
    <style>
        .input-wrap { width: 960px; margin: 0 auto; }
        h1 { text-align: center; }
        th, td { text-align: center; }
        table { border: 1px solid #000; }
        td, th { border: 1px solid #ccc; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .total-wrap { text-align: right; margin-top: -20px; margin-right: 30px; }
        form#mainForm {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 20px;
        }
        input[type="submit"] {
            height: 40px;
            font-size: 16px;
            padding: 0 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="input-wrap">
    <div style="text-align: left; margin-bottom: 10px;">
        <label for="name">고객 성명: </label>
        <input type="text" id="name" name="name" form="mainForm" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
    </div>
    <form id="mainForm" action="classscore.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>구분</th>
                    <th colspan="2">어린이</th>
                    <th colspan="2">어른</th>
                    <th>비고</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < 4; $i++) {
                    echo "<tr>
                            <td>" . ($i + 1) . "</td>
                            <td>{$ticket_types[$i]}</td>
                            <td>" . number_format($child_prices[$i]) . "</td>
                            <td>
                                <select name='select_child[{$i}]'>
                                    <option value=''>선택</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                </select>
                            </td>
                            <td>" . number_format($adult_prices[$i]) . "</td>
                            <td>
                                <select name='select_adult[{$i}]'>
                                    <option value=''>선택</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                </select>
                            </td>
                            <td>{$remarks[$i]}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <div>
            <input type="submit" value="합계">
        </div>
    </form>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($name)) {
        date_default_timezone_set('Asia/Seoul');
        $year = date("Y");
        $month = ltrim(date("m"), "0"); 
        $day = ltrim(date("d"), "0");   
        $hour = ltrim(date("h"), "0");  
        $minute = date("i");
        $am_pm = date("A") == "AM" ? "오전" : "오후"; 

        echo "<br>{$year}년도 {$month}월 {$day}일 {$am_pm} {$hour}:{$minute}분<br>";
        echo htmlspecialchars($name) . " 고객님 감사합니다.<br><br>";

        foreach ($selected_items as $item) {
            echo "<strong>구분: {$item['type']}</strong> / 비고: {$item['remark']}<br>";
            $line = [];
            if ($item['child_count'] > 0) $line[] = "어린이 {$item['child_count']}매";
            if ($item['adult_count'] > 0) $line[] = "어른 {$item['adult_count']}매";
            echo implode(", ", $line) . "<br><br>";
        }

        echo "<strong>합계: " . number_format($total_price) . "원 입니다</strong>";

        if (isset($db_message)) echo $db_message;
    }
    ?>
</div>
</body>
</html>
