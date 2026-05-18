<?php
function alert($message)
{
	$result = [
		"status" => false,
		"data" => "<div class='toast align-items-center text-white bg-primary border-0 show' role='alert' aria-live='assertive' aria-atomic='true'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        $message
                    </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
                </div>"
	];
	return $result;
}
function AddImageToserver($path, $image)
{
	$guid = bin2hex(random_bytes(16));
	$target_dir = $path;
	$imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
	$target_file = $target_dir . $guid . "." . $imageFileType;
	$file_name = $guid . "." . $imageFileType;

	if (!getimagesize($image["tmp_name"])) {
		return alert(" uploaded file is not image!");
	}
	if ($image["size"] > 500000) {
		return alert("File is too big");
	}
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		return alert("unsupported image type");
	}
	if (move_uploaded_file($image["tmp_name"], $target_file)) {
		$data = [
			"status" => true,
			"data" => $file_name
		];
		return $data;
	}
}
function deleteImageFromServer($path)
{
	if (file_exists($path)) {
		if (unlink($path)) {
			return [
				"status" => true,
				"data" => "deleted"
			];
		}
	}
	return alert("failed to delete");
}

?>