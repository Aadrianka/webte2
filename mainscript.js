
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
            data: {action : 'logout'},
            type : 'post',
            success : function (output) {
                console.log(output);
            }
        });
        showChoice();
    });

}

function showChoice() {
    $("div#choice").css("display", "block");
    $("div#login").css("display", "none");
    $("div#LDAP").css("display", "none");
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

