<?php include "header.php" ?>
<link rel="stylesheet" href="cssfolder/tasks.css">
<main>
    <h1>კითხვარები</h1>
<div class = 'rootdiv'>
<?php
if(isset($_SESSION["userid"])){

$userid = $_SESSION["userid"];
$sql = "SELECT * FROM surveys";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $surveyId = $row["id"];
        $prize = $row["coins"];
        $name = $row["survey_name"];
        $image = $row["image"];
        $sqlQuestions = "SELECT * FROM survey_questions WHERE survey_id = ?";
        $stmtQuestions = $conn->prepare($sqlQuestions);
        if ($stmtQuestions) {
            $stmtQuestions->bind_param("i", $surveyId);
            $stmtQuestions->execute();
            $resultQuestions = $stmtQuestions->get_result();
            if ($resultQuestions->num_rows > 0) {
                $sqlResponses = "SELECT * FROM survey_responses WHERE survey_id = ? AND participant_id = ?";
                $stmtResponses = $conn->prepare($sqlResponses);
                if ($stmtResponses) {
                    $stmtResponses->bind_param("ii", $surveyId, $userid);
                    $stmtResponses->execute();
                    $resultResp = $stmtResponses->get_result();
                    if ($resultResp->num_rows === 0) {
                        echo "
                        <a href ='survey.php?survey_id=".$surveyId."'>
                            <div class = 'survey'>
                                <div class = 'surveyDetails'>
                                    <h2>".$name."</h2>
                                    <span>".$prize." ჯიზია</span>
                                </div>
                                <img src='data:image/jpeg;base64," . base64_encode($image) . "'' alt=''>
                                <img class ='arrow' src='images/arrow.png' alt=''>
                            </div>
                        </a>
                        ";
                    }
                    $stmtResponses->close();
                }else {
                    die("Statement Error");
                }
            }
            $stmtQuestions->close();
        }else {
            die("Statement error");
        }
    }
    $stmt->close();
} else {
    die("statement Error");
}
} else {
    header("Location: index.php?error=NotSignedIn");
    exit();
}
?>
</div>
</main>


<script>
    function submitForm() {
        document.getElementById("myForm").submit();
    }
</script>
<?php include "footer.php" ?>