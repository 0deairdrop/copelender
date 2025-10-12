<?php
$pageTitle = 'Customer Management';
require_once 'common/header.php';
$module = DEF_MODULE_ID_LOAN_APPLICATION;
$userid = getLoggedInUserDetailsByKey('id');
?>
<body class="geex-dashboard">
<main class="geex-main-content">
    <?php require_once 'common/menu.php'; ?>

    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">Customer Management</h2>
                <p class="geex-content__header__subtitle">Register and manage customer profiles</p>
            </div>
            <div class="geex-content__header__action">
                <button type="button" class="geex-btn geex-btn--primary" id="addCustomerBtn">+ Add Customer</button>
            </div>
        </div>

        <div class="geex-content__section geex-content__form table-responsive">
            <h3 class="mb-3">Customer List</h3>
            <table class="table-reviews-geex-1 table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>National ID</th>
                    <th>Income</th>
                    <th>Credit Score</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody id="customerList">
                <tr><td colspan="7" style="text-align:center;">No customers found</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- hidden mode & id fields -->
                <form id="customerForm" novalidate>
                    <input type="hidden" name="mode" value="add"> <!-- 'add' or 'edit' -->
                    <input type="hidden" name="customerId" value="">
                    <input type="hidden" name="moduleId" value="<?= $module ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input name="firstName" type="text" class="form-control" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input name="lastName" type="text" class="form-control" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input name="email" type="email" class="form-control" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="countryCode" class="form-select" style="max-width:120px;">
                                    <option value="+234" selected>+234</option>
                                    <option value="+1">+1</option>
                                    <option value="+44">+44</option>
                                    <option value="+91">+91</option>
                                </select>
                                <input name="phone" type="tel" class="form-control" required>
                            </div>
                            <div class="invalid-feedback d-block phone-error" style="display:none;">Phone is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">National ID (11 digits) <span class="text-danger">*</span></label>
                            <input name="nationalId" type="text" class="form-control" maxlength="11" inputmode="numeric" pattern="\d{11}" required>
                            <div class="invalid-feedback nationalid-error">National ID must be 11 digits.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Occupation</label>
                            <input name="occupation" type="text" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Monthly Income (₦)</label>
                            <input name="monthlyIncome" type="number" min="0" class="form-control">
                            <div class="invalid-feedback income-error">Enter a valid income &gt;= 0</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Credit Score (0-100)</label>
                            <input name="creditScore" type="number" min="0" max="100" class="form-control">
                            <div class="invalid-feedback score-error">Enter a credit score between 0 and 100.</div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="geex-btn geex-btn--outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveCustomerBtn" class="geex-btn geex-btn--primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    const customerModalEl = document.getElementById('customerModal');
    const customerModal = new bootstrap.Modal(customerModalEl, {backdrop: 'static'});
    const $form = $('#customerForm');
    const $saveBtn = $('#saveCustomerBtn');

    // open add modal
    $('#addCustomerBtn').on('click', function(){
        setMode('add');
        restoreFormState();
        customerModal.show();
    });

    // helper: set form mode
    function setMode(mode){
        $form.find('input[name="mode"]').val(mode);
        if(mode === 'add'){
            $saveBtn.text('Save').removeClass('geex-btn--outline-secondary').addClass('geex-btn--primary');
            $('.modal-title').text('Add Customer');
        } else {
            $saveBtn.text('Update').removeClass('geex-btn--outline-secondary').addClass('geex-btn--primary');
            $('.modal-title').text('Edit Customer');
        }
    }

    function restoreFormState(){
        const f = $form[0];
        f.reset();
        $(f).removeClass('was-validated');
        $(f).find('.is-invalid').removeClass('is-invalid');
        $('.phone-error, .nationalid-error, .income-error, .score-error').hide();
        $form.find('input[name="customerId"]').val('');
    }

    // national id: digits only, max 11
    $(document).on('input', 'input[name="nationalId"]', function(){
        this.value = this.value.replace(/\D/g,'').slice(0,11);
        const ok = /^\d{11}$/.test(this.value);
        if(!ok && this.value.length > 0){
            $(this).addClass('is-invalid');
            $('.nationalid-error').show();
        } else {
            $(this).removeClass('is-invalid');
            $('.nationalid-error').hide();
        }
    });

    // phone: hide error when typing
    $(document).on('input', 'input[name="phone"]', function(){
        const v = $(this).val().trim();
        if(v.length > 0){
            $(this).removeClass('is-invalid');
            $('.phone-error').hide();
        }
    });

    // income & score live validation
    $(document).on('input', 'input[name="monthlyIncome"]', function(){
        const v = this.value;
        if(v !== '' && (isNaN(Number(v)) || Number(v) < 0)){
            $(this).addClass('is-invalid');
            $('.income-error').show();
        } else {
            $(this).removeClass('is-invalid');
            $('.income-error').hide();
        }
    });
    $(document).on('input', 'input[name="creditScore"]', function(){
        const v = this.value;
        if(v !== '' && (isNaN(Number(v)) || Number(v) < 0 || Number(v) > 100)){
            $(this).addClass('is-invalid');
            $('.score-error').show();
        } else {
            $(this).removeClass('is-invalid');
            $('.score-error').hide();
        }
    });

    // email live validation
    $(document).on('input', 'input[name="email"]', function(){
        if(this.checkValidity()) $(this).removeClass('is-invalid');
        else $(this).addClass('is-invalid');
    });

    // Save (Add or Update)
    $saveBtn.on('click', function(){
        const formEl = $form[0];

        // native validation
        if(!formEl.checkValidity()){
            $(formEl).addClass('was-validated');
            $(formEl).find(':invalid').addClass('is-invalid');
            if(!$('input[name="phone"]').val().trim()){
                $('.phone-error').show();
            }
            return;
        }

        // extra checks
        const national = $('input[name="nationalId"]').val();
        if(!/^\d{11}$/.test(national)){
            $('input[name="nationalId"]').addClass('is-invalid');
            $('.nationalid-error').show();
            return;
        }
        const incomeVal = $('input[name="monthlyIncome"]').val();
        if(incomeVal !== '' && Number(incomeVal) < 0){ $('.income-error').show(); return; }
        const scoreVal = $('input[name="creditScore"]').val();
        if(scoreVal !== '' && (Number(scoreVal) < 0 || Number(scoreVal) > 100)){ $('.score-error').show(); return; }

        // decide action
        const mode = $form.find('input[name="mode"]').val(); // 'add' | 'edit'
        const actionName = mode === 'edit' ? 'updateCustomer' : 'register';

        const fd = new FormData(formEl);
        fd.append('action', actionName);

        // if edit, include customerId
        const cid = $form.find('input[name="customerId"]').val();
        if(mode === 'edit' && cid) fd.append('customerId', cid);

        $('body').append('<div id="block-overlay" class="geex-overlay">Processing...</div>');
        $.ajax({
            type: 'POST',
            url: 'actions',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res){
                $('#block-overlay').remove();
                if(res.status === 'success'){
                    throwSuccess(res.message || (mode === 'edit' ? 'Customer updated' : 'Customer registered'), 'toast-top-right');

                    // close modal after slight delay, reset
                    setTimeout(function(){
                        customerModal.hide();
                        formEl.reset();
                        loadCustomers(true, res.data ? res.data.customerId : null); // pass newly-updated id to highlight
                    }, 300);
                } else {
                    throwWarning(res.message || 'Operation failed', 'toast-top-right');
                }
            },
            error: function(){
                $('#block-overlay').remove();
                throwWarning('Server error', 'toast-top-right');
            }
        });
    });

    // load & render customers
    function loadCustomers(forceRefresh, highlightId){
        $.getJSON('actions', {action: 'getCustomers', moduleId: '<?= $module ?>'}, function(res){
            const tbody = $('#customerList');
            tbody.empty();
            if(res.status === 'success' && Array.isArray(res.data) && res.data.length){
                res.data.forEach(function(c, i){
                    const income = c.monthlyIncome ? '₦'+Number(c.monthlyIncome).toLocaleString() : '-';
                    const cid = c.id || '';
                    // Edit button (passes customer id)
                    const editBtn = `<button class="geex-btn geex-btn--outline-primary btn-edit" data-id="${cid}">Edit</button>`;
                    tbody.append(`<tr data-id="${cid}">
                        <td>${i+1}</td>
                        <td>${(c.firstName||'') + ' ' + (c.lastName||'')}</td>
                        <td>${(c.countryCode||'') + ' ' + (c.phone||'')}</td>
                        <td>${c.nationalId || '-'}</td>
                        <td>${income}</td>
                        <td>${c.creditScore || '-'}</td>
                        <td>${editBtn}</td>
                    </tr>`);
                });
                if(highlightId){
                    const $row = $(`#customerList tr[data-id="${highlightId}"]`);
                    if($row.length){
                        $row.addClass('table-success');
                        setTimeout(()=> $row.removeClass('table-success'), 2200);
                    }
                }
            } else {
                tbody.append('<tr><td colspan="7" class="text-center">No customers found</td></tr>');
            }
        }).fail(function(){
            $('#customerList').html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
        });
    }

    // edit click (delegated)
    $(document).on('click', '.btn-edit', function(){
        const id = $(this).data('id');
        if(!id) return;
        // fetch a single customer record (ideally actions?action=getCustomer&id=...), fallback to the getCustomers list
        // first try a dedicated endpoint
        $.getJSON('actions', {action: 'getCustomer', id: id, moduleId: '<?= $module ?>'}, function(res){
            if(res.status === 'success' && res.data){
                fillFormForEdit(res.data);
            } else {
                // fallback: fetch full list and find id
                $.getJSON('actions', {action: 'getCustomers', moduleId: '<?= $module ?>'}, function(listRes){
                    if(listRes.status === 'success' && Array.isArray(listRes.data)){
                        const record = listRes.data.find(r => r.id === id);
                        if(record) fillFormForEdit(record);
                        else throwWarning('Record not found', 'toast-top-right');
                    } else {
                        throwWarning('Unable to load record', 'toast-top-right');
                    }
                });
            }
        }).fail(function(){
            throwWarning('Unable to load record', 'toast-top-right');
        });
    });

    function fillFormForEdit(data){
        setMode('edit');
        restoreFormState();
        const f = $('#customerForm')[0];
        $('input[name="customerId"]').val(data.id || '');
        $('input[name="firstName"]').val(data.firstName || '');
        $('input[name="lastName"]').val(data.lastName || '');
        $('input[name="email"]').val(data.email || '');
        $('select[name="countryCode"]').val(data.countryCode || '+234');
        $('input[name="phone"]').val(data.phone || '');
        $('input[name="nationalId"]').val(data.nationalId || '');
        $('input[name="occupation"]').val(data.occupation || '');
        $('textarea[name="address"]').val(data.address || '');
        $('input[name="monthlyIncome"]').val(data.monthlyIncome || '');
        $('input[name="creditScore"]').val(data.creditScore || '');
        customerModal.show();
    }

    // initial load
    loadCustomers();
});
</script>

<?php require_once 'common/footer.php'; ?>
</body>
</html>
