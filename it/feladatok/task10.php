<?php
$title = "Task10";
include 'includes/header.php';
?>
<style>
    optgroup {
        font-style: italic;
    }

    optgroup option{
        font-style: normal !important;
    }
</style>
<form action="#" method="get" style="margin: 8px 0">
    <fieldset>
        <legend>Personal data</legend>
    <label for="nameInput1">Name: </label>
    <input id="nameInput1" name="nameInput1" type="text">

    <label for="ageInput1">Age: </label>
    <input id="ageInput1" name="ageInput1" type="number" min="0">
    </fieldset>

    <fieldset style="margin-top: 6px">
        <legend>Academic data</legend>
        <label for="degreeInput1">Degree: </label>
        <input id="degreeInput1" name="degreeInput1" type="text">

        <label for="percentageInput1">Percentage: </label>
        <input id="percentageInput1" name="percentageInput1" type="number" min="0">
    </fieldset>

    <button type="submit">Submit</button>
    <div>
        <label for="selectCode">Choose one to start: </label>
        <select id="selectCode" name="selectCode">
            <optgroup label="Web Design">
                <option value="html">HTML</option>
                <option value="css">CSS</option>
            </optgroup>
            <optgroup label="Web Development">
                <option value="javascript">JavaScript</option>
                <option value="python">Python</option>
                <option value="php">PHP</option>
            </optgroup>
        </select>
    </div>
</form>
<?php include 'includes/footer.php'; ?>
