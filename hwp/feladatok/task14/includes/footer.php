</div>
<footer class="mt-auto py-2 text-center">
    <p><?php echo date("Y"); ?></p>
    <script>
        let serverTime = new Date("<?= date('Y-m-d H:i:s') ?>".replace(' ', 'T'));

        function pad(n) {
            return n < 10 ? '0' + n : n;
        }

        function updateClock() {
            serverTime.setSeconds(serverTime.getSeconds() + 1);

            const h = pad(serverTime.getHours());
            const m = pad(serverTime.getMinutes());
            const s = pad(serverTime.getSeconds());

            document.getElementById('clock').innerText = `${h}:${m}:${s}`;
        }

        updateClock();

        setInterval(updateClock, 1000)
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</footer>
</body>
</html>