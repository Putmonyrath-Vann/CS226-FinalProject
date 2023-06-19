const add = document.querySelector('#add');
const form = document.querySelector('#form');
add.addEventListener('keydown', (e) => {
    if (e.key == "Enter") {
        form.submit();
    }
})