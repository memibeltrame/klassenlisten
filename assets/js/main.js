
    $(function(){
        // PUT YOUR JAVASCRIPT HERE BELOW

        //livesearch example
        $('.typeahead').typeahead({
              source: ['foo bar','foo fighters','a fools errand','football'],
              limit: 10
        });

        // Datepicker
        $('.input-group.date, .date').datepicker({
            language: "de",
            orientation: "auto left",
            format: "dd.mm.yyyy",
            autoclose: true,
            todayHighlight: true
        });

        $('input[type=file]').bootstrapFileInput();

        $(".withfadeout").delay(3000).fadeOut();

        $(".showSpinner").click(function() {
            $("#" + $(this).attr("data-name")).submit();
            $(this).html('<i class="fa fa-spinner fa-spin"></i> am senden');
        });

        $("#toggleAdressliste").click(function() {
            $(".listenEintrag").toggleClass("hide");
        });

        $(".pileimg").click(function() {
            if($(this).hasClass("highlight")){
                $("#userinfo").html("");
                $(".pileimg").removeClass("highlight");
                $(".pileimg img").css({ opacity: 1 });
            } else {
                $("#userinfo").html($(this).data("name"));
                $("#userinfo").attr("href","profil.php?id="+$(this).data("id"));
                $(".pileimg img").css({ opacity: 0.5 });
                $(".pileimg").removeClass("highlight");
                $(this).children().first().css({ opacity: 1 });
                $(this).addClass("highlight");

            }
        });

        $(".toggleListenView").click(function() {
            $(".pile").toggleClass("hidden-xs");

            $(".toggleListenView").each(function() {
                var $this = $(this);
                if ($this.attr('disabled')) $this.removeAttr('disabled');
                else $this.attr('disabled', 'disabled');
            });

        });

        $(".toggleForm").click(function() {
            $(".formElement").toggleClass("hide");
        });

        $(".abwesend").click(function() {
            var id = $(this).data("id");
            if($(this).hasClass("btn-primary")){
                $(this).removeClass("btn-primary");
                $("#grund"+id).addClass("hide");
                $("#formAbwesend"+id).val("");
                return;
            }
            $(this).addClass("btn-primary");
            $(".abwesend"+id).not(this).removeClass("btn-primary");
            if($(this).hasClass("entschuldigt")){
                $("#grund"+id).removeClass("hide");
                $("#formAbwesend"+id).val("Entschuldigt");
            } else {
                $("#grund"+id).addClass("hide");
                $("#formAbwesend"+id).val("Abwesend");
            }

        });

        $("#absenzen").click(function() {
            document.location.href = "absenzen.php";
        });

        $(".tagespicker").click(function() {
            $(".tagespicker").removeClass("btn-primary");
            $(this).addClass("btn-primary");

            $('.input-group.date').datepicker('update', new Date($(this).data("date")));
        });


        $(".manuellerGrund").focus(function() {
            console.log($("#radiogrund"+$(this).data("id")).prop("checked"));
            $("#radiogrund"+$(this).data("id")).prop("checked", true);
        });

        $(".manuellerGrund").change(function() {
            console.log($("#radiogrund"+$(this).data("id")).prop("checked"));
            $("#radiogrund"+$(this).data("id")).val($(this).val());
        });


        $(".dauer").click(function() {
            id = $(this).data("id");
            value = $("#dauer"+id).val();
            if($(this).hasClass("btn-primary")){
                value = value - $(this).data("wert");
                $(this).removeClass("btn-primary");
            } else {
                value = value + $(this).data("wert");
                $(this).addClass("btn-primary");
            }
            $("#dauer"+id).val(value)
            $(".abwesend"+id).removeClass("disabled");

        });

        $('.mypopover').popover();



        $( "body" ).on( "click", "#dozentenLogin", function() {


          // Get some values from elements on the page:
          var $form = $( "#loginform" ),
            email = $form.find( "input[name='email']" ).val(),
            passwort = $form.find( "input[name='passwort']" ).val(),
            url = "checkLogin.php";

          // Send the data using post
          var posting = $.post( url, { email: email,  passwort: passwort  } );

          // Put the results in a div
          posting.done(function( data ) {
            var obj = JSON.parse( data );
            console.log(obj.status);
            if(obj.status == "Error"){
                $("#errorMessage").html(obj.msg);
                $("#loginError").removeClass("hide");
            } else {
                window.location.href = "absenzen.php";
            }
          });
        });




    })