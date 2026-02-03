<?php
$title = "Task7";
$metaDescription = "Bemutatkozó oldal képpel, személyes adatokkal és kedvenc hivatkozásokkal.";
$metaRobots = "index, follow";
include 'includes/header.php';
?>
<table border="1">
    <tr>
        <td><img src="kepek/me.jpg" alt="A picture about me" style="width: 180px; height: auto"></td>
        <td colspan="2"><p>Tóth Attila</p></td>
    </tr>
    <tr>
        <td colspan="1">
            <p>About myself:</p>
            <ul>
                <li>2004</li>
                <li>Zenta</li>
                <li>Đure Đakovića 14</li>
                <li>tothattila5559@gmail.com</li>
                <li><a href="resume.php">My Resume<a></li>
            </ul>
        </td>
        <td colspan="1">
            <h4>My favourite links:</h4>
            <ol start="10">
                <li><a href="https://youtube.com" target="_blank">Youtube</a></li>
                <li><a href="https://udemy.com" target="_blank">Udemy</a></li>
                <li><a href="https://github.com" target="_blank">GitHub</a></li>
            </ol>
        </td>
        <td rowspan="2">
            <h4>What are my strengths?</h4>
            <p>Strengths are things you’re naturally good at. If you’re <b>good</b> at something, you’ll find it easier.
            </p>
            <p>That means you’ll feel <i>more confident</i> and engaged, and <small>you’ll</small> perform better.</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="border-collapse: collapse">
                <thead>
                <tr>
                    <th colspan="2">Confidence
                        <hr>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        Personal development<br>
                        Enthusiasm<br>
                        You’ll learn fast<br>
                        Happiness
                    </td>
                    <td>
                        You learn best in areas where you already have strengths.<br>
                        If something lets you use your strengths, you’ll be keen to do
                        it.<br>
                        You’ll pick tasks up and take in information much quicker if they use your strengths.<br>
                        All these things will help make you happier while you’re at work or school.
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<?php include 'includes/footer.php'; ?>
