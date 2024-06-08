function toggleEditForm(id) {
    var form = document.getElementById('edit-form-' + id);
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}