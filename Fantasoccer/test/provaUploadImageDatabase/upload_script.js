
function set_file(e) {
    e.preventDefault();
    document.getElementById('selectfile').files=e.dataTransfer.files;
}