<?php
$title = "React bemutatás";
include 'includes/header.php';
?>
<h1><mark>React</mark> – A modern webfejlesztés alapköve</h1>
<div class="card">
<p>
    A <b>React</b> egy <i>nyílt</i> forráskódú <strong>JavaScript</strong> könyvtár, amelyet a <em>Facebook</em> fejlesztett ki.
    Célja a <dfn>felhasználói felületek</dfn> (<abbr title="User Interface">UI</abbr>)
    hatékony és deklaratív módon történő létrehozása. A React segít abban, hogy a fejlesztők
    <small>komponens-alapú</small> gondolkodással építsenek gyors, interaktív és skálázható webalkalmazásokat.
</p>
</div>

<div class="card">
<h2>A React története</h2>
<blockquote>
    The biggest benefit of React is that it changes the way you think about building UIs.
    <cite>— Jordan Walke, a React megalkotója</cite>
</blockquote>
<p>
    Ez az idézet jól szemlélteti, hogy a React nem csupán egy új eszköz volt, hanem
    <ins>forradalmi szemléletváltás</ins> a webfejlesztésben. A korábbi,
    <del>monolitikus</del> megközelítések helyett a React a komponensek
    <strong>újrafelhasználhatóságára</strong> épít, ami mára az egész frontend világ alapelvévé vált.
</p>
</div>

<div class="card">
<h2>A React szerepe napjainkban</h2>
<pre>
    import React from 'react';

    function App() {
    const name = "React";
    return &lt;h1&gt;Hello, {name}!&lt;/h1&gt;;
    }

    export default App;
</pre>
<p>
    A fenti kódrészlet egy egyszerű <code>React</code> komponens, amely
    <code>import</code> segítségével hozza be a React könyvtárat, és egy <code>function</code>
    komponenssel egy üdvözlő üzenetet jelenít meg. A <var>name</var> változó értéke a
    <samp>React</samp>, amit JSX szintaxissal illesztünk be. Ha ezt a kódot egy modern környezetben futtatjuk,
    a böngésző a „<kbd>Hello, React!</kbd>” szöveget jeleníti meg.
</p>
</div>

<div class="card">
<h2>A React alkalmazási területei</h2>
<p>
    A <strong>React</strong>-ot széles körben használják webes és mobilalkalmazások fejlesztésére.
    Néhány jellemző projekt és terület, ahol előszeretettel alkalmazzák:
</p>
<ul>
    <li><em>Facebook</em> és <em>Instagram</em> – a React szülőplatformjai</li>
    <li><b>Netflix</b> – nagy teljesítményű felhasználói felületek</li>
    <li><b>Airbnb</b> – dinamikus komponens-alapú oldalfelépítés</li>
    <li><b>React Native</b> – mobilalkalmazások fejlesztése <sub>iOS</sub> és <sup>Android</sup> platformokra</li>
</ul>
</div>
<hr>

<address>
    Készítette: <strong>Tóth Attila</strong><br>
    <a href="mailto:tothattila5559@gmail.com">Email</a><br>
    <a href="https://github.com/Atis007" target="_blank">GitHub oldal</a>
</address>
<?php include 'includes/footer.php'; ?>