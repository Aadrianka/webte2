if(document.getElementById("year")) {
    var start = 2015;
    var end = new Date().getFullYear()+1;
    var options = "";
    for(var year = start ; year <=end; year++){
        options += "<option>"+ year +"</option>";
    }
    document.getElementById("year").innerHTML = options;
}

$( ".deleteInfo" ).click(function() {
    var idToDelete = $(this).parent().attr('id');
    $.ajax({
        url: 'Uloha1/u1utilities.php',
        data: {action : 'delete', id: idToDelete},
        type : 'POST',
        success : function (output) {
            location.reload(true);
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
});

$( ".showInfo" ).click(function() {
    $('#infoTable').empty();
    var idToShow = $(this).children('.deleteData').attr('id');
    $.ajax({
        url: 'Uloha1/u1utilities.php',
        data: {action : 'show', id: idToShow},
        type : 'POST',
        success : function (output) {
            $('#infoTable').html(output + '<div>' +
                '          <button onclick="exportPdf();" class="btn btn-primary" id="export">Export pdf</button>' +
                '        </div>');
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
});

function exportPdf() {
    var doc = new jsPDF('l', 'mm', [1500, 1200]);
    var source = document.getElementById('tableofcontentfile').innerHTML;

    var margins = {
        top: 10,
        bottom: 10,
        left: 10,
        width: 595
    };

    var specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '.no-export': function(element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true;
        }
    };

    doc.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left,
        margins.top, {
            'width': margins.width,
            'elementHandlers': specialElementHandlers
        },

        function(dispose) {
            // dispose: object with X, Y of the last line add to the PDF
            //          this allow the insertion of new lines after html
            doc.save('Test.pdf');
        }, margins);
}