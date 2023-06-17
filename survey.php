<?php include "header.php"?>
<style>
    form {
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        padding-top:5vh;
    }
    form div {
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;

    }
    form input {
    }
    form button {
        margin-top:2vh;
    }

</style>
<main>
<?php 

echo '<form action="includes/surveyValidation.php" method = "POST">';

$rowCount = 0;
if(isset($_GET["survey_id"])) {
    $surveyId = $_GET["survey_id"];
    $sql = "SELECT * FROM survey_questions WHERE survey_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $surveyId);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $questionId = $row["id"];
        $question = $row["question"];
        echo '
        <div>
            <span>'.$question.'</span>
            <input type="hidden" name="questionIds[]" value="'.$questionId.'">
            <select name="answers[]" required >
                <option value="" disabled selected>აირჩიე</option>
                <option value="1">ვემხრობი</option>
                <option value="2">ნაკლებად ვემხრობი</option>
                <option value="3">არცერთი</option>
                <option value="4">ნაკლებად არ ვემხრობი</option>
                <option value="5">არ ვემხრობი</option>
            </select>
        </div>
       ';
    }
} else {
    header("Location: tasks.php?error=invalidSurvey");
    exit();
}

echo "
<input type='hidden' name ='survey_id' value = '{$_GET['survey_id']}'>
<button type ='submit' name = 'submit'>GO</button>
</form>
";
?>
</main>
<?php include "footer.php" ?>