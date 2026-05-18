function previewFile(event) {
	document.getElementById("previewImage").src = URL.createObjectURL(
		event.target.files[0],
	);
}
