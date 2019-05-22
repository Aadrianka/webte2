
function setListeners () {
    $("input.loginBtn").click( function () {
        //var val = $("select#type").val();
        var val = $(this).attr('name');
        if (val == "01")
            showLogin();
        else if (val == "02")
            showLDAP();

    });


    $("input#backButtonLogin").click( function () {
        showChoice();
    });

    $("input#backButtonLDAP").click( function () {
        showChoice();
    });


    $("button#logoutButt").click( function () {
        $.ajax({
            url: 'index.php',
            async: false,
            data: {action : 'logout'},
            type : 'post',
            success : function (output) {
            }
        });
        showChoice();
    });
    $("img#sk").click( function () {
        $.ajax({
            url: 'index.php',
            async: false,
            data: {action : 'changeLanguage', lang : "sk" },
            type : 'post',
            success : function (output) {
                //console.log(output);
                location.reload(true);
            }
        });
    });
    $("img#en").click( function () {
        $.ajax({
            url: 'index.php',
            async: false,
            data: {action : 'changeLanguage', lang : "en" },
            type : 'post',
            success : function (output) {
                location.reload(true);
            }
        });
    });

}

function showChoice() {
    $("div#choice").css("display", "block");
    $("div#login").css("display", "none");
    $("div#LDAP").css("display", "none");
    $("div#welcome").css("display", "none");
    $('#content').html("");
}
function showLogin() {
    $("div#choice").css("display", "none");
    $("div#login").css("display", "block");
    $("div#LDAP").css("display", "none");
}

function showNothing() {
    $("div#choice").css("display", "none");
    $("div#login").css("display", "none");
    $("div#LDAP").css("display", "none");
}

function showLDAP() {
    $("div#choice").css("display", "none");
    $("div#login").css("display", "none");
    $("div#LDAP").css("display", "block");
}

