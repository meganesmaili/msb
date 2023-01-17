document.querySelectorAll('.option').forEach(option => {
    option.addEventListener('click', changeStyle);
})

function changeStyle() {
    document.querySelectorAll('.option').forEach(option => {
        option.classList.remove('active');
    })

    let num = this.dataset.option;
    document.querySelector('.color-option').src = `assets/images/headphones/color-option0${num}.jpg`;
    this.classList.add('active');
}