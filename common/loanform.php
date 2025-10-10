
<div class="geex-content__modal__form">
  <div class="geex-content__modal__form__header">
    <h3 class="geex-content__modal__form__title">Request for New Loan</h3>
    <button class="geex-content__modal__form__close">
      <i class="uil-times"></i>
    </button>
  </div>

  <form id="loanForm" class="geex-content__modal__form__wrapper">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="">
    <div class="geex-content__modal__form__item">
      <input type="text" name="name" class="geex-content__modal__form__input" placeholder="Title" />
    </div> 
    <div class="geex-content__modal__form__item">
      <input type="number" id="amount" name="amount" class="geex-content__modal__form__input" placeholder="Amount" />
    </div>

    <!-- Repayment Type -->
    <div class="geex-content__modal__form__item">
      <select id="repaymentType" name="repaymentType" class="geex-content__modal__form__input">
        <option value="">-- Select Repayment Type --</option>
        <option value="monthly">Monthly</option>
        <option value="weekly">Weekly</option>
      </select>
    </div>

    <!-- Duration -->
    <div class="geex-content__modal__form__item">
      <select id="duration" name="duration" class="geex-content__modal__form__input">
        <option value="">-- Select Duration --</option>
        <option value="1">1</option>
        <option value="3">3</option>
        <option value="6">6</option>
        <option value="12">12</option>
      </select>
    </div>

    <!-- Show total -->
    <div class="geex-content__modal__form__item">
      <h4>Total Repayable: <span id="totalAmount">0</span></h4>
    </div>

    <div class="geex-content__modal__form__item">
      <textarea name="purpose" class="geex-content__modal__form__input geex-content__modal__form__input--textarea" placeholder="Purpose"></textarea>
    </div>
    <div class="geex-content__modal__form__item">
        <h4 class="geex-content__modal__form__item__title">
            Do you agree to our terms? 
            <a href="terms" target="_blank">Read Terms</a>
        </h4>
        <div class="geex-content__modal__form__item__single">
            <input type="checkbox" id="terms" name="terms" value="1">
            <label for="agreeTerms">I Agree</label>
        </div>
    </div>
    <div class="geex-content__modal__form__item">
      <button type="submit" class="geex-content__modal__form__submit">Submit</button>
    </div>
  </form>
</div>
<script>
var module = '<?= $module ?>';
$(document).ready(function () {

    // -----------------------------
    // Update duration labels based on repayment type
    // -----------------------------
    $("#repaymentType").on("change", function () {
        var type = $(this).val(); 
        $("#duration option").each(function () {
            var val = $(this).val();
            if (val !== "") {
                var label = val + " " + (type === "weekly" ? "Week(s)" : "Month(s)");
                $(this).text(label);
            }
        });
    });

    // -----------------------------
    // Trigger interest calculation
    // -----------------------------
    $("#repaymentType, #duration, #amount").on("change keyup", function () {
        var type = $("#repaymentType").val();
        var duration = $("#duration").val();
        var amount = parseFloat($("#amount").val());

        // Show default total
        $("#totalAmount").text(amount > 0 ? amount.toFixed(2) : "0");

        // Validate amount before AJAX
        if (!amount || amount <= 0) return;

        if (type && duration && amount > 0) {
            $.ajax({
                type: "POST",
                url: "actions",
                data: {
                    action: "calculateIntrest",
                    repaymentType: type,
                    duration: duration,
                    amount: amount,
                    moduleId: module
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#totalAmount").text(parseFloat(response.message.total).toFixed(2));
                    } else {
                        $("#totalAmount").text(amount.toFixed(2));
                        throwWarning(response.message, "toast-top-right");
                    }
                },
                error: function () {
                    $("#totalAmount").text(amount.toFixed(2));
                    throwWarning("Failed to calculate. Try again later.", "toast-top-right");
                }
            });
        }
    });

    // -----------------------------
    // Form submit via AJAX
    // -----------------------------
    $("form.geex-content__modal__form__wrapper").on("submit", function (e) {
        e.preventDefault();
        var $form = $(this);
        var amount = parseFloat($("#amount").val());

        // Validate amount
        if (!amount || amount <= 0) {
            throwWarning("Please enter a valid loan amount greater than zero.", "toast-top-right");
            return;
        }

        // Validate agree checkbox
      /*   if (!$("#agreeTerms").is(":checked")) {
            throwWarning("You must agree to the terms before submitting.", "toast-top-right");
            return;
        } */

        // Append module if not already present
        if ($form.find('input[name="moduleId"]').length === 0) {
            $form.append('<input type="hidden" name="moduleId" value="' + module + '">');
        }

        // AJAX submit
        $.ajax({
            type: "POST",
            url: "actions",
            data: $form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    throwSuccess(response.message, "toast-top-right");
                    // reload page after success
                    setTimeout(function() {
                        location.reload();
                    }, 500); // slight delay so toast shows
                } else {
                    throwWarning(response.message, "toast-top-right");
                }
            },
            error: function () {
                throwWarning("An unknown error occurred. Please try again.", "toast-top-right");
            }
        });
    });

});
</script>
