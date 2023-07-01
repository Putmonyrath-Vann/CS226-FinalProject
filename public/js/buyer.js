function confirmOrder(){
    let confirmation = confirm('Are you done with your order?')
    if (!confirmation) event.preventDefault();
}