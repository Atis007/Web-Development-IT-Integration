<footer class="mt-auto py-2 text-center">
    <p><?php echo date("Y"); ?></p>
    <?php
    require __DIR__ . '/../vendor/autoload.php';

    use Detection\MobileDetect;

    $detect = new MobileDetect();

    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

    if ($deviceType === "phone" || $deviceType === "tablet") {
        echo $detect->isAndroidOS() ? "https://www.examples.com/defaultAndroid.apk" : "https://www.examples.com/defaultIos.apk";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</footer>
</body>
</html>