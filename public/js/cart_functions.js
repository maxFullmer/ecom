
function update_quantity(inputElementBeforeButton) {
    event.stopPropagation();

    let desired_amount = inputElementBeforeButton.value;
    let stock = inputElementBeforeButton.max;
    let item = inputElementBeforeButton.id;

        if (isNaN(desired_amount)) {
            alert("Quantity must be a number!"); 
        } else { 
            window.location.replace(`./checkout.php?change_quantity=${desired_amount}&stock=${stock}&item=${item}`); 
    }; 

}

$('.month-select').on('change', function () {
    let month_selected_index = this.value;
    console.log(month_selected_index);
    $('.carousel').carousel(month_selected_index);
});
    