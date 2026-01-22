<?php
require 'includes/config.php';
$title='HomePage';
require 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<div class="main-content div-bottom-border">
    <div class="left-section">
        <h1><i>A holistic way to improving your health.</i></h1>
        <h2>Let us show you how Chinese medicine can help you:</h2>
        <p contenteditable>I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me and you can start adding your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.</p>
        <p contenteditable>This is a great space to write long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are. Tip: Add your own image by double clicking the image and clicking Change Image.</p>
        <p class="doctors">Dr Anne Clarck and Dr. Melisa Goodwin</p>
    </div>
    <div class="right-section">
        <h2>Reservation</h2>
        <?php
        if(isset($_GET['error']))
            echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
        ?>
        <form action="med.php" method="get">
            <label for="firstname">Full Name *</label>
            <div class="name-inputs">
                <input type="text" id="firstname" name="firstname" placeholder="First name" required>
                <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
            </div>

            <label>Free Pickup? *</label>
            <div class="checkbox-group">
                <label>
                    <input type="radio" name="pickup" value="yes"> Yes Please! - Pick me up on arrival
                </label>
                <label>
                    <input type="radio" name="pickup" value="no"> No Thanks - I'll make my own way there
                </label>
            </div>

            <label for="treatments">Treatments *</label>
            <select id="treatments" name="treatments" required>
                <option value="">Select Item</option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][0]) ?>">Acupuncture</option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][1]) ?>">Chinese Herbs</option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][2]) ?>">Nutritional Counseling</option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][3]) ?>">Fertility Counseling </option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][4]) ?>">Massage Therapy</option>
                <option value="<?= htmlspecialchars($GLOBALS['treatments'][5]) ?>">Cupping</option>
            </select>

            <label for="arrival">Arrival Date *</label>
            <input type="date" id="arrival" name="arrival" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>
<?php require 'includes/footer.php'; ?>