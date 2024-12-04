<!-- Dynamic Year Functionality -->
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentYear = new Date().getFullYear();
            document.getElementById('copyright').innerHTML = `&copy; ${currentYear} Retro Recipes`;
        });
</script>
<footer class="footer custom-bg text-white">
    <div class="container d-flex align-items-center justify-content-center position-relative">
        <!-- Copyright -->
        <p id="copyright" class="m-0"></p>
    </div>
</footer>