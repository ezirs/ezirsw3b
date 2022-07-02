<main>
    <form id="uploadForm" method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="input-group mb-3">
            <input type="file" name="file" id="fileInput" onchange="detailFIle()" class="form-control" required>
            <button type="button" id="form_reset" class="btn btn-outline-dark p-1" onclick="resetForm()"><i class="bi bi-x-circle"></i></button>
            <button type="button" id="file_detail" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Lainnya</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <ul class="list-group px-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Size
                        <span class="badge bg-primary rounded-pill" id="size">0 Bytes</span>
                    </li>
                </ul>
                <li><hr class="dropdown-divider"></li>
                <li class="px-2"><input type="password" name="password" id="password" class="form-control" placeholder="Password (Opsional)"></li>
            </ul>
            <button type="submit" class="btn btn-outline-success" name="submit">Upload</button>
        </div>
    </form>

    <div class="progress" id="prog">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div id="uploadStatus" class="mb-3"></div>

    <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="ls-fil" data-bs-toggle="tab" data-bs-target="#ls-fil-pane" type="button" role="tab" aria-controls="ls-fil-pane" aria-selected="true">Files</button>
        </li>
        <li class="nav-item mx-1">
            <button class="btn btn-outline-secondary btn-sm" type="button" id="refreshiframe" onclick="refreshIframe()"><i class="bi bi-arrow-clockwise"></i></button>
        </li>
        <li class="nav-item">
            <a href="?page=ls-fil" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="bi bi-arrows-fullscreen"></i></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ls-fil-pane" role="tabpanel" aria-labelledby="ls-fil" tabindex="0">
            <iframe id="list_files" src="?page=ls-fil" class="w-100" height="500"></iframe>
        </div>
    </div>
</main>

<script type="text/javascript">
    function refreshIframe() {
        document.getElementById('list_files').contentDocument.location.reload(true);
    }
    function resetForm() {
        $("#form_reset").hide();
        $('#uploadForm')[0].reset();
        document.getElementById('size').innerHTML = '0 Bytes';
    }

    function detailFIle() {
        $("#form_reset").show();
        $("#file_detail").click();
        var bytes = $('#fileInput')[0].files[0].size;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        var fileSize = document.getElementById('size');
        if (bytes === 0) {
            fileSize.innerHTML = '0 Bytes';
        }
        var i = Math.floor(Math.log(bytes) / Math.log(1024));
        fileSize.innerHTML = parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
    }

    $(document).ready(function() {
        $("#prog").hide();
        $("#form_reset").hide();
        $("#uploadForm").on('submit', function(e) {
            var file = $('#fileInput')[0].files[0];
            if (file) {
                if (file.size <= 10485760) {
                    $("#prog").show();
                    $('#uploadStatus').html('');
                    e.preventDefault();
                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                    $(".progress-bar").width(percentComplete + '%');
                                    $(".progress-bar").html(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        type: 'POST',
                        url: '?page=up',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function() {
                            $(".progress-bar").width('0%');
                        },
                        error: function() {
                            $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                        },
                        success: function(resp) {
                            $("#prog").hide();
                            document.getElementById('uploadStatus').innerHTML = '<p style="color:#28A74B;">File has uploaded successfully!</p>';
                            $("#refreshiframe").click();
                            $("#form_reset").hide();
                            $('#uploadForm')[0].reset();
                        }
                    });
                } else {
                    $('#uploadStatus').html('<p style="color:#EA4335;">Sorry, your file is too large. [Max = 10 MB]</p>');
                    return false;
                }
            } else {
                $('#uploadStatus').html('<p style="color:#EA4335;">>_<</p>');
                return false;
            }
            
        });
    	
    });
</script>