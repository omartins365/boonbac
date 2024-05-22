import intlTelInput from 'intl-tel-input';
import intlTelInputUtils from 'intl-tel-input/build/js/utils';

const ctxModal = new bootstrap.Modal(document.getElementById('showConfirmTxModal'));
let productButtons = document.querySelectorAll('.product[data-product]');
productButtons.forEach(button => {
    button.addEventListener('click', () => {
        // console.log(button);
        showProductsModal(button);
    });
});
let ctxForm = document.getElementById('ctx-form');

function loading_screen() {
    displayAlert(`
<div class="text-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>
    `, 'secondary', 0);
}

ctxForm.addEventListener('submit', async (event) => {
    // console.log(event);
    event.preventDefault();
    loading_screen();

    let product = JSON.parse(ctxForm.dataset.product);
    let req_fields = JSON.parse(ctxForm.dataset.fields);

    let other_fields = ['pin', '_token'];


    // Create an object from the FormData
    const data = {'parameters': {}};
    req_fields.forEach((key) => {
        // console.log( key);
        data['parameters'][key] = document.getElementById('ctx-field-' + key)?.value;
    });
    other_fields.forEach((key) => {
        // console.log( key);
        data[key] = document.getElementById('ctx-field-' + key)?.value;
    });
    // Send POST request
    try {
        const response = await fetch(`/dashboard/purchase/${product.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        });
        let responseData = await response.json();
        let msg = `
        <h5 class="alert-title  text-uppercase">${responseData.status}</h5>
        <div class="alert-body">${responseData.message}</div>
        `;
        if (response.ok) {
            let tx = responseData.data;
            if (tx) {

                msg = `
        <h5 class="alert-title  text-uppercase"><i class="${tx.status_icon}"></i> ${responseData.status}</h5>
        <div class="alert-body p-2">
        ${tx.message}
        <br>
        <a class="btn btn-primary text-end" href="/dashboard/transactions/${tx.ref}">
        View details
       </a>
        </div>
        `;
                let alertClass = (tx.status_color) ? tx.status_color : "info";
                if (tx.status == 2) {
                    ctxModal.hide();
                    displayAlert(msg, alertClass, 60000, '#header');
                } else {
                    displayAlert(msg, alertClass, 60000);
                }

                if (tx.wallet_balance){
                    document.getElementById('wallet_balance').innerHTML=tx.wallet_balance;
                }
                return;
            }
        }
        displayAlert(msg, 'danger', 10000);

    } catch (error) {
        console.error('Error:', error);
        displayAlert('An error occurred. Please try again later.', 'danger', 5000);
    }

});

function showProductsModal(button) {

    // Get the data attributes from the button
    let product = JSON.parse(button.dataset.product);
    let req_fields = JSON.parse(button.dataset.fields);
    console.debug(product, req_fields);
    ctxForm.setAttribute('data-product', button.dataset.product);
    ctxForm.setAttribute('data-fields', button.dataset.fields);
    product['amount_due'] = product.amount_in_naira.toLocaleString();
    product['amount_in_naira'] = product.amount_in_naira.toLocaleString();
    // Iterate through object properties
    for (let prop in product) {
        if (product.hasOwnProperty(prop)) {
            // Try to find an element with matching ID
            let element = document.getElementById("ctx-product-" + prop);

            if (element) {
                if (product[prop]) {
                    // Replace the inner text with the value from the object
                    element.innerText = product[prop];
                    element.parentElement.hidden = false;
                } else {
                    element.parentElement.hidden = true;
                }
            }
        }
    }


    // Append the row to the element with ID 'ctx-fields'
    var ctxFields = document.getElementById('ctx-fields');


    if (ctxFields) {
        ctxFields.innerHTML = ''; // Clear the content
        if (req_fields.includes('phone_number')) {
            ctxFields.appendChild(phone_input());
            let element = document.getElementById('ctx-field-phone_number');

            intlTelInput(element, {
                // any initialisation options go here
                hiddenInput: element.dataset.name,
                initialCountry: 'ng',
                onlyCountries: ['ng'],
                placeholderNumberType: 'MOBILE',
                intlTelInputUtils: intlTelInputUtils
            });
        }
        if (req_fields.includes('quantity')) {
            ctxFields.appendChild(quantity_input());
        }
        let unit_priceElement = document.getElementById('ctx-product-amount_in_naira');
        if (req_fields.includes('amount')) {
            unit_priceElement.parentElement.parentElement.hidden = true;
            ctxFields.appendChild(amount_input());
        } else {
            unit_priceElement.parentElement.parentElement.hidden = false;
        }
        if (req_fields.includes('smart_card_number')) {
            ctxFields.appendChild(smart_card_input());
        }
        if (req_fields.includes('meter_number')) {
            ctxFields.appendChild(meter_number_input());
        }
    }


    ctxModal.show();
}

function meter_number_input() {
    // Create elements
    var divRow = document.createElement('div');
    divRow.className = 'row mb-3';

    var label = document.createElement('label');
    label.className = 'col-md-4 col-form-label text-md-end';
    label.setAttribute('for', 'ctx-field-meter_number');
    label.innerText = 'Meter Number';

    var divCol = document.createElement('div');
    divCol.className = 'col-md-6';

    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.id = 'ctx-field-meter_number';
    input.setAttribute('name', 'meter_number');
    input.setAttribute('placeholder', 'enter meter number');
    input.required = true;

    // Add change event listener
    input.addEventListener('change', function () {
        let mNumber = document.getElementById('ctx-field-meter_number').value;
        if (mNumber.toString().length >= 13) {
            confirm_meter_number();
        }
    });

    // Create button
    var button = document.createElement('button');
    button.type = 'button';
    button.className = 'btn btn-link';
    button.innerText = 'Confirm Meter Number';

    // Add onclick event
    button.addEventListener('click', confirm_meter_number);


    // Append elements
    divCol.appendChild(input);
    divRow.appendChild(label);
    divCol.appendChild(button);
    divRow.appendChild(divCol);
    return divRow;
}

function smart_card_input() {
    // Create elements
    var divRow = document.createElement('div');
    divRow.className = 'row mb-3';

    var label = document.createElement('label');
    label.className = 'col-md-4 col-form-label text-md-end';
    label.setAttribute('for', 'ctx-field-smart_card_number');
    label.innerText = 'Smart Card or IUC Number';

    var divCol = document.createElement('div');
    divCol.className = 'col-md-6';

    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.id = 'ctx-field-smart_card_number';
    input.setAttribute('name', 'smart_card_number');
    input.setAttribute('placeholder', 'enter smart card or iuc number');
    input.required = true;

    // Add change event listener
    input.addEventListener('change',function(){
        let smartCardNumber = document.getElementById('ctx-field-smart_card_number').value;
        if (smartCardNumber.toString().length >= 10) {
            confirm_smart_card_number();
        }
    });

    // Create button
    var button = document.createElement('button');
    button.type = 'button';
    button.className = 'btn btn-link';
    button.innerText = 'Confirm Smart Card Number';

    // Add onclick event
    button.addEventListener('click', confirm_smart_card_number);


    // Append elements
    divCol.appendChild(input);
    divRow.appendChild(label);
    divCol.appendChild(button);
    divRow.appendChild(divCol);
    return divRow;
}

function confirm_smart_card_number() {

    let smartCardNumber = document.getElementById('ctx-field-smart_card_number').value;
    return confirm_utility_number(smartCardNumber);
}

function confirm_meter_number() {

    let Number = document.getElementById('ctx-field-meter_number').value;
    let product = JSON.parse(ctxForm.dataset.product)
    let amount = document.getElementById('ctx-field-amount').value;
    return confirm_utility_number(Number, product.id, amount);
}

async function confirm_utility_number(utility_no, product_id = null, amount = null) {
    // This function will be executed when the button is clicked
    let service_id = document.getElementById('ctx-field-service_id').value;
    let category_id = document.getElementById('ctx-field-category_id').value;
    let details_view = document.getElementById('ctx-details');
    const params = new URLSearchParams();
    if (product_id) {
        params.append('product_id', product_id);
    }
    if (amount) {
        params.append('amount', amount);
    }
    try {
        loading_screen();
        const response = await fetch(`/dashboard/verify/${service_id}/categories/${category_id}/${utility_no}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        });
        let responseData = await response.json();
        let msg = `
        <h5 class="alert-title  text-uppercase">${responseData.status}</h5>
        <div class="alert-body">${responseData.message??'Invalid'}</div>
        `;
        if (response.ok) {
            let data1 = responseData.data;
            if (data1) {
                let details = `
        Name: ${data1.details.name} <br>`;
                if (data1.details.status) {
                    details += `
        Status: ${data1.details.subscription_status} <br>
        Current Plan: ${data1.details.current_plan} <br>
        Date Due: ${data1.details.due_date} <br>`;
                }
                if (data1.details.meter_type) {
                    details += `
        Meter Type: ${data1.details.meter_type} <br>
        Address: ${data1.details.address} <br>`;
                }
                msg = `
        <h5 class="alert-title  text-uppercase">${responseData.status}</h5>
        <div class="alert-body p-2">
        ${details}
        </div>
        `;
                document.getElementById('ctx-details').innerHTML = details;
                displayAlert(msg, 'success', 60000);

            }
        } else {
            displayAlert(msg, 'danger', 10000);
        }

    } catch (error) {
        console.error('Error:', error);
        displayAlert('An error occurred. Please try again later.', 'danger', 5000);
    }

    // Add your logic here to handle the confirmed smart card number
}

function quantity_input() {
    // Create elements
    var divRow = document.createElement('div');
    divRow.className = 'row mb-3';

    var label = document.createElement('label');
    label.className = 'col-md-4 col-form-label text-md-end';
    label.setAttribute('for', 'ctx-field-quantity');
    label.innerText = 'Quantity';

    var divCol = document.createElement('div');
    divCol.className = 'col-md-6';

    var input = document.createElement('input');
    input.type = 'number';
    input.className = 'form-control';
    input.id = 'ctx-field-quantity';
    input.value = '1';
    input.setAttribute('name', 'quantity');
    input.setAttribute('placeholder', 'enter quantity');
    input.setAttribute('min', '1');
    input.required = false;

    // Add change event listener
    input.addEventListener('change', function (event) {
        // This function will be executed when the input value changes
        let newValue = event.target.value;
        let amount_due = document.getElementById('ctx-product-amount_due');
        let unit_priceElement = document.getElementById('ctx-product-amount_in_naira');

        // Get the unit price without formatting
        let unit_price = parseFloat(unit_priceElement.textContent.replace(/,/g, '')); // Remove commas

        // Calculate the new amount_due
        let newAmountDue = unit_price * newValue;

        // Format the newAmountDue with commas
        // Apply number formatting
        // Update the amount_due element with the formatted value
        amount_due.textContent = newAmountDue.toLocaleString();

        console.log('New quantity value: ' + newValue);
    });

    // Append elements
    divCol.appendChild(input);
    divRow.appendChild(label);
    divRow.appendChild(divCol);
    return divRow;
}

function amount_input() {
    // Create elements
    var divRow = document.createElement('div');
    divRow.className = 'row mb-3';

    var label = document.createElement('label');
    label.className = 'col-md-4 col-form-label text-md-end';
    label.setAttribute('for', 'ctx-field-amount');
    label.innerText = 'Amount';

    var divCol = document.createElement('div');
    divCol.className = 'col-md-6';

    var input = document.createElement('input');
    input.type = 'number';
    input.className = 'form-control';
    input.id = 'ctx-field-amount';
    input.setAttribute('name', 'amount');
    input.setAttribute('placeholder', 'enter amount');
    input.setAttribute('min', '50');
    input.required = true;

    // Add change event listener
    input.addEventListener('keyup', function (event) {
        // This function will be executed when the input value changes
        let newValue = event.target.value;
        let amount_due = document.getElementById('ctx-product-amount_due');

        // Calculate the new amount_due
        // Format the newAmountDue with commas
        // Apply number formatting
        // Update the amount_due element with the formatted value
        amount_due.textContent = newValue.toLocaleString();
        console.log('New amount value: ' + newValue);
    });

    // Append elements
    divCol.appendChild(input);
    divRow.appendChild(label);
    divRow.appendChild(divCol);
    return divRow;
}

function phone_input() {
    // Create elements
    var divRow = document.createElement('div');
    divRow.className = 'row mb-3';

    var label = document.createElement('label');
    label.className = 'col-md-4 col-form-label text-md-end';
    label.setAttribute('for', 'ctx-field-phone_number');
    label.innerText = 'Phone Number';

    var divCol = document.createElement('div');
    divCol.className = 'col-md-6';

    var input = document.createElement('input');
    input.type = 'tel';
    input.className = 'form-control tel-input';
    input.id = 'ctx-field-phone_number';
    input.setAttribute('data-name', 'phone_number');
    input.setAttribute('placeholder', '+234xxxxxxxxxx');
    input.setAttribute('autocomplete', 'phone_number');
    input.required = true;

    // Append elements
    divCol.appendChild(input);
    divRow.appendChild(label);
    divRow.appendChild(divCol);
    return divRow;
}

function displayAlert(message, type = "info", duration = 5000, attachTo = '#ctx-fields') {
    // Create alert element
    let dismissible = duration > 0;
    var alertDiv = document.createElement('div');
    alertDiv.className = 'ctx-alert shadow-sm alert alert-' + type + (dismissible ? " alert-dismissible" : "") + ' fade show position-fixed top-50 z-3 start-50 translate-middle-x';
    alertDiv.role = 'alert';

    // Create close button if alert is dismissible
    if (dismissible) {
        alertDiv.innerHTML = `
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="p-2">
                ${message}
            </div>
        `;
    } else {
        alertDiv.innerHTML = `
            <div class="p-2">
                ${message}
            </div>
        `;
    }

    let previousAlerts = document.querySelectorAll('.ctx-alert');
    previousAlerts.forEach(alert => alert.remove());
    // Append alert after ctx-fields
    var ctxFields = document.querySelector(attachTo);
    if (ctxFields) {
        ctxFields.parentNode.insertBefore(alertDiv, ctxFields.nextSibling);
    }

    if (dismissible) {
        // Set timeout to remove the alert after a duration
        setTimeout(function () {
            alertDiv.remove();
        }, duration);
    }
}


let fundButtons = document.querySelectorAll('.fund-with[data-gateway]');
fundButtons.forEach(button => {
    button.addEventListener('click', () => {
        // console.log(button);
        showFundWithModal(button);
    });
});
let fundWithForm = document.getElementById('fund-with-form');
let fundWithGatewayName = document.getElementById('fund_with_gateway_name');

function showFundWithModal(button) {

    // Get the data attributes from the button
    let gateway = button.dataset.gateway;
    console.debug(gateway);
    fundWithGatewayName.innerHTML = gateway;
    fundWithForm.setAttribute('data-gateway', button.dataset.gateway);
    const modal = new bootstrap.Modal(document.getElementById('showFundWithModal'));
    modal.show();
}

fundWithForm.addEventListener('submit', async (event) => {
    // console.log(event);
    event.preventDefault();
    event.target.disabled = true;

    event.submitter.disabled = true;
    displayAlert(`
<div class="text-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>
    `, 'secondary', 0,'#fund-with-form' );

    let gateway = fundWithForm.dataset.gateway;

    let other_fields = ['amount', '_token'];


    // Create an object from the FormData
    let data = {};
    other_fields.forEach((key) => {
        // console.log( key);
        data[key] = document.getElementById('fund-with-field-' + key)?.value;
    });

    // Send POST request
    try {
        const response = await fetch(`/dashboard/fund_with/${gateway}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        });
        const responseData = await response.json();

        if (response.ok) {
            let msg2 = `
            <h5 class="alert-title text-uppercase ">Loading payment page</h5>
            <div class="alert-body text-center">
            <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <br>
            <p>If this is taking too long, <a href="${responseData.payment_url}" >click here</a></p>
            </div>
            `;
            displayAlert(msg2, 'success', 0, '#fund-with-form');
            let modal = new bootstrap.Modal(document.getElementById('showFundWithModal'));
            modal.hide();
            window.location.href = responseData.data.payment_url;
            // window.close();
        } else {
            let msg = `
        <h5 class="alert-title text-uppercase ">${responseData.status}</h5>
        <div class="alert-body">${responseData.message}</div>
        `;
            displayAlert(msg, 'danger', 5000, '#fund-with-form');
        }
        event.target.disabled = false;
        event.submitter.disabled =false;
    } catch (error) {
        console.error('Error:', error);
        displayAlert('An error occurred. Please try again later.', 'danger', 5000, '#fund-with-form');

        event.target.disabled = false;
        event.submitter.disabled =false;
    }
});
