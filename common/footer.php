
<script>
    var varCurrentPath = "<?= DEF_ROOT_PATH ?>";
    var varRedirectPage = "<?= DEF_FULL_ROOT_PATH . '/' . $redirect ?>";
    var moduleId = "<?= $module ?>";
    $(document).ready(function() {
        // Get the current URL path (normalized, no trailing slash)
        var currentPage = window.location.pathname.replace(/\/$/, '').split('/').pop();
        // Array of page names where the form submission should be excluded
        var excludePages = ['loanApplication', 'loans'];
        if (!excludePages.includes(currentPage)) 
        {
            $('form').each(function() {
                if ($(this).find('input[name="moduleId"]').length === 0) {
                    $(this).append('<input type="hidden" name="moduleId" value="' + moduleId + '">');
                }
            });

            $('form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                $.ajax({
                    type: 'POST',
                    url:'actions',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            throwSuccess(response.message, 'toast-top-right');
                            if (varRedirectPage && varRedirectPage.trim() !== "") 
                            {
                                goToUrl(varRedirectPage); // redirect properly
                            } 
                            else 
                            {
                                window.location.reload();
                            }
                        } else 
                        {
                            throwWarning(response.message, 'toast-top-right');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var message = 'An unknown error occurred. Please try again.';
                        throwWarning(message, 'toast-top-right');
                    }
                });
            });
        }
    });
</script>


<script src="./assets/vendor/js/jquery/jquery-3.5.1.min.js"></script>
<script src="./assets/vendor/js/jquery/jquery-ui.js"></script>
<script src="./assets/vendor/js/bootstrap/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.0/dist/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" referrerpolicy="origin"></script>
<script src="./assets/js/main.js"></script>


<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/js/functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
