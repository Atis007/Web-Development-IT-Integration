<?php
$title = "Task9";
include 'includes/header.php';
?>
<style>
    .container{
        display: flex;
        flex-direction: column;
    }
</style>
<form action="#" method="get" style="margin: 8px 0">
    <label for="nameInput1">Name: </label>
    <input id="nameInput1" name="nameInput1" type="text">

    <label for="ageInput1">Age: </label>
    <input id="ageInput1" name="ageInput1" type="number" min="0">

    <button type="submit">Submit</button>
</form>

<hr>

<form action="#" method="post" enctype="multipart/form-data" style="margin: 8px 0;" class="container">
    <label for="nameInput2">Name: </label>
    <input id="nameInput2" name="nameInput2" type="text">

    <label for="ageInput2">Age: </label>
    <input id="ageInput2" name="ageInput2" type="number" min="0">

    <label for="emailInput1">Email: </label>
    <input id="emailInput1" name="emailInput1" type="email">

    <label for="passwordInput1">Password: </label>
    <input id="passwordInput1" name="passwordInput1" type="password">

    <label for="documentUpload">Id proof: </label>
    <input type="file" id="documentUpload" name="documents" accept=".pdf, .doc, .docx" multiple>

    <button type="submit" style="margin-top: 8px; max-width: 100px">Submit</button>
</form>

<hr>

<form action="#" method="post" style="margin: 8px 0;" class="container">
    <label for="textarea">Feedback:</label>
    <textarea id="textarea" rows="5" cols="40"></textarea>
    
    <button type="submit" style="margin-top: 8px; max-width: 100px">Submit</button>
</form>
<?php include 'includes/footer.php'; ?>
