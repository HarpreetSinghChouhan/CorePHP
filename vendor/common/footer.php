</div>
    <footer class="vr-footer">© <?= date('Y') ?> VendorHub. All rights reserved.</footer>
</div>
</div>

<script>
(function () {
    var sb = document.getElementById('vrSidebar'),
        ov = document.getElementById('vrOverlay'),
        bg = document.getElementById('vrBurger');
    if (!sb) return;
    function toggle(open) {
        sb.classList.toggle('open', open);
        ov.classList.toggle('show', open);
    }
    bg.addEventListener('click', function () { toggle(true); });
    ov.addEventListener('click', function () { toggle(false); });
})();
</script>
</body>
</html>