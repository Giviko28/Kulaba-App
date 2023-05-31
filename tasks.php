<?php include "header.php" ?>
<link rel="stylesheet" href="cssfolder/tasks.css">
<main>
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
                        <form action='survey.php' method='POST'>
                            <img src='images/surv.png' alt=''>
                            <input type='hidden' name='survey_id' value='$surveyId'>
                            <input type='submit' name='submit' value='Take survey'>
                        </form>
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
</main>

<?php include "footer.php" ?>