export default () => {
    const dropdownMenu = document.getElementsByClassName("dropdown-menu")[0]
    const dropdownBtn = document.getElementById("dropdown_profile")

    dropdownBtn.addEventListener("click", () => {
        if (dropdownMenu.style.display === 'none' || !dropdownMenu.style.display) {
            dropdownMenu.style.display = 'block'
            dropdownMenu.style.transform = "translate3d(-1px, 34px, 0px)"
        } else {
            dropdownMenu.style.display = 'none'
        }
    })
}