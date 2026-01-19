<h1><?= htmlspecialchars($title ?? '') ?></h1>

<p>This is a minimal MVC example with routing and PDO.</p>

<h3>Try these routes:</h3>
<ul>
    <li><code><?= htmlspecialchars(url('home/index')) ?></code></li>
    <li><code><?= htmlspecialchars(url('book/index')) ?></code></li>
    <li><code><?= htmlspecialchars(url('book/show/1')) ?></code></li>
    <li><code><?= htmlspecialchars(url('book/create')) ?></code> (GET form)</li>
    <li><code><?= htmlspecialchars(url('book/store')) ?></code> (POST insert)</li>
</ul>

<p>
    The request flow is:
    <code>.htaccess → public/index.php → Router → Controller → Model (PDO) → View</code>
</p>

<p>
    If your project is hosted in a subfolder, set <code>base_path</code> in <code>config/config.php</code>.
</p>
