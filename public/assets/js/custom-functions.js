let cropper = false;
function setCropper(ele) {
    const file = ele.files[0];
    const crop_size = cropSize(400, 400);
    let fitPreview = false;

    if (!file) return false;

    const inputElement = ele;
    const image = new Image();
    image.src = URL.createObjectURL(file);
    $(inputElement).removeClass("is-invalid");
    $(inputElement).next(".invalid-feedback").addClass("d-none");
    $("#image-prview").attr("src", "").addClass("d-none");
    $(".cropper-div").addClass("d-none");
    removeCroppedImage();

    fileSize = file.size / 1024 / 1024;
    fileName = file.name;
    fileType = fileName.split(".").pop().toLowerCase();

    if (
        fileSize > 2 ||
        $.inArray(fileType, ["gif", "png", "jpg", "jpeg", "svg"]) === -1
    ) {
        const message =
            fileSize > 2
                ? "File size is too large " +
                  fileSize.toFixed(2) +
                  "MB. Max Upload File size is 3 MB."
                : "File type should be (png, jpg, svg, gif).";
        $(inputElement)
            .next(".invalid-feedback")
            .removeClass("d-none")
            .text(message);
        $(inputElement).val("").addClass("is-invalid");
        return false;
    }

    image.onload = function () {
        fitPreview =
            this.width === crop_size.width && this.height === crop_size.height;

        if (cropper) cropper.destroy();

        $("#image-prview")
            .attr("src", URL.createObjectURL(file))
            .removeClass("d-none");
        $(".cropper-div").removeClass("d-none");

        cropper = new Cropper($("#image-prview")[0], {
            aspectRatio: crop_size.ratio,
            zoomable: false,
            cropBoxResizable: true,
            autoCropArea: fitPreview,
            preview: "#crop-preview",
            viewMode: 3,
        });
    };
}

function cropSize(width, height) {
    return { width, height, ratio: width / height };
}

function resetCropper() {
    cropper?.reset();
}

function cancelCropper() {
    if (cropper) {
        cropper.destroy();
        cropper = false;
        $("#image-prview").attr("src", "").addClass("d-none");
        $("#crop-preview").html("");
        $(".cropper-div").addClass("d-none");
        $("#image").val("");
    }
}

function saveCropper() {
    if (cropper) {
        const crop_size = cropSize(400, 400);
        const canvas = cropper.getCroppedCanvas({
            width: crop_size.width,
            height: crop_size.height,
        });
        canvas.toBlob(function (blob) {
            const img = URL.createObjectURL(blob);
            $("#image-upload-icon").attr("src", img);
            $("#upload-img-trash-btn").removeClass("d-none");

            var reader = new FileReader(img);
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $("#images").append(
                    '<input type="hidden" name="images" value="' +
                        base64data +
                        '">'
                );
            };
        });
        cancelCropper();
    }
}

function removeCroppedImage() {
    const img = window.location.origin + "/assets/default_images/blank/no-found1.png";
    $("#image-upload-icon").attr("src", img);
    $("#upload-img-trash-btn").addClass("d-none");
    $("#images").html("");
}
