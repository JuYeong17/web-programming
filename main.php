    <div id="springsummmer_content">
    <div id="latest">
                <h4>Spring & Summer</h4>
                <ul>
<!-- 최근 게시 글 DB에서 불러오기 -->
<?php
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from springsummer order by num desc limit 6";
    $result = mysqli_query($con, $sql);

    if (!$result)
        echo "아직 게시글이 없습니다!";
    else
    {
        while( $row = mysqli_fetch_array($result) )
        {
            $regist_day = substr($row["regist_day"], 0, 10);
?>
                <li class="post-item" onclick="location.href='springsummer_view.php?num=<?=$row["num"]?>'">
                    <span><?=$row["subject"]?></span>
                    <span><?=$row["name"]?></span>
                    <span><?=$regist_day?></span>
                </li>
<?php
        }
    }
?>
    </div>
            </div>
         <div id="autumnwinter_content">
        <div id="autumnwinter">
                <h4>Autumn & Winter</h4>
                <ul>
<!-- 최근 게시 글 DB에서 불러오기 -->
<?php
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from autumnwinter order by num desc limit 6";
    $result = mysqli_query($con, $sql);

    if (!$result)
        echo "아직 게시글이 없습니다!";
    else
    {
        while( $row = mysqli_fetch_array($result) )
        {
            $regist_day = substr($row["regist_day"], 0, 10);
?>
        <li class="post-item" onclick="location.href='autumnwinter_view.php?num=<?=$row["num"]?>'">
                    <span><?=$row["subject"]?></span>
                    <span><?=$row["name"]?></span>
                    <span><?=$regist_day?></span>
                </li>
<?php
        }
    }
?>
    </div>
    </div>
            <div id="point_content">
            <div id="point_rank">
                <h4>여행 매니아</h4>
                <ul>
<!-- 포인트 랭킹 표시하기 -->
<?php
    $rank = 1;
    $sql = "SELECT * FROM members WHERE level != 1 ORDER BY point DESC LIMIT 6";    
    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo "아직 가입된 회원이 없습니다!";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $name = $row["name"];
            $id = $row["id"];
            $point = $row["point"];
            $name = mb_substr($name, 0, 1) . " * " . mb_substr($name, 2, 1);
            ?>
            <li>
                <span><?= $rank ?></span>
                <span><?= $name ?></span>
                <span><?= $id ?></span>
                <span><?= $point ?></span>
            </li>
<?php
        $rank++;
    }
}

mysqli_close($con);
?>

</div>
    </ul>

        </div>

