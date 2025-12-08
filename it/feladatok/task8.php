<?php
$title = "Meta tags, iframe and semantic tags";
include 'includes/header.php';
?>
<header>
    <h1>Welcome to Task 8</h1>
    <p>Semantic HTML, meta tags and embedded videos</p>
</header>
<main>
    <section>
        <table border="1">
            <caption>Contact examples using links</caption>
            <tr>
                <td><a href="tel:+381621234567">Call us: +381 62 123 4567</a></td>
                <td><a href="mailto:info@subtech.edu">Send e-mail: info@subtech.edu</a></td>
            </tr>
            <tr>
                <td><a href="tel:+381631112223">Call support: +381 63 111 2223</a></td>
                <td><a href="mailto:webteam@vts.su.ac.rs">Contact Web Team</a></td>
            </tr>
        </table>
    </section>

    <section>
        <h2>Meta Tags</h2>
        <p>Meta tags are placed inside the <code>&lt;head&gt;</code> section of an HTML document and describe the page’s
            metadata.
            They provide information for browsers and search engines. Examples include:</p>
        <ul>
            <li><code>&lt;meta charset="UTF-8"&gt;</code> – defines character encoding</li>
            <li><code>&lt;meta name="description" content="... "&gt;</code> – short page summary</li>
            <li><code>&lt;meta name="author" content="... "&gt;</code> – author information</li>
            <li><code>&lt;meta name="robots" content="index, follow"&gt;</code> – indexing rules</li>
        </ul>
    </section>

    <section>
        <h2>Embedding Videos with Iframe</h2>
        <p>The <code>&lt;iframe&gt;</code> tag allows embedding external content such as videos.
            Always include the <code>title</code> attribute and use secure links (<code>https://</code>).</p>

        <figure>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/FQdaUv95mR8?si=X9K6WZDlYTN22yek"
                    title="HTML & CSS Basics" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <figcaption>HTML &amp; CSS basics – introduction to web structure.</figcaption>
        </figure>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
