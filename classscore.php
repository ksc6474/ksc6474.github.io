<?php
$link = mysqli_connect("localhost", 'root', '', 'classscore');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $select_child = $_POST['select_child'];
    $select_adult = $_POST['select_adult'];

    $prices = [
        'child' => [7000, 12000, 21000, 70000],
        'adult' => [10000, 16000, 26000, 90000],
    ];

    $total_price = 0;
    $selected_items = [];

    for ($i = 0; $i < 4; $i++) {
        $child_count = isset($select_child[$i]) && $select_child[$i] !== "" ? (int)$select_child[$i] : 0;
        $adult_count = isset($select_adult[$i]) && $select_adult[$i] !== "" ? (int)$select_adult[$i] : 0;

        if ($child_count > 0 || $adult_count > 0) {
            $child_price = $prices['child'][$i];
            $adult_price = $prices['adult'][$i];

            $total_price += ($child_price * $child_count) + ($adult_price * $adult_count);

            $selected_items[] = [
                'child_count' => $child_count,
                'adult_count' => $adult_count
            ];
        }
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
        table { border: 1px solid #000; margin: 0 auto; }
        td, th { border: 1px solid #ccc; }
        a { text-decoration: none; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .total-wrap { text-align: right; margin-top: -20px; margin-right: 30px; }
    </style>
</head>
<body>
<div class="input-wrap">
    <div style="text-align: left; margin-bottom: 10px;">
        <label for="name">고객 성명: </label>
        <input type="text" id="name" name="name" form="mainForm">
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
                $ticket_types = ['입장권', 'BIG3', '자유이용권', '연간이용권'];
                $child_prices = [7000, 12000, 21000, 70000];
                $adult_prices = [10000, 16000, 26000, 90000];
                $remarks = ['입장', '입장+놀이3종', '입장+놀이자유', '입장+놀이자유'];

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
        <div style="text-align: center; margin-top: 20px;">
            <input type="submit" value="합계">
        </div>
    </form>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($name)) {
        // 날짜 및 시간 출력
        date_default_timezone_set('Asia/Seoul');  // 시간대 설정
        $year = date("Y");
        $month = ltrim(date("m"), "0"); 
        $day = ltrim(date("d"), "0");   
        $hour = ltrim(date("h"), "0");  
        $minute = date("i");
        $am_pm = date("A") == "AM" ? "오전" : "오후"; 
        echo "{$year}년도 {$month}월 {$day}일 {$am_pm} {$hour}:{$minute}분<br>";

        echo "{$name} 고객님 감사합니다.<br>";
        foreach ($selected_items as $item) {
            $line = [];
        
            if ($item['child_count'] > 0) {
                $line[] = "어린이 {$item['child_count']}매";
            }
        
            if ($item['adult_count'] > 0) {
                $line[] = "어른 {$item['adult_count']}매";
            }
        
            if (!empty($line)) {
                echo implode(", ", $line) . "<br>";
            }
        }
        echo "합계: " . number_format($total_price) . "원 입니다";
    }
    ?>
</div>
</body>
</html>
