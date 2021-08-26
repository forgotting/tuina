/*$(function () {
});*/
$(document).on('ready pjax:end', function() {
    const body_x = $(".irs-single:first");
    const body_y = $(".irs-single:eq(1)");
    const ear_x = $(".irs-single:eq(2)");
    const ear_y = $(".irs-single:last");

    ear_x.on("DOMNodeInserted", function() {
        const x = ear_x.html();
        const y = ear_y.html();
        const ear_html = "<circle cx="+x+" cy="+y+" r='5' id='ear' stroke='black' stroke-width='2' fill='red'/>";
        $("#ear_svg").html(ear_html);  
    });
    ear_y.on("DOMNodeInserted", function() {
        const x = ear_x.html();
        const y = ear_y.html();
        const ear_html = "<circle cx="+x+" cy="+y+" r='5' id='ear' stroke='black' stroke-width='2' fill='red'/>";
        $("#ear_svg").html(ear_html);  
    });

    body_x.on("DOMNodeInserted", function() {
        const x = body_x.html();
        const y = body_y.html();
        const body_html = "<circle cx="+x+" cy="+y+" r='3' id='body' stroke='black' stroke-width='1' fill='red'/>";
        $("#body_image").html(body_html);  
    });
    body_y.on("DOMNodeInserted", function() {
        const x = body_x.html();
        const y = body_y.html();
        const body_html = "<circle cx="+x+" cy="+y+" r='3' id='body' stroke='black' stroke-width='1' fill='red'/>";
        $("#body_image").html(body_html);  
    });
    
    /*$("#ear_x").on("change", function() {
        var y = $("#ear_y").val();
        var ear_html = "<circle cx="+this.value+" cy="+y+" r='5' stroke='black' stroke-width='2' fill='red'/>";
        $("#ear_svg").html(ear_html);  
    })
    $('#ear_y').on("change", function() {
        var x = $("#ear_x").val();
        var ear_html = "<circle cx="+x+" cy="+this.value+" r='5' stroke='black' stroke-width='2' fill='red'/>";
        $("#ear_svg").html(ear_html);  
    })
    $("#body_x").on("change", function() {
        var y = $("#body_y").val();
        var body_html = "<circle cx="+this.value+" cy="+y+" r='3' stroke='black' stroke-width='1' fill='red'/>";
        $("#body_image").html(body_html);  
    })
    $("#body_y").on("change", function() {
        var x = $("#body_x").val();
        var body_html = "<circle cx="+x+" cy="+this.value+" r='3' stroke='black' stroke-width='1' fill='red'/>";
        $("#body_image").html(body_html);  
    })*/
});
