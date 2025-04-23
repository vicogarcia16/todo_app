</main>

<footer class="bg-dark text-center text-white py-3">
  <div class="container">
    &copy; <?= date('Y') ?> To‑Do App by <a href="https://github.com/vicogarcia16" class="link-light">vicogarcia16</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
crossorigin="anonymous"></script>
</body>
<script>
  setTimeout(function() {
    const errorNotification = document.getElementById('error-notification');
    const successNotification = document.getElementById('success-notification');
    if (errorNotification) {
      errorNotification.classList.add('fade');
      setTimeout(() => errorNotification.remove(), 300);
    }
    if (successNotification) {
      successNotification.classList.add('fade');
      setTimeout(() => successNotification.remove(), 300);
    }
  }, 4000);
</script>
</html>
