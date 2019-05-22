$(document).ready(function () {
    getFiles(3, false);
    getTemplates();
    getLogFiles('#log-file-table', 5);
    getLogFiles('#log-mail-all-table', 1000);

    $('#csv-first').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        let o = fileName.split('\\');
        fileName = o[o.length - 1];
        // console.log(o);
        // console.log(fileName);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#csv-second').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        let o = fileName.split('\\');
        fileName = o[o.length - 1];
        // console.log(o);
        // console.log(fileName);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#attachment').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        let o = fileName.split('\\');
        fileName = o[o.length - 1];
        // console.log(o);
        // console.log(fileName);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#first-upload').submit(function (e) {
        e.preventDefault();

        // if (formSent) return false;

        const formButton = $(this).find('#send-button');
        // formSent = true;

        formButton.html('Odosielam');

        const formData = new FormData(this);

        $.ajax({
            url: 'firstUpload.php',
            type: 'POST',
            data: formData,
            responseType: "json",
            success: function () {
                console.log('First ok!');
                getFiles(1, true);
            },
            error: function () {
                formButton.html('Chyba odosielania<div class="note">Kliknutím odošleš formulár znovu</div>');
                if (response.status === 401)
                    window.location.replace("../");
                // formSent = false;
                console.warn('Chyba registracie', arguments);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false
    });

    $('#second-upload').submit(function (e) {
        e.preventDefault();
        const formButton = $(this).find('#second-send-button');

        formButton.html('Odosielam');

        const formData = new FormData(this);

        $.ajax({
            url: 'secondUpload.php',
            type: 'POST',
            data: formData,
            responseType: "json",
            success: function () {
                console.log('Second OK!');
                getFiles(2, true);
                getLogFiles();
                setSelectOption();
                formButton.html('Odoslané');
            },
            error: function () {
                formButton.html('Chyba odosielania<div class="note">Kliknutím odošleš formulár znovu</div>');
                if (response.status === 401)
                    window.location.replace("../");
                // formSent = false;
                console.warn('Second fail!', arguments);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false
    });

    $('#send-message').submit(function (e) {
        e.preventDefault();
        const formButton = $(this).find('#template-submit');

        formButton.html('Odosielam');

        const formData = new FormData(this);

        $.ajax({
            url: 'secondUpload.php',
            type: 'POST',
            data: formData,
            responseType: "json",
            success: function () {
                console.log('Send OK!');
                // getTemplates();
                formButton.removeClass('btn-primary').addClass('btn-success');
                formButton.html('Odoslané');
                $('#send-messages').show();
            },
            error: function () {
                formButton.html('Chyba odosielania<div class="note">Kliknutím odošleš formulár znovu</div>');
                if (response.status === 401)
                    window.location.replace("../");
                console.warn('Send fail!', arguments);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false
    });

    $('#template-modal-form').submit(function (e) {
        e.preventDefault();
        const formButton = $(this).find('#template-add-submit');

        formButton.html('Odosielam');

        const formData = new FormData(this);
        $.ajax({
            url: 'template.php',
            type: 'POST',
            data: formData,
            responseType: "json",
            success: function () {
                // console.log('Insert template OK!');
                getTemplates();
                formButton.html('Odoslané');
                formButton.prop('disabled', true);
            },
            error: function (response) {
                formButton.html('Chyba odosielania<div class="note">Kliknutím odošleš formulár znovu</div>');
                if (response.status === 401)
                    window.location.replace("../");
                // formSent = false;
                console.warn('Insert template fail!', arguments);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false
    });

    $('#first-file-table').hover(function () {
        $('#first-file-table tr').removeClass('green-row');
    });

    $('#second-file-table').hover(function () {
        $('#second-file-table tr').removeClass('green-row');
    });

    $("img#sk").click(function () {
        $.ajax({
            url: '../index.php',
            async: false,
            data: {action: 'changeLanguage', lang: "sk"},
            type: 'post',
            success: function (output) {
                //console.log(output);
                location.reload(true);
            }
        });
    });
    $("img#en").click(function () {
        $.ajax({
            url: '../index.php',
            async: false,
            data: {action: 'changeLanguage', lang: "en"},
            type: 'post',
            success: function (output) {
                location.reload(true);
            }
        });
    });
    $('.sortable')
        .wrapInner('<span title="sort this column"/>')
        .each(function () {

            var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function () {

                $('#log-mail-all-table').find('td').filter(function () {

                    return $(this).index() === thIndex;

                }).sortElements(function (a, b) {

                    if ($.text([a]) == $.text([b]))
                        return 0;

                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;

                }, function () {

                    // parentNode is the element we want to move
                    return this.parentNode;

                });

                inverse = !inverse;

            });

        });
});


function prepareTemplateArray(data) {
    let obj = [['#', 'Vyberte šablónu..']];
    for (let i = 0; i < data.length; i++) {
        let tmp = [data[i].id, data[i].name + ' ' + '(' + formatDate(data[i].created_at) + ') - ' + data[i].type];
        obj[i + 1] = tmp;
    }
    return obj;
}

function prepareTemplateArrayForFiles(data) {
    let obj = [['#', 'Vyberte súbor..']];
    for (let i = 0; i < data.length; i++) {
        let tmp = [data[i].id, data[i].basename + ' ' + '(' + formatDate(data[i].created_at) + ')'];
        obj[i + 1] = tmp;
    }
    return obj;
}

function setSelect(key, value) {
    $('#template-select')
        .append($("<option></option>")
            .attr("value", value[0])
            .text(value[1]));
}

function setSelectForFiles(key, value) {
    $('#files-select')
        .append($("<option></option>")
            .attr("value", value[0])
            .text(value[1]));
}

function formatDate(date) {
    let d = new Date(date);
    let months = ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
    let day = d.getDate() < 10 ? '0' + d.getDate() : d.getDate();
    let month = months[d.getMonth()];
    let year = d.getFullYear();
    let hours = d.getHours() < 10 ? '0' + d.getHours() : d.getHours();
    let minutes = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes();
    return day + ' ' + month + ' ' + year + ' - ' + hours + ':' + minutes;
}

function setSelectOption() {
    var request = $.get("template.php/files", function (response) {
        // console.log(response);
        let obj = prepareTemplateArray(response.data.templates);
        let files = prepareTemplateArrayForFiles(response.data.files);
        $('#template-select option').remove();
        $.each(obj, setSelect);
        $('#files-select option').remove();
        $.each(files, setSelectForFiles);
    })
        .fail(function () {
            console.log('Fail!');
            if (response.status === 401)
                window.location.replace("../");
        })
        .always(function () {
            //hideLoading();
        });
}

function setDelimiter(button, id, delimiter) {
    let selector = id === 1 ? '#first-delimiter' : '#second-delimiter';
    $(selector).val(delimiter);

    if (button === 1) $('#b-del2').removeClass('checked');
    if (button === 2) $('#b-del1').removeClass('checked');
    if (button === 3) $('#b-del4').removeClass('checked');
    if (button === 4) $('#b-del3').removeClass('checked');
    let b = $('#b-del' + button);
    b.removeClass("checked").addClass("checked");

}

function printTable(data, selector, mark) {
    if (data.length > 0)
        $(selector + ' td').remove();
    selector = selector.replace('#', '');
    let table_doc = document.getElementById(selector);
    //table data
    var len = data.length < 5 ? data.length : 5;
    for (let i = len - 1; i >= 0; i--) {
        var row = table_doc.insertRow(1);
        if (mark && i === 0) {
            row.className = 'green-row';
        }
        var id = row.insertCell(0);
        id.innerHTML = i + 1;
        var basename = row.insertCell(1).innerHTML = data[i].basename;
        var time = row.insertCell(2).innerHTML = formatDate(data[i].created_at);
        var download = row.insertCell(3).innerHTML = "<a href='" + data[i].filename + "'><i class='fas fa-file-csv fa-2x'></i></a>";
        // col.innerHTML = data[i][j];
    }
}

function printTableTemplate(data, selector) {
    if (data.length > 0)
        $(selector + ' td').remove();
    selector = selector.replace('#', '');
    let table_doc = document.getElementById(selector);
    //table data
    var len = data.length < 5 ? data.length : 5;
    for (let i = len - 1; i >= 0; i--) {
        var row = table_doc.insertRow(1);
        var id = row.insertCell(0);
        id.innerHTML = i + 1;
        row.insertCell(1).innerHTML = data[i].name;
        row.insertCell(2).innerHTML = data[i].type;
        row.insertCell(3).innerHTML = formatDate(data[i].created_at);
        row.insertCell(4).innerHTML = "<button class='btn fas fa-trash-alt' style='color: #007bff;' onclick='deleteTemplate(" + data[i].id + ")'></button>";
    }
}

function getFiles(type, mark) {
    var first = $.get("firstUpload.php", function (response) {
        // console.log( "success" );
    }, "json")
        .done(function (response) {
            if (type === 1) {
                printTable(response.data.first_files, '#first-file-table', mark);
            } else if (type === 2) {
                printTable(response.data.second_files, '#second-file-table', mark);
            } else {
                printTable(response.data.first_files, '#first-file-table', mark);
                printTable(response.data.second_files, '#second-file-table', mark);
            }
        })
        .fail(function (response, code) {
            if (response.status === 401)
                window.location.replace("../");
        })
        .always(function () {
            // alert( "finished" );
        });
}

function getTemplates() {
    var request = $.get("template.php", function (response) {
        // console.log(response);
        // let obj = prepareTemplateArray(response.data.templates);
        // let files = prepareTemplateArrayForFiles(response.data.files);
        // $('#template-select option').remove();
        // $.each(obj, setSelect);
        // $('#files-select option').remove();
        // $.each(files, setSelectForFiles);
        // console.log('ok');
        printTableTemplate(response.data, '#template-table');
    }, 'json')
        .fail(function (response) {
            console.log('Fail!');
            if (response.status === 401)
                window.location.replace("../");
        })
        .always(function () {
            //hideLoading();
        });
}

function deleteTemplate(id) {
    $.ajax({
        url: 'template.php/' + id,
        type: 'DELETE',
        responseType: "json",
        success: function (response) {
            printTableTemplate(response.data, '#template-table');
        },
        error: function (response) {
            if (response.status === 401)
                window.location.replace("../");
            console.warn('Chyba pri delete', arguments);
        },
    });
}

function printLogFiles(data, selector, size) {
    if (data.length > 0)
        $(selector + ' td').remove();
    selector = selector.replace('#', '');
    let table_doc = document.getElementById(selector);
    var len = data.length < size ? data.length : size;
    for (let i = len - 1; i >= 0; i--) {
        var row = table_doc.insertRow(1);
        var id = row.insertCell(0);
        id.innerHTML = i + 1;
        row.insertCell(1).innerHTML = data[i].recipient;
        row.insertCell(2).innerHTML = data[i].subject;
        row.insertCell(3).innerHTML = data[i].type;
        row.insertCell(4).innerHTML = formatDate(data[i].created_at);
        // row.insertCell(4).innerHTML = "<button class='btn fas fa-trash-alt' style='color: #007bff;' onclick='deleteTemplate("+data[i].id+")'></button>";
    }
}

function getLogFiles(selector, size) {
    var request = $.get("secondUpload.php", function (response) {
        printLogFiles(response.data, selector, size);
    }, 'json')
        .fail(function (response) {
            console.log('Fail!');
            if (response.status === 401)
                window.location.replace("../");
        })
        .always(function () {
            //hideLoading();
        });
}