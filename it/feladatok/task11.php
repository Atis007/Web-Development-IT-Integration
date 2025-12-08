<?php
$title = "Task11";
include 'includes/header.php';
?>

<table border="1" width="100%" cellspacing="0" cellpadding="10">

    <!-- 1. sor – kép, colspan=3 -->
    <tr>
        <td colspan="3" align="center">
            <img src="kepek/html.jpg"
                 alt="Banner Image"
                 width="100%">
        </td>
    </tr>

    <!-- 2. sor – 3 cella -->
    <tr>

        <!-- 1. cella – nested list -->
        <td width="33%">
            <h3>Nested List</h3>
            <ul>
                <li>Frontend Technologies
                    <ul>
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>JavaScript</li>
                    </ul>
                </li>

                <li>Backend Technologies
                    <ul>
                        <li>PHP</li>
                        <li>Node.js</li>
                    </ul>
                </li>
            </ul>
        </td>

        <!-- 2. cella – form -->
        <td width="33%">
            <h3>Registration Form</h3>

            <form action="#" method="get">

                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name"><br><br>

                <label for="course">Select Course:</label><br>
                <select id="course" name="course">
                    <option value="html">HTML Basics</option>
                    <option value="css">CSS Styling</option>
                    <option value="js">JavaScript Intro</option>
                </select><br><br>

                <p>Preferred Mode:</p>
                <input type="radio" id="online" name="mode" value="online">
                <label for="online">Online</label><br>

                <input type="radio" id="onsite" name="mode" value="onsite">
                <label for="onsite">Onsite</label><br><br>

                <button type="submit">Submit</button>
            </form>
        </td>

        <!-- 3. cella – YouTube iframe -->
        <td width="33%">
            <h3>YouTube Video</h3>

            <iframe width="100%" height="250"
                    src="https://www.youtube.com/embed/UB1O30fR-EE"
                    title="HTML Tutorial"
                    frameborder="0"
                    allowfullscreen>
            </iframe>
        </td>

    </tr>
</table>
<?php include 'includes/footer.php'; ?>
