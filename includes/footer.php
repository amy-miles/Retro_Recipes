<!-- Dynamic Year Functionality -->
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentYear = new Date().getFullYear();
            document.getElementById('copyright').innerHTML = `&copy; ${currentYear} Amy Miles`;
        });
</script>

<footer class="footer bg-dark text-white">
    <div class="container d-flex align-items-center justify-content-center position-relative">
        <!-- Copyright -->
        <p id="copyright" class="m-0">© 2024 Your Company</p>
    </div>
</footer>