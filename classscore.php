<?php
$link = mysqli_connect("localhost", 'root', '', 'classscore');
$_GET['order'] = isset($order) ? $_GET['order'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 고객 성명과 선택한 입장권 수량을 가져옴
    $name = $_POST['name'];
    $select_child = $_POST['select_child'];
    $select_adult = $_POST['select_adult'];
    
    // 가격 설정
    $prices = [
        'child' => [7000, 12000, 21000, 70000],  // 어린이 가격
        'adult' => [10000, 16000, 26000, 90000], // 어른 가격
    ];

    // 선택된 항목에 따른 가격 계산
    $child_price = $prices['child'][$select_child - 1];
    $adult_price = $prices['adult'][$select_adult - 1];
    
    // 합계 계산
    $total_price = ($child_price * $select_child) + ($adult_price * $select_adult);
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>classscore</title>
    <style>
        .input-wrap {
            width: 960px;
            margin: 0 auto;
        }
        h1 { text-align: center; }
        th, td { text-align: center; }
        table {
            border: 1px solid #000;
            margin: 0 auto;
        }
        td, th {
            border: 1px solid #ccc;
        }
        a { text-decoration: none; }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .total-wrap {
            text-align: right;
            margin-top: -20px;
            margin-right: 30px;
        }
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
                    <tr>
                        <td>1</td>
                        <td>어린이 입장권</td>
                        <td>7,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_child">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>10,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_adult">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>입장</td>
                    </tr>
                    <tr>
                    <td>2</td>
                        <td>어린이 BIG3</td>
                        <td>12,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_child">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>16,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_adult">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>입장+놀이3종</td>
                    </tr>
                    <tr>
                    <td>3</td>
                        <td>어린이 자유이용권</td>
                        <td>21,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_child">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>26,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_adult">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>입장+놀이자유</td>
                    </tr>
                    <tr>
                    <td>4</td>
                        <td>어린이 연간이용권</td>
                        <td>70,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_child">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>90,000</td>
                        <td>
                            <div style="text-align: center;">
                                <select name="select_adult">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </td>
                        <td>입장+놀이자유</td>
                    </tr>
                </tbody>
            </table>
            <div class="total-wrap">
                <?php 
                if (isset($name)) {
                    echo "{$name} 고객님 감사합니다. 어린이 {$select_child}매 어른 {$select_adult}매 합계: " . number_format($total_price) . "원 입니다.";
                }
                ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <input type="submit" value="합계">
            </div>
        </form>
        
        <?php 
        $year = date("Y");
        $month = ltrim(date("m"), "0"); 
        $day = ltrim(date("d"), "0");   
        $hour = ltrim(date("h"), "0");  
        $minute = date("i");
        $am_pm = date("A") == "AM" ? "오전" : "오후"; 
        echo "{$year}년도 {$month}월 {$day}일 {$am_pm} {$hour}:{$minute}분";
        ?>
    </div>
</body>
</html>
