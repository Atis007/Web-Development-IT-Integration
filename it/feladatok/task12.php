<?php
$title = "Task12";
$metaDescription = "Szövegformázási példák CSS-sel, több bekezdésen keresztül.";
$metaRobots = "index, follow";
include "includes/header.php";
?>
<div class="container">

    <h1>CSS Szövegformázási Példa</h1>
    <p>Az alábbi bekezdéseken jól láthatóan érvényesül minden kért szövegformázási tulajdonság.</p>

    <div class="card">
        <h2>Bekezdés 1 – teljes formázás</h2>
        <p class="demo1">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non justo vitae risus bibendum vehicula.
Donec dictum purus id ligula tempor, sed porta arcu porta. Sed viverra, augue eget scelerisque tempor,
            lorem arcu gravida massa, sed accumsan ante lectus eu arcu.
        </p>
    </div>

    <div class="card">
        <h2>Bekezdés 2 – eltérő stílusok</h2>
        <p class="demo2">
Curabitur nec magna quis elit pharetra ultricies. Vestibulum ante ipsum primis in faucibus orci luctus et
            ultrices posuere cubilia curae. Pellentesque at orci eget velit facilisis bibendum eu in mi.
        </p>
    </div>

    <div class="card">
        <h2>Bekezdés 3 – további formázás</h2>
        <p class="demo3">
Suspendisse potenti. Aenean volutpat lorem in mauris facilisis finibus. Maecenas semper, justo sed convallis
            tempor, erat mi gravida velit, id varius sapien urna vitae est.
        </p>
    </div>

</div>
<?php include "includes/footer.php"; ?>
