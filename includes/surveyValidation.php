<?php 
session_start();
include "dbh.inc.php";
include "functions.inc.php";
?>
<?php
if (isset($_POST["submit"])) {
    $participantId = $_SESSION["userid"];
    $surveyid = $_POST["survey_id"];
    $answers = $_POST["answers"];
    $questionsIds = $_POST["questionIds"];

    $answers = cleanArray($answers);
    if(checkEmptyArray($answers)) {
        header("Location: ../tasks.php?error=emptyAnswers");
        exit();
    }

    $sql = "INSERT INTO survey_responses(survey_id, participant_id, question_id, response)
    VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $iter = 0;
    foreach($questionsIds as $qId) {
        $stmt->bind_param("iiii", $surveyid, $participantId, $qId, $answers[$iter]);
        $stmt->execute();
        if($stmt === false) {
            die("Server failure");
        }
        $iter++;
    }
    $earnedCoins = addCoins($conn, $participantId, $surveyid);
    $_SESSION["balance"] = $_SESSION["balance"] + $earnedCoins;
    $stmt->close();
    $conn->close();
    header("Location: ../tasks.php?error=none");
    exit();
} else {
    header("Location: ../tasks.php?error=surveyNotSubmitted");
    exit();
}
?>